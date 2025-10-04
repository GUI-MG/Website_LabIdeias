<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['usuario'])) header("Location: login.php");

$erro = '';
$sucesso = '';

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
        // Inserir projeto
        $stmt = $conn->prepare("INSERT INTO projetos (titulo, resumo, descricao, situacao, periodo_situacao) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $titulo, $resumo, $descricao, $situacao, $periodo_situacao);
        if ($stmt->execute()) {
            $id_projeto = $stmt->insert_id;
            $stmt->close();

            // Inserir participantes
            $stmt2 = $conn->prepare("INSERT INTO participantes (id_projeto, nome_completo, tipo) VALUES (?, ?, ?)");
            foreach ($participantes as $p) {
                $nome = trim($p['nome']);
                $tipo = trim($p['tipo']);
                if ($nome && $tipo) {
                    $stmt2->bind_param("iss", $id_projeto, $nome, $tipo);
                    $stmt2->execute();
                }
            }
            $stmt2->close();

            $sucesso = "Projeto cadastrado com sucesso!";
        } else {
            $erro = "Erro ao cadastrar projeto: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cadastrar Projeto - Laboratório de Ideias</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

<!-- NAVBAR -->
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
        <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-arrow-return-right"></i> Voltar</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
    <h2 class="mb-4 text-center"><i class="bi bi-plus-lg"></i> Cadastrar Projeto</h2>

    <?php if($erro): ?>
        <div class="alert alert-danger"><?= $erro ?></div>
    <?php endif; ?>
    <?php if($sucesso): ?>
        <div class="alert alert-success"><?= $sucesso ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Resumo</label>
            <input type="text" name="resumo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Período do Projeto</label>
            <input type="text" name="periodo_situacao" class="form-control" placeholder="Ex: 2025.1" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Situação</label>
            <select name="situacao" class="form-select" required>
                <option value="">Selecione...</option>
                <option value="Planejamento">Planejamento</option>
                <option value="Em andamento">Em andamento</option>
                <option value="Concluído">Concluído</option>
            </select>
        </div>

        <h5 class="mt-4">Participantes</h5>
        <small>Insira pelo menos 2 participantes</small>
        <div id="participantes-container">
            <div class="row mb-2 participante-item">
                <div class="col">
                    <input type="text" name="participantes[0][nome]" class="form-control" placeholder="Nome do participante" required>
                </div>
                <div class="col">
                    <select name="participantes[0][tipo]" class="form-select" required>
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
            </div>
            <div class="row mb-2 participante-item">
                <div class="col">
                    <input type="text" name="participantes[1][nome]" class="form-control" placeholder="Nome do participante" required>
                </div>
                <div class="col">
                    <select name="participantes[1][tipo]" class="form-select" required>
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
            </div>
        </div>
        <button type="button" class="btn btn-secondary mb-3" id="add-participante"><i class="bi bi-plus"></i> Adicionar participante</button>

        <button type="submit" class="btn btn-primary w-100">Cadastrar Projeto</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script>
let participanteIndex = 2;
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
