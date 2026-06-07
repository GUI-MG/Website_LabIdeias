<?php
// Conexão com o banco de dados
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'bd_lab_ideias';
$conn = new mysqli($host, $user, $pass, $db);


// Se for uma chamada AJAX, retorna conteúdo em JSON e encerra aqui
if (isset($_GET['ajax']) && isset($_GET['id']) && isset($_GET['tipo'])) {
    $id = intval($_GET['id']);
    $tipo = ($_GET['tipo'] === 'descricao') ? 'descricao' : 'resumo';

    // Evita interpolar diretamente na SQL
    $stmt = $conn->prepare("SELECT `$tipo` FROM projetos WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo json_encode(['conteudo' => $row[$tipo]]);
        } else {
            echo json_encode(['conteudo' => 'Projeto não encontrado.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['conteudo' => 'Erro na consulta SQL.']);
    }

    $conn->close();
    exit; // Finaliza para evitar exibir o HTML
}

// Caso contrário, é o carregamento da página normal
$sql = 'SELECT id, titulo FROM projetos';
$result = $conn->query($sql);

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
              <form>
                <div class="mb-3">
                  <label for="projetoSelect" class="form-label">Projeto:</label>
                  <select id="projetoSelect" class="form-select" onchange="buscarConteudo()">
                    <option value="">Selecione um projeto</option>
                    <?php while($row = $result->fetch_assoc()): ?>
                      <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['titulo']); ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="tipoSelect" class="form-label">Visualizar:</label>
                  <select id="tipoSelect" class="form-select" onchange="buscarConteudo()">
                    <option value="resumo">Resumo</option>
                    <option value="descricao">Descrição</option>
                  </select>
                </div>
              </form>
            </div>
          </div>

          <div id="conteudoProjeto" class="card shadow-sm border-0" style="display: none;">
            <div class="card-body">
              <h4 id="tipoTitulo" class="card-title"></h4>
              <p id="conteudoTexto" class="card-text"></p>
            </div>
          </div>
        </div>

        <div class="col-lg-6 text-center mt-4 mt-lg-0">
          <img src="assets/img/projetos-img.jpg" alt="Projetos Illustration" class="img-fluid" style="max-width: 100%; border-radius: 12px;">
        </div>
      </div>
    </div>
  </section>
</main>

<script>
function buscarConteudo() {
  const projetoId = document.getElementById('projetoSelect').value;
  const tipo = document.getElementById('tipoSelect').value;

  if (!projetoId || !tipo) {
    document.getElementById('conteudoProjeto').style.display = 'none';
    document.getElementById('conteudoTexto').innerText = '';
    return;
  }

  fetch(`<?php echo $_SERVER['PHP_SELF']; ?>?ajax=1&id=${projetoId}&tipo=${tipo}`)
    .then(response => response.json())
    .then(data => {
      document.getElementById('conteudoProjeto').style.display = 'block';
      document.getElementById('tipoTitulo').innerText = tipo.charAt(0).toUpperCase() + tipo.slice(1) + ' do Projeto:';
      document.getElementById('conteudoTexto').innerText = data.conteudo || 'Conteúdo não disponível.';
    })
    .catch(error => {
      console.error('Erro:', error);
    });
}
</script>

<?php include 'footer.php';?>
</body>
</html>

<?php $conn->close(); ?>


