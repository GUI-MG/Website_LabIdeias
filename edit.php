<!-- Arquivo: edit.php -->
<?php
require_once 'db.php';
// Busca ideia por ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $conn->prepare('SELECT * FROM ideias WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$idea = $result->fetch_assoc();
$stmt->close();

$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $email     = trim($_POST['email']);
    if ($titulo && $descricao && $email) {
        $stmt = $conn->prepare(
            'UPDATE ideias SET titulo = ?, descricao = ?, email = ? WHERE id = ?'
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-5">
  <h2 class="mb-4">Editar Ideia</h2>
  <?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
  <?php endif; ?>
  <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
  <?php endif; ?>
  <form method="post" class="form-idea">
    <div class="mb-3">
      <label for="titulo" class="form-label">Título</label>
      <input type="text" name="titulo" id="titulo" class="form-control" value="<?php echo htmlspecialchars($idea['titulo']); ?>" required>
    </div>
    <div class="mb-3">
      <label for="descricao" class="form-label">Descrição</label>
      <textarea name="descricao" id="descricao" rows="5" class="form-control" required><?php echo htmlspecialchars($idea['descricao']); ?></textarea>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">E-mail</label>
      <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($idea['email']); ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="manage.php" class="btn btn-secondary ms-2">Cancelar</a>
  </form>
</div>
<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>