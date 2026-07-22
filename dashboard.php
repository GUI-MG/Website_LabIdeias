<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$usuarioLogado = $_SESSION['usuario'];

// Conexão com banco
$host = 'localhost';
$db   = 'bd_lab_ideias';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Erro na conexão: " . $conn->connect_error);

// Buscar número de ideias cadastradas
$resultIdeias = $conn->query("SELECT COUNT(*) AS total FROM ideia");
$totalIdeias = $resultIdeias->fetch_assoc()['total'] ?? 0;

// Buscar número de projetos cadastrados
$resultProjetos = $conn->query("SELECT COUNT(*) AS total FROM projeto");
$totalProjetos = $resultProjetos->fetch_assoc()['total'] ?? 0;

// Buscar número de usuários cadastrados
$resultUsuarios = $conn->query("SELECT COUNT(*) AS total FROM usuario");
$totalUsuarios = $resultUsuarios->fetch_assoc()['total'] ?? 0;

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Laboratório de Ideias</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<link href="assets/css/style.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<style>
nav {
    background: linear-gradient(to right, rgb(80, 230, 70), rgb(80, 160, 60));
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

body {
    background-color: #f8f9fa;
}

.card-container {
    border-radius: 1rem;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.card-container:hover {
    transform: scale(1.05);
}

.card-body {
    text-align: center;
}

.dashboard-header {
    margin-bottom: 40px;
}

.btn-dashboard {
    margin-top: 15px;
}
</style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="assets/img/logo.png" alt="Logo Lab Ideias"  height="180">
      </a>
      <a class="navbar-brand" href="https://ifrs.edu.br/feliz/">
        <img src="assets/img/ifrs-logo.svg" alt="Logo IFRS" height="180">
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
            <button id="indexNavButton" onclick="window.location.href='logout.php'">
              <i class="bi bi-person-fill-down"></i> Sair
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
    </div>

    <?php include 'footer.php'?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>