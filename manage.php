<!-- Arquivo: manage.php -->
<?php
require_once 'db.php';

// Ações: delete, search
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM ideias WHERE id = $id");
    header('Location: manage.php');
    exit;
}

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sql = "SELECT * FROM ideias";
if ($search) {
    $sql .= " WHERE titulo LIKE '%$search%' 
           OR descricao LIKE '%$search%' 
           OR email LIKE '%$search%'";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gerenciar Ideias - Laboratório de Ideais</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <style>
    /* Forçar o footer ao fim da tela */
    html, body {
        height: 100%;
    }
    body {
        display: flex;
        flex-direction: column;
    }
    main {
        flex: 1; /* ocupa o espaço antes do footer */
    }
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
            <a class="nav-link" href="index.php">
              <i class="bi bi-house-fill"></i> Início
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cadusuarios.php">
              <i class="bi bi-person-plus-fill"></i> Cadastrar usuário
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- CONTEÚDO PRINCIPAL -->
  <main class="container py-5">
    <h2 class="mb-4">Gerenciar Ideias</h2>
    <form class="d-flex mb-3" method="get">
      <input class="form-control me-2" type="search" name="search" 
             value="<?php echo htmlspecialchars($search); ?>" placeholder="Pesquisar...">
      <button class="btn btn-outline-primary" type="submit">Buscar</button>
    </form>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Título</th>
          <th>Descrição</th>
          <th>E-mail</th>
          <th>Criado em</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['titulo']); ?></td>
          <td><?php echo htmlspecialchars($row['descricao']); ?></td>
          <td><?php echo htmlspecialchars($row['email']); ?></td>
          <td><?php echo $row['created_at']; ?></td>
          <td>
            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
            <a href="manage.php?delete=<?php echo $row['id']; ?>" 
               class="btn btn-sm btn-danger" 
               onclick="return confirm('Excluir ideia?');">Excluir</a>
          </td>
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