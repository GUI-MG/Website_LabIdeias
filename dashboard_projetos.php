<?php
require_once 'db.php';

// Ações: delete via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = (int)$_POST['delete'];
    $conn->query("DELETE FROM projetos WHERE id = $id");
    header('Location: manage_projetos.php');
    exit;
}

// Barra de pesquisa
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sql = "SELECT * FROM projetos";
if ($search) {
    $sql .= " WHERE titulo LIKE '%$search%' 
           OR resumo LIKE '%$search%' 
           OR descricao LIKE '%$search%' 
           OR situacao LIKE '%$search%'";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gerenciar Projetos - Laboratório de Ideias</title>
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
      <a class="navbar-brand" href="#"><img src="assets/img/logo.png" alt="Logo Lab Ideias" height="80"></a>
      <a class="navbar-brand" href="#"><img src="assets/img/ifrs-logo.svg" alt="Logo IFRS" height="80"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-house-fill"></i> Início</a></li>
          <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-arrow-return-right"></i> Voltar</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- CONTEÚDO PRINCIPAL -->
  <main class="container py-5">
    <div class="text-center d-flex justify-content-between align-items-center mb-4">
      <h2><i class="bi bi-folder-fill"></i> Gerenciar Projetos</h2>
      <a href="cadastro_projetos.php" class="btn btn-success"><i class="bi bi-plus-lg"></i> Cadastrar novo projeto</a>
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
          <th>Título</th>
          <th>Resumo</th>
          <th>Descrição</th>
          <th>Situação</th>
          <th>Participantes</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['titulo']) ?></td>
            <td><?= htmlspecialchars($row['resumo']) ?></td>
            <td><?= htmlspecialchars($row['descricao']) ?></td>
            <td><?= htmlspecialchars($row['situacao']) ?></td>
            <td>
              <?php
                $id_projeto = $row['id'];
                $participants = $conn->query("SELECT nome_completo, tipo FROM participantes WHERE id_projeto = $id_projeto");
                if ($participants && $participants->num_rows > 0) {
                    $lista = [];
                    while ($p = $participants->fetch_assoc()) {
                        $lista[] = htmlspecialchars($p['nome_completo']) . " (" . htmlspecialchars($p['tipo']) . ")";
                    }
                    echo implode(", ", $lista);
                } else {
                    echo "Nenhum participante";
                }
              ?>
            </td>
            <td>
              <a href="edit_projeto.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Editar</a>

              <!-- Formulário para exclusão imediata -->
              <form method="post" class="d-inline delete-form">
                <input type="hidden" name="delete" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Excluir projeto?');">
                  Excluir
                </button>
              </form>

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
