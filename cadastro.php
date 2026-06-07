<?php
require 'db.php';

// Inicializa variáveis de feedback
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $email     = trim($_POST['email']);

    // Verifica se todos os campos estão preenchidos
    if ($titulo && $descricao && $email) {
        // Prepara o comando de inserção (sem created_at, pois é automático no MySQL)
        $stmt = $conn->prepare(
            "INSERT INTO ideias (email, titulo, descricao) VALUES (?, ?, ?)"
        );

        // Liga os parâmetros (email, titulo, descricao)
        $stmt->bind_param('sss', $email, $titulo, $descricao);

        if ($stmt->execute()) {
            $success = 'Ideia cadastrada com sucesso!';
        } else {
            $error = 'Erro ao cadastrar ideia: ' . $stmt->error;
        }

        $stmt->close();
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
    <title>Cadastrar Ideia - Laboratório de Ideias</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
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
            <a class="nav-link" href="login.php">
                <i class="bi bi-gear"></i> Administrar
            </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="site-main flex-fill">
  <section id="cadastro" class="py-5 bg-white-green">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h2><i class="bi bi-pen text-success"></i> Cadastrar Ideia</h2>
          <p class="text-muted mb-4">
            No cadastro de ideias, informe o título da ideia, uma breve descrição e um e-mail para contato, caso ela seja contemplada para desenvolvimento.
          </p>

          <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
          <?php endif; ?>

          <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
          <?php endif; ?>

          <div class="card shadow-sm border-0">
            <div class="card-body">
              <form method="post" class="form-idea">
                <div class="mb-3">
                  <label for="titulo" class="form-label">Título:</label>
                  <input type="text" name="titulo" id="titulo" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label for="descricao" class="form-label">Descrição:</label>
                  <textarea name="descricao" id="descricao" rows="5" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">E-mail:</label>
                  <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-6 text-center mt-4 mt-lg-0">
          <img src="assets/img/home-img.jpg" alt="Cadastrar Ideia" class="img-fluid" style="max-width: 100%; border-radius: 12px;">
        </div>
      </div>
    </div>
  </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
