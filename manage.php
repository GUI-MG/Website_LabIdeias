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
    $sql .= " WHERE titulo LIKE '%$search%' OR descricao LIKE '%$search%' OR email LIKE '%$search%'";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gerenciar Ideias - Laboratório de Ideais</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-5">
  <h2 class="mb-4">Gerenciar Ideias</h2>
  <form class="d-flex mb-3" method="get">
    <input class="form-control me-2" type="search" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Pesquisar...">
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
          <a href="manage.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir ideia?');">Excluir</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>