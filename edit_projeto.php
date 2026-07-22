<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['usuario'])) header("Location: login.php");

$erro = '';
$sucesso = '';

$titulo = '';
$resumo = '';
$descricao = '';
$situacao = '';
$inicio = '';
$termino = '';
$participantes = [];

if (!isset($_GET['id'])) {
    die("ID do projeto não fornecido.");
}

$id_projeto = (int)$_GET['id'];

// --- Buscar dados existentes ---
$stmt = $conn->prepare("SELECT titulo, resumo, descricao, situacao, inicio, termino FROM projeto WHERE id = ?");
$stmt->bind_param("i", $id_projeto);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Projeto não encontrado.");
}
$projeto = $result->fetch_assoc();
$titulo = $projeto['titulo'];
$resumo = $projeto['resumo'];
$descricao = $projeto['descricao'];
$situacao = $projeto['situacao'];
$inicio = $projeto['inicio'];
$termino = $projeto['termino'];
$stmt->close();

// Buscar participantes
$sql = "SELECT p.nome_completo, p.tipo
        FROM realiza r JOIN participante p ON r.fk_participante_id = p.id
        WHERE r.fk_projeto_id = $id_projeto";
$stmt = $conn->prepare($sql);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $participantes[] = ['nome' => $row['nome_completo'], 'tipo' => $row['tipo']];
}
$stmt->close();

// --- Salvar alterações ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $resumo = trim($_POST['resumo']);
    $descricao = trim($_POST['descricao']);
    $situacao = $_POST['situacao'];
    $inicio = trim($_POST['inicio']);
    $termino = trim($_POST['termino']) ? trim($_POST['termino']) : null;
    $participantes = $_POST['participantes'] ?? [];

    // Validações
    if (!$titulo || !$resumo || !$descricao || !$situacao || !$inicio) {
        $erro = "Preencha todos os campos do projeto.";
    } elseif (count($participantes) < 2) {
        $erro = "Insira pelo menos 2 participantes.";
    } else {
        // Atualizar projeto
        $stmt = $conn->prepare("UPDATE projeto SET titulo=?, resumo=?, descricao=?, situacao=?, inicio=?, termino=? WHERE id=?");
        $stmt->bind_param("ssssssi", $titulo, $resumo, $descricao, $situacao, $inicio, $termino, $id_projeto);
        if ($stmt->execute()) {
            $stmt->close();

            // Excluir relação com participantes antigos
            $conn->query("DELETE FROM realiza WHERE fk_projeto_id=$id_projeto");
            // Excluir participantes antigos caso não estejam mais relacionados a nenhum projeto
            $conn->query("DELETE FROM participante
            WHERE id IN (SELECT fk_participante_id FROM realiza WHERE fk_projeto_id=$id_projeto)
            AND id NOT IN (SELECT fk_participante_id FROM realiza WHERE fk_projeto_id=$id_projeto)");

            // Pegar participantes existentes
            $stmt = $conn->prepare("SELECT nome_completo, tipo FROM participante");
            $stmt->execute();
            $existentes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            foreach ($participantes as $p) {
                $nome = trim($p['nome']);
                $tipo = trim($p['tipo']);

                if ($nome && $tipo) {
                    $id_participante = null;
                    if (!in_array(['nome_completo' => $nome, 'tipo' => $tipo], $existentes)) {
                        $conn->query("INSERT INTO participante (id, nome_completo, tipo) VALUES (DEFAULT, '$nome', '$tipo')");
                        $id_participante = $conn->insert_id;
                    } else {
                        $result = $conn->query("SELECT id FROM participante WHERE nome_completo = '$nome' AND tipo = '$tipo'");
                        $row = $result->fetch_assoc();
                        $id_participante = $row['id'];
                    }
                    // Criar relação entre projeto e participante
                    $conn->query("INSERT INTO realiza (fk_projeto_id, fk_participante_id) VALUES ($id_projeto, $id_participante)");
                }
            }


            $sucesso = "Projeto atualizado com sucesso!";
        } else {
            $erro = "Erro ao atualizar projeto: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Projeto - Laboratório de Ideias</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="index.php"><img src="assets/img/logo.png" alt="Logo Lab Ideias" height="80"></a>
    <a class="navbar-brand" href="https://ifrs.edu.br/feliz/"><img src="assets/img/ifrs-logo.svg" alt="Logo IFRS" height="80"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav-actions">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <button id="indexNavButton" onclick="window.location.href='index.php'">
                <i class="bi bi-house-fill"></i> Início
            </button>
        </li>
        <li class="nav-item">
            <button id="indexNavButton" onclick="window.location.href='dashboard_projetos.php'">
                <i class="bi bi-arrow-return-right"></i> Voltar
            </button>
        </li>
      </ul>
    </div>
  </div>
</nav>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-house-fill"></i>
                            Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="dashboard_projetos.php"><i
                                class="bi bi-arrow-return-right"></i> Voltar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h2 class="mb-4 text-center"><i class="bi bi-pencil-square"></i> Editar Projeto</h2>

        <?php if($erro): ?>
        <div class="alert alert-danger"><?= $erro ?></div>
        <?php endif; ?>
        <?php if($sucesso): ?>
        <div class="alert alert-success"><?= $sucesso ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($titulo) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Resumo</label>
                <input type="text" name="resumo" class="form-control" value="<?= htmlspecialchars($resumo) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="4"
                    required><?= htmlspecialchars($descricao) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Início do Projeto</label>
                <input type="date" name="inicio" class="form-control" value="<?= htmlspecialchars($inicio) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Fim do Projeto (opcional)</label>
                <input type="date" name="termino" class="form-control" value="<?= htmlspecialchars($termino) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Situação</label>
                <select name="situacao" class="form-select" required>
                    <option value="">Selecione...</option>
                    <option value="planejamento" <?= $situacao=='planejamento'?'selected':'' ?>>Planejamento</option>
                    <option value="em andamento" <?= $situacao=='em andamento'?'selected':'' ?>>Em andamento</option>
                    <option value="concluído" <?= $situacao=='concluído'?'selected':'' ?>>Concluído</option>
                </select>
            </div>

            <h5 class="mt-4">Participantes</h5>
            <small>Insira pelo menos 2 participantes</small>
            <div id="participantes-container">
                <?php
            if (!empty($participantes)) {
                foreach ($participantes as $i => $p) {
                    $nome = htmlspecialchars($p['nome'] ?? '');
                    $tipo = htmlspecialchars($p['tipo'] ?? '');
                    echo '<div class="row mb-2 participante-item">
                        <div class="col">
                            <input type="text" name="participantes['.$i.'][nome]" class="form-control" placeholder="Nome do participante" value="'.$nome.'" required>
                        </div>
                        <div class="col">
                            <select name="participantes['.$i.'][tipo]" class="form-select" required>
                                <option value="">Selecione o tipo...</option>
                                <option value="bolsista" '.($tipo=='bolsista'?'selected':'').'>Bolsista</option>
                                <option value="voluntário" '.($tipo=='voluntário'?'selected':'').'>Voluntário</option>
                                <option value="coordenador" '.($tipo=='coordenador'?'selected':'').'>Coordenador</option>
                                <option value="colaborador" '.($tipo=='colaborador'?'selected':'').'>Colaborador</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger remove-participante">Remover</button>
                        </div>
                    </div>';
                }
            } else {
                for ($i=0;$i<2;$i++) {
                    echo '<div class="row mb-2 participante-item">
                        <div class="col">
                            <input type="text" name="participantes['.$i.'][nome]" class="form-control" placeholder="Nome do participante" required>
                        </div>
                        <div class="col">
                            <select name="participantes['.$i.'][tipo]" class="form-select" required>
                                <option value="">Selecione o tipo...</option>
                                <option value="bolsista">Bolsista</option>
                                <option value="voluntário">Voluntário</option>
                                <option value="coordenador">Coordenador</option>
                                <option value="colaborador">Colaborador</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger remove-participante">Remover</button>
                        </div>
                    </div>';
                }
            }
            ?>
            </div>
            <button type="button" class="btn btn-secondary mb-3" id="add-participante"><i class="bi bi-plus"></i>
                Adicionar participante</button>

            <button type="submit" class="btn btn-primary w-100">Salvar Alterações</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let participanteIndex = <?= !empty($participantes) ? count($participantes) : 2 ?>;
    document.getElementById('add-participante').addEventListener('click', function() {
        const container = document.getElementById('participantes-container');
        const div = document.createElement('div');
        div.classList.add('row', 'mb-2', 'participante-item');
        div.innerHTML = `
        <div class="col">
            <input type="text" name="participantes[${participanteIndex}][nome]" class="form-control" placeholder="Nome do participante" required>
        </div>
        <div class="col">
            <select name="participantes[${participanteIndex}][tipo]" class="form-select" required>
                <option value="">Selecione o tipo...</option>
                <option value="bolsista">Bolsista</option>
                <option value="voluntário">Voluntário</option>
                <option value="coordenador">Coordenador</option>
                <option value="colaborador">Colaborador</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-danger remove-participante">Remover</button>
        </div>
    `;
        container.appendChild(div);
        participanteIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-participante')) {
            const row = e.target.closest('.participante-item');
            row.remove();
        }
    });
    </script>

</body>

</html>