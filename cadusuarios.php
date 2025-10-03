<?php
session_start(); // Inicia a sessão

// Verifica se o usuário logado é o administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'administrador') { 
    // Redireciona para login se não for administrador
    header("Location: login.php");
    exit;
}

$host = 'localhost';
$db = 'bd_ideias_projetos';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
  
    if (empty($usuario) || empty($senha)) {
        $mensagem = '<div class="alert alert-danger text-center" role="alert">Preencha todos os campos!</div>';
    } else {
        $senhaHash = hash('sha256', $senha);

        // Verifica se o usuário já existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $mensagem = '<div class="alert alert-warning text-center" role="alert">Usuário já existe!</div>';
        } else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO usuarios (usuario, senha) VALUES (?, ?)");
            $stmt->bind_param('ss', $usuario, $senhaHash);

            if ($stmt->execute()) {
                $mensagem = '<div class="alert alert-success text-center" role="alert">Cadastro realizado com sucesso!</div>';
            } else {
                $mensagem = '<div class="alert alert-danger text-center" role="alert">Erro ao cadastrar: ' . $stmt->error . '</div>';
            }
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadastro de Usuário</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">

  <!-- Custom CSS -->
  <link href="assets/css/reset.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="assets/img/logo.png" alt="Logo Lab Ideias" height="320">
      </a>
      <a class="navbar-brand" href="index.php">
        <img src="assets/img/ifrs-logo.svg" alt="Logo IFRS" height="320">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-house-fill"></i>Início</a></li>
          <li class="nav-item"><a class="nav-link" href="manage.php"><i class="bi bi-box-arrow-right"></i> Sair</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Cadastro Usuário -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-5">
          <div class="card shadow-sm rounded-4">
            <div class="card-body p-4">
              <h3 class="text-center mb-4">
                <i class="bi bi-person-plus-fill"></i> Cadastrar Usuário
              </h3>

              <!-- Mensagem de retorno -->
              <?php if (!empty($mensagem)) echo $mensagem; ?>

              <form method="post">
                <div class="mb-3">
                  <label for="usuario" class="form-label">Usuário</label>
                  <input type="text" class="form-control" name="usuario" id="usuario" required>
                </div>
                <div class="mb-3">
                  <label for="senha" class="form-label">Senha</label>
                  <input type="password" class="form-control" name="senha" id="senha" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                  <i class="bi bi-check-circle-fill"></i> Cadastrar
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Rodapé -->
  <footer class="bg-dark text-white py-3 text-center">
    <div class="container">
      <small>&copy; 2025 Laboratório de Ideias</small>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
