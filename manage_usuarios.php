<!-- Arquivo: manage_usuarios.php -->
<?php
require_once 'db.php';
session_start();

// Apenas usuários logados podem acessar
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuarioLogado = $_SESSION['usuario'];

// Ações: delete
if (isset($_GET['delete']) && $usuarioLogado === 'administrador') {
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM usuarios WHERE id = $id");
    header('Location: manage_usuarios.php');
    exit;
}

// Buscar usuários
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sql = "SELECT * FROM usuarios";
if ($search) {
    $sql .= " WHERE usuario LIKE '%$search%' OR senha LIKE '%$search%'";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gerenciar Usuários - Laboratório de Ideias</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <style>
    html, body { height: 100%; }
    body { display: flex; flex-direction: column; }
    main { flex: 1; }
  </style>
</head>
<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="assets/img/logo.png" alt="Logo Lab Ideias" height="80">
      </a>
      <a class="navbar-brand" href="#">
        <img src="assets/img/ifrs-logo.svg" alt="Logo IFRS" height="80">
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
            <a class="nav-link" href="dashboard.php"><i class="bi bi-arrow-return-right"></i> Voltar</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- CONTEÚDO PRINCIPAL -->
<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-people-fill"></i> Gerenciar Usuários</h2>
        <?php if ($usuarioLogado === 'administrador'): ?>
            <a href="cadusuarios.php" class="btn btn-success">
                <i class="bi bi-person-plus-fill"></i> Novo Usuário
            </a>
        <?php endif; ?>
    </div>

    <form class="d-flex mb-3" method="get">
        <input class="form-control me-2" type="search" name="search" 
               value="<?php echo htmlspecialchars($search); ?>" placeholder="Pesquisar...">
        <button class="btn btn-outline-primary" type="submit">Buscar</button>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Senha (hash)</th>
                <?php if ($usuarioLogado === 'administrador'): ?>
                <th>Ações</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['usuario']); ?></td>
                <td><?php echo htmlspecialchars($row['senha']); ?></td>
                <?php if ($usuarioLogado === 'administrador'): ?>
                <td>
                    <a href="edit_usuario.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="manage_usuarios.php?delete=<?php echo $row['id']; ?>" 
                       class="btn btn-sm btn-danger" 
                       onclick="return confirm('Excluir usuário?');">Excluir</a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

  <!-- FOOTER -->
  <?php include 'footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
