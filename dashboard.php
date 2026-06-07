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
$resultIdeias = $conn->query("SELECT COUNT(*) AS total FROM ideias");
$totalIdeias = $resultIdeias->fetch_assoc()['total'] ?? 0;

// Buscar número de projetos cadastrados
$resultProjetos = $conn->query("SELECT COUNT(*) AS total FROM projetos");
$totalProjetos = $resultProjetos->fetch_assoc()['total'] ?? 0;

// Buscar número de usuários cadastrados
$resultUsuarios = $conn->query("SELECT COUNT(*) AS total FROM usuarios");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
       nav {
        background: linear-gradient(to right, rgb(80, 230, 70), rgb(80, 160, 60));
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        body { background-color: #f8f9fa; }
        .card-container {
            border-radius: 1rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .card-container:hover { transform: scale(1.05); }
        .card-body { text-align: center; }
        .dashboard-header { margin-bottom: 40px;}
        .btn-dashboard { margin-top: 15px; }
    </style>
</head>
<body>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
 
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark-green">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <img src="assets/img/logo_simples.png" alt="Logo Lab Ideias" class="navbar-logo">
      <span class="brand-name">LABORATÓRIO<br>DE IDEIAS</span>
    </a>
    <a class="navbar-brand ms-auto me-3 d-none d-lg-flex" href="https://ifrs.edu.br/feliz/">
      <img src="assets/img/ifrs-logo.svg" alt="Logo IFRS" class="ifrs-logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php#">
            <i class="bi bi-house-fill"></i> Início
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">
            <i class="bi bi-person-fill-down"></i> Sair
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">

    <h2 class="text-center dashboard-header"><i class="bi bi-speedometer2"></i> Painel Administrativo</h2>

    <div class="row g-4">

        <!-- Container: Gerenciamento de Ideias -->
        <div class="col-md-4">
            <div class="card card-container p-4 bg-light">
                <h4><i class="bi bi-lightbulb-fill text-warning"></i> Ideias</h4>
                <p>Total cadastradas: <strong><?= $totalIdeias ?></strong></p>
                <a href="manage.php" class="btn btn-primary btn-dashboard">
                    Acessar Gerenciamento
                </a>
            </div>
        </div>

        <!-- Container: Gerenciamento de Projetos -->
        <div class="col-md-4">
            <div class="card card-container p-4 bg-light">
                <h4><i class="bi bi-kanban-fill text-success"></i> Projetos</h4>
                <p>Total cadastrados: <strong><?= $totalProjetos ?></strong></p>
                <a href="dashboard_projetos.php" class="btn btn-success btn-dashboard">
                    Acessar Gerenciamento
                </a>
            </div>
        </div>

        <!-- Container: Gerenciamento de Usuários -->
        <div class="col-md-4">
            <div class="card card-container p-4 bg-light">
                <h4><i class="bi bi-people-fill text-info"></i> Usuários</h4>
                <p>Total cadastrados: <strong><?= $totalUsuarios ?></strong></p>
                <a href="manage_usuarios.php" class="btn btn-info btn-dashboard text-white">
                    Acessar Gerenciamento
                </a>
            </div>
        </div>

    </div>
</div>

<?php include 'footer.php'?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
