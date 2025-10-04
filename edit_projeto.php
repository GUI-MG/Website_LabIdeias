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
$periodo_situacao = '';
$participantes = [];

if (!isset($_GET['id'])) {
    die("ID do projeto não fornecido.");
}

$id_projeto = (int)$_GET['id'];

// --- Buscar dados existentes ---
$stmt = $conn->prepare("SELECT titulo, resumo, descricao, situacao, periodo_situacao FROM projetos WHERE id = ?");
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
$periodo_situacao = $projeto['periodo_situacao'];
$stmt->close();

// Buscar participantes
$stmt = $conn->prepare("SELECT nome_completo, tipo FROM participantes WHERE id_projeto = ?");
$stmt->bind_param("i", $id_projeto);
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
    $periodo_situacao = trim($_POST['periodo_situacao']);
    $participantes = $_POST['participantes'] ?? [];

    // Validações
    if (!$titulo || !$resumo || !$descricao || !$situacao || !$periodo_situacao) {
        $erro = "Preencha todos os campos do projeto.";
    } elseif (count($participantes) < 2) {
        $erro = "Insira pelo menos 2 participantes.";
    } else {
        // Atualizar projeto
        $stmt = $conn->prepare("UPDATE projetos SET titulo=?, resumo=?, descricao=?, situacao=?, periodo_situacao=? WHERE id=?");
        $stmt->bind_param("sssssi", $titulo, $resumo, $descricao, $situacao, $periodo_situacao, $id_projeto);
        if ($stmt->execute()) {
            $stmt->close();

            // Excluir participantes antigos
            $stmt = $conn->prepare("DELETE FROM participantes WHERE id_projeto=?");
            $stmt->bind_param("i", $id_projeto);
            $stmt->execute();
            $stmt->close();

            // Inserir participantes atualizados
            $stmt = $conn->prepare("INSERT INTO participantes (id_projeto, nome_completo, tipo) VALUES (?, ?, ?)");
            foreach ($participantes as $p) {
                $nome = trim($p['nome']);
                $tipo = trim($p['tipo']);
                if ($nome && $tipo) {
                    $stmt->bind_param("iss", $id_projeto, $nome, $tipo);
                    $stmt->execute();
                }
            }
            $stmt->close();

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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#"><img src="assets/img/logo.png" alt="Logo Lab Ideias" height="80"></a>
    <a class="navbar-brand" href="#"><img src="assets/img/ifrs-logo.svg" alt="Logo IFRS" height="80"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-house-fill"></i> Início</a></li>
        <li class="nav-item"><a class="nav-link" href="dashboard_projetos.php"><i class="bi bi-arrow-return-right"></i> Voltar</a></li>
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
            <textarea name="descricao" class="form-control" rows="4" required><?= htmlspecialchars($descricao) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Período do Projeto</label>
            <input type="text" name="periodo_situacao" class="form-control" placeholder="Ex: 2025.1" value="<?= htmlspecialchars($periodo_situacao) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Situação</label>
            <select name="situacao" class="form-select" required>
                <option value="">Selecione...</option>
                <option value="Planejamento" <?= $situacao=='Planejamento'?'selected':'' ?>>Planejamento</option>
                <option value="Em andamento" <?= $situacao=='Em andamento'?'selected':'' ?>>Em andamento</option>
                <option value="Concluído" <?= $situacao=='Concluído'?'selected':'' ?>>Concluído</option>
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
                                <option value="Bolsista" '.($tipo=='Bolsista'?'selected':'').'>Bolsista</option>
                                <option value="Voluntário" '.($tipo=='Voluntário'?'selected':'').'>Voluntário</option>
                                <option value="Coordenador" '.($tipo=='Coordenador'?'selected':'').'>Coordenador</option>
                                <option value="Colaborador" '.($tipo=='Colaborador'?'selected':'').'>Colaborador</option>
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
                                <option value="Bolsista">Bolsista</option>
                                <option value="Voluntário">Voluntário</option>
                                <option value="Coordenador">Coordenador</option>
                                <option value="Colaborador">Colaborador</option>
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
        <button type="button" class="btn btn-secondary mb-3" id="add-participante"><i class="bi bi-plus"></i> Adicionar participante</button>

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
                <option value="Bolsista">Bolsista</option>
                <option value="Voluntário">Voluntário</option>
                <option value="Coordenador">Coordenador</option>
                <option value="Colaborador">Colaborador</option>
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
    if(e.target && e.target.classList.contains('remove-participante')) {
        const row = e.target.closest('.participante-item');
        row.remove();
    }
});
</script>

</body>
</html>
