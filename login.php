<?php
session_start(); // Inicia a sessão

$host = 'localhost';
$db = 'bd_ideias_projetos';
$user = 'root';
$pass = '';

// Conectar ao banco
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (!empty($usuario) && !empty($senha)) {

        if ($usuario !== 'administrador') {
            $mensagem = '<div class="alert alert-danger text-center" role="alert">Apenas o usuário administrador pode acessar.</div>';
        } else {
            $usuario = $conn->real_escape_string($usuario);
            $senhaHash = hash('sha256', $senha); // Criptografar senha

            // Prepared statement para maior segurança
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ? AND senha = ?");
            $stmt->bind_param("ss", $usuario, $senhaHash);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                // Login bem-sucedido
                $_SESSION['usuario'] = $usuario;
                header("Location: manage.php"); // Redireciona para gerenciamento de ideias
                exit;
            } else {
                $mensagem = '<div class="alert alert-danger text-center" role="alert">Usuário ou senha inválidos!</div>';
            }
            $stmt->close();
        }

    } else {
        $mensagem = '<div class="alert alert-warning text-center" role="alert">Preencha todos os campos.</div>';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Laboratório de Ideias</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/img/logo.png" alt="Logo Lab Ideias" height="180">
        </a>
        <a class="navbar-brand" href="index.php">
            <img src="assets/img/ifrs-logo.svg" alt="Logo IFRS" height="180">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-house-fill"></i> Início</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Login Form -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4"><i class="bi bi-box-arrow-in-right"></i> Login</h3>

                    <!-- Mensagem de retorno -->
                    <?php if (!empty($mensagem)) echo $mensagem; ?>

                    <form action="login.php" method="post">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuário</label>
                            <input type="text" class="form-control" name="usuario" id="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" name="senha" id="senha" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right"></i> Entrar
                        </button>
                    </form>

                    <p class="text-center mt-3 mb-0">
                        <?php if(!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'administrador'): ?>
                            Apenas o administrador pode criar novas contas.
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rodapé -->
<footer class="bg-dark text-white py-3 mt-5 text-center">
    <div class="container">
        <small>&copy; 2025 Laboratório de Ideias</small>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
