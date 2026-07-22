<!-- Arquivo: edit.php -->
<?php
require_once 'db.php';
// Busca ideia por ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $conn->prepare('SELECT * FROM ideia WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$ideia = $result->fetch_assoc();
$stmt->close();

$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $email     = trim($_POST['email']);
    if ($titulo && $descricao && $email) {
        $stmt = $conn->prepare(
            'UPDATE ideia SET titulo = ?, descricao = ?, email = ? WHERE id = ?'
        );
        $stmt->bind_param('sssi', $titulo, $descricao, $email, $id);
        if ($stmt->execute()) {
            $success = 'Ideia atualizada com sucesso!';
        } else {
            $error = 'Erro ao atualizar ideia: ' . $stmt->error;
        }
        $stmt->close();
        // Redireciona após atualização
        header('Location: manage.php'); exit;
    } else {
        $error = 'Por favor, preencha todos os campos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Ideia - Laboratório de Ideais</title>

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

<body>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
 <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="assets/img/logo.png" alt="Logo Lab Ideias"  height="320">
      </a>
      <a class="navbar-brand" href="https://ifrs.edu.br/feliz/">
        <img src="assets/img/ifrs-logo.svg" alt="Logo IFRS" height="320">
      </a>
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
            <button id="indexNavButton" onclick="window.location.href='manage.php'">
              <i class="bi bi-arrow-return-right"></i> Voltar
            </button>
          </li>
        </ul>
      </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>