<?php
session_start(); // Inicia a sessão

// Dados de conexão
$host = 'localhost';
$db   = 'bd_lab_ideias';
$user = 'root';
$pass = '';

// Conexão com o banco
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$mensagem = '';


// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha   = trim($_POST['senha'] ?? '');

    if (!empty($usuario) && !empty($senha)) {
            $usuario   = $conn->real_escape_string($usuario);
            $senhaHash = hash('sha256', $senha); // Criptografar senha

            // Verificar credenciais
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ? AND senha = ?");
            $stmt->bind_param("ss", $usuario, $senhaHash);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                $_SESSION['usuario'] = $usuario;
                header("Location: dashboard.php");
                exit;
            } else {
                $mensagem = '<div class="alert alert-danger text-center" role="alert">Usuário e/ou senha incorretos! Tente novamente.</div>';
            }
            $stmt->close();
        }
     else {
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
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Reset + CSS personalizado -->
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- Navbar -->
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
            <a class="nav-link" href="index.php"><i class="bi bi-house-fill"></i> Início</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="cadastro.php"><i class="bi bi-pen"></i> Voltar</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="login-main flex-fill">
  <section id="login" class="py-5 bg-white-green">
    <div class="container">
        <h2><i class="bi bi-box-arrow-in-right text-success"></i> Entrar no sistema</h2>
        <p class="text-muted mb-4">
        Insira seu usuário e senha para acessar o painel de administração.
        </p>
        <?php if (!empty($mensagem)) echo $mensagem; ?>

        <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="login.php" method="post" class="form-idea">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuário</label>
                <input type="text" class="form-control" name="usuario" id="usuario" required>
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <div class="input-group">
                <input type="password" class="form-control" name="senha" id="senha" required>
                <button type="button" class="btn btn-outline-secondary" id="toggleSenha">
                    <i class="bi bi-eye" id="iconSenha"></i>
                </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right"></i> Entrar
            </button>
            </form>
        </div>
        </div>

        <p class="text-center mt-3 mb-0 text-muted">
        <?php if(!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'administrador'): ?>
            Apenas o administrador pode criar novas contas.
        <?php endif; ?>
        </p>
    </div>
  </section>
</main>

<!-- Rodapé -->
<?php include 'footer.php' ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para mostrar/ocultar senha -->
<script>
    const toggleSenha = document.getElementById('toggleSenha');
    const senhaInput  = document.getElementById('senha');
    const iconSenha   = document.getElementById('iconSenha');

    toggleSenha.addEventListener('click', () => {
        if (senhaInput.type === 'password') {
            senhaInput.type = 'text';
            iconSenha.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            senhaInput.type = 'password';
            iconSenha.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>
</body>
</html>
