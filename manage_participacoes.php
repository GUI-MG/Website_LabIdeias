<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$erro = '';
$nome = '';
$ano = '';
$projetosSelecionados = [];
$idEdicao = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT) ?: 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf_token'], $token)) {
        $erro = 'A sessão do formulário expirou. Atualize a página e tente novamente.';
    } else {
        $acao = $_POST['acao'] ?? '';
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

        if ($acao === 'excluir') {
            if (!$id || $id < 1) {
                $erro = 'Participação inválida.';
            } else {
                try {
                    $conn->begin_transaction();
                    $stmt = $conn->prepare('SELECT id FROM participacao WHERE id = ?');
                    $stmt->bind_param('i', $id);
                    $stmt->execute();
                    $participacaoExiste = $stmt->get_result()->num_rows > 0;
                    $stmt->close();
                    if (!$participacaoExiste) {
                        throw new RuntimeException('A participação não foi encontrada.');
                    }

                    $stmt = $conn->prepare('DELETE FROM participa WHERE fk_participacao_id = ?');
                    $stmt->bind_param('i', $id);
                    $stmt->execute();
                    $stmt->close();

                    $stmt = $conn->prepare('DELETE FROM participacao WHERE id = ?');
                    $stmt->bind_param('i', $id);
                    $stmt->execute();
                    $stmt->close();
                    $conn->commit();

                    header('Location: manage_participacoes.php?excluida=1');
                    exit;
                } catch (Throwable $e) {
                    $conn->rollback();
                    $erro = 'Não foi possível excluir a participação: ' . $e->getMessage();
                }
            }
        } elseif ($acao === 'salvar') {
            $nome = trim($_POST['nome'] ?? '');
            $ano = trim($_POST['ano'] ?? '');
            $projetosSelecionados = $_POST['projetos'] ?? [];
            $idEdicao = $id && $id > 0 ? $id : 0;

            if ($nome === '' || mb_strlen($nome) > 40) {
                $erro = 'Informe um nome com até 40 caracteres.';
            } elseif (!preg_match('/^\d{4}$/', $ano) || (int)$ano < 1000 || (int)$ano > 9999) {
                $erro = 'Informe um ano válido com quatro dígitos.';
            } elseif (!is_array($projetosSelecionados)) {
                $erro = 'A lista de projetos selecionados é inválida.';
            } else {
                $projetosValidados = [];
                foreach ($projetosSelecionados as $projetoId) {
                    $idProjeto = filter_var($projetoId, FILTER_VALIDATE_INT);
                    if ($idProjeto === false || $idProjeto < 1) {
                        $erro = 'A lista de projetos selecionados é inválida.';
                        break;
                    }
                    $projetosValidados[] = $idProjeto;
                }

                if (!$erro) {
                    $projetosSelecionados = array_values(array_unique($projetosValidados));
                    $dataAno = $ano . '-01-01';

                    try {
                        $conn->begin_transaction();

                        if ($idEdicao > 0) {
                            $stmt = $conn->prepare('SELECT id FROM participacao WHERE id = ?');
                            $stmt->bind_param('i', $idEdicao);
                            $stmt->execute();
                            $participacaoExiste = $stmt->get_result()->num_rows > 0;
                            $stmt->close();
                            if (!$participacaoExiste) {
                                throw new RuntimeException('A participação não foi encontrada.');
                            }

                            $stmt = $conn->prepare('UPDATE participacao SET nome = ?, ano = ? WHERE id = ?');
                            $stmt->bind_param('ssi', $nome, $dataAno, $idEdicao);
                            $stmt->execute();
                            $stmt->close();
                            $idParticipacao = $idEdicao;

                            $stmt = $conn->prepare('DELETE FROM participa WHERE fk_participacao_id = ?');
                            $stmt->bind_param('i', $idParticipacao);
                            $stmt->execute();
                            $stmt->close();
                        } else {
                            $stmt = $conn->prepare('INSERT INTO participacao (nome, ano) VALUES (?, ?)');
                            $stmt->bind_param('ss', $nome, $dataAno);
                            $stmt->execute();
                            $idParticipacao = $stmt->insert_id;
                            $stmt->close();
                        }

                        $stmtProjeto = $conn->prepare('SELECT id FROM projeto WHERE id = ?');
                        $stmtAssociacao = $conn->prepare('INSERT INTO participa (fk_projeto_id, fk_participacao_id) VALUES (?, ?)');
                        foreach ($projetosSelecionados as $idProjeto) {
                            $stmtProjeto->bind_param('i', $idProjeto);
                            $stmtProjeto->execute();
                            if ($stmtProjeto->get_result()->num_rows === 0) {
                                throw new RuntimeException('Um dos projetos selecionados não existe.');
                            }
                            $stmtAssociacao->bind_param('ii', $idProjeto, $idParticipacao);
                            $stmtAssociacao->execute();
                        }
                        $stmtProjeto->close();
                        $stmtAssociacao->close();
                        $conn->commit();

                        header('Location: manage_participacoes.php?salva=1');
                        exit;
                    } catch (Throwable $e) {
                        $conn->rollback();
                        $erro = 'Não foi possível salvar a participação: ' . $e->getMessage();
                    }
                }
            }
        } else {
            $erro = 'Ação inválida.';
        }
    }
}

$projetos = [];
$resultadoProjetos = $conn->query('SELECT id, titulo FROM projeto ORDER BY titulo');
while ($projeto = $resultadoProjetos->fetch_assoc()) {
    $projetos[] = $projeto;
}

if ($idEdicao > 0 && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $stmt = $conn->prepare('SELECT nome, ano FROM participacao WHERE id = ?');
    $stmt->bind_param('i', $idEdicao);
    $stmt->execute();
    $participacaoEdicao = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$participacaoEdicao) {
        $erro = 'A participação solicitada não foi encontrada.';
        $idEdicao = 0;
    } else {
        $nome = $participacaoEdicao['nome'];
        $ano = $participacaoEdicao['ano'] ? date('Y', strtotime($participacaoEdicao['ano'])) : '';
        $stmt = $conn->prepare('SELECT fk_projeto_id FROM participa WHERE fk_participacao_id = ?');
        $stmt->bind_param('i', $idEdicao);
        $stmt->execute();
        $resultadoAssociacoes = $stmt->get_result();
        while ($associacao = $resultadoAssociacoes->fetch_assoc()) {
            $projetosSelecionados[] = (int)$associacao['fk_projeto_id'];
        }
        $stmt->close();
    }
}

$participacoes = [];
$sql = 'SELECT p.id, p.nome, p.ano,
               GROUP_CONCAT(DISTINCT pr.titulo ORDER BY pr.titulo SEPARATOR ", ") AS projetos
        FROM participacao p
        LEFT JOIN participa pa ON pa.fk_participacao_id = p.id
        LEFT JOIN projeto pr ON pr.id = pa.fk_projeto_id
        GROUP BY p.id, p.nome, p.ano
        ORDER BY p.ano DESC, p.nome';
$resultadoParticipacoes = $conn->query($sql);
while ($participacao = $resultadoParticipacoes->fetch_assoc()) {
    $participacoes[] = $participacao;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerenciar Participações - Laboratório de Ideias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/img/logo_simples.png" type="image/x-icon">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark-green">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                <img src="assets/img/logo_simples.png" alt="Logo Lab Ideias" class="navbar-logo">
                <span class="brand-name">LABORATÓRIO<br>DE IDEIAS</span>
            </a>
            <div class="ms-auto d-flex gap-3">
                <a class="nav-link text-white" href="index.php"><i class="bi bi-house-fill"></i> Início</a>
                <a class="nav-link text-white" href="dashboard.php"><i class="bi bi-arrow-return-right"></i> Voltar</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <h2 class="mb-4"><i class="bi bi-trophy-fill text-warning"></i> Gerenciar Participações</h2>

        <?php if ($erro): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['salva'])): ?>
        <div class="alert alert-success">Participação salva com sucesso.</div>
        <?php endif; ?>
        <?php if (isset($_GET['excluida'])): ?>
        <div class="alert alert-success">Participação excluída com sucesso.</div>
        <?php endif; ?>

        <section class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h3 class="h5"><?= $idEdicao ? 'Editar participação' : 'Nova participação' ?></h3>
                <form method="post">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="acao" value="salvar">
                    <input type="hidden" name="id" value="<?= (int)$idEdicao ?>">

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="nome" class="form-label">Nome da participação</label>
                            <input type="text" id="nome" name="nome" class="form-control" maxlength="40" value="<?= htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="ano" class="form-label">Ano</label>
                            <input type="number" id="ano" name="ano" class="form-control" min="1000" max="9999" step="1" value="<?= htmlspecialchars($ano, ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                    </div>

                    <fieldset class="mb-3">
                        <legend class="form-label fs-6">Projetos relacionados (opcional)</legend>
                        <?php if ($projetos): ?>
                        <div class="row">
                            <?php foreach ($projetos as $projeto): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="projetos[]" value="<?= (int)$projeto['id'] ?>" id="projeto-<?= (int)$projeto['id'] ?>" <?= in_array((int)$projeto['id'], $projetosSelecionados, true) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="projeto-<?= (int)$projeto['id'] ?>"><?= htmlspecialchars($projeto['titulo'], ENT_QUOTES, 'UTF-8') ?></label>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <p class="text-muted mb-0">Cadastre um projeto antes de associá-lo a uma participação.</p>
                        <?php endif; ?>
                    </fieldset>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Salvar</button>
                    <?php if ($idEdicao): ?>
                    <a href="manage_participacoes.php" class="btn btn-outline-secondary">Cancelar</a>
                    <?php endif; ?>
                </form>
            </div>
        </section>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle bg-white">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Ano</th>
                        <th>Projetos relacionados</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$participacoes): ?>
                    <tr><td colspan="4" class="text-center text-muted">Nenhuma participação cadastrada.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($participacoes as $participacao): ?>
                    <tr>
                        <td><?= htmlspecialchars($participacao['nome'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= $participacao['ano'] ? htmlspecialchars(date('Y', strtotime($participacao['ano'])), ENT_QUOTES, 'UTF-8') : '' ?></td>
                        <td><?= htmlspecialchars($participacao['projetos'] ?: 'Nenhum projeto associado', ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="text-nowrap">
                            <a href="manage_participacoes.php?edit=<?= (int)$participacao['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <form method="post" class="d-inline" onsubmit="return confirm('Excluir esta participação?');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="acao" value="excluir">
                                <input type="hidden" name="id" value="<?= (int)$participacao['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
