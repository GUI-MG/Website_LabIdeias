<?php
include('pdo.php');
$pdo = getPDOConnection();
$projetoId = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Obtém o ID do projeto da URL, se fornecido
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'resumo'; // Obtém o tipo de conteúdo a ser exibido (resumo ou descrição)

function exibirProjeto(PDO $pdo, int $id): void {

  $sql = "SELECT titulo, resumo, descricao, situacao, inicio 
          FROM projeto
          WHERE id = :id";

  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $projeto = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($projeto) {
      $titulo = htmlspecialchars($projeto['titulo']);
      $resumo = htmlspecialchars($projeto['resumo']);
      $descricao = htmlspecialchars($projeto['descricao']);
      $situacao = htmlspecialchars($projeto['situacao']);
      $inicio = htmlspecialchars($projeto['inicio']);

      echo "<div id='conteudoProjeto' class='card shadow-sm border-0'>";
      echo "    <div class='card-body'>";
      echo "        <h4 id='tipoTitulo' class='card-title'>$titulo</h4>";
      if (isset($_GET['tipo']) && $_GET['tipo'] === 'descricao') {
          echo "        <p id='conteudoTexto' class='card-text'>$descricao</p>";
      } else {
          echo "        <p id='conteudoTexto' class='card-text'>$resumo</p>";
      }
      echo "   </div>";
      echo "</div>";

  } else {
      echo "<p class='text-danger'>Projeto não encontrado.</p>";
  }
}

function listarProjetos(PDO $pdo): void {
    $sql = "SELECT id, titulo FROM projeto";
    $stmt = $pdo->query($sql);
    $projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($projetos) {
      foreach ($projetos as $projeto) {
          $selected = (isset($_GET['id']) && $_GET['id'] == $projeto['id']) ? 'selected' : '';
          echo "<option value='" . htmlspecialchars($projeto['id']) . "' $selected>" . htmlspecialchars($projeto['titulo']) . "</option>";
      }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projetos - Laboratório de Ideias</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

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
                    <li class="nav-item nav-cadastro">
                        <a class="nav-link" href="dashboard.php"><i class="bi bi-arrow-return-left"></i> Voltar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="site-main flex-fill">
        <section id="projetos" class="py-5 bg-white-green">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2><i class="bi bi-collection text-success"></i> Selecionar Projeto</h2>
                        <p class="text-muted mb-4">
                            Escolha um projeto abaixo e veja o resumo ou a descrição diretamente na página.
                        </p>

                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">
                                <form action="projetos.php" method="get">
                                    <div class="mb-3">
                                        <label for="id" class="form-label">Projeto:</label>
                                        <select name="id" class="form-select" onchange="this.form.submit()" required>
                                            <option value="" disabled selected>Selecione um projeto</option>
                                            <?php listarProjetos($pdo); ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tipo" class="form-label">Visualizar:</label>
                                        <select name="tipo" class="form-select" onchange="this.form.submit()">
                                            <option value="resumo" <?= $tipo === 'resumo' ? 'selected' : '' ?>>Resumo
                                            </option>
                                            <option value="descricao" <?= $tipo === 'descricao' ? 'selected' : '' ?>>
                                                Descrição</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <?php exibirProjeto($pdo, $projetoId); ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'footer.php';?>
</body>

</html>