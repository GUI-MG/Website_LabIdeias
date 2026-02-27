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
  <title>Projetos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<style>
  nav {
    background: linear-gradient(to right, rgb(80, 230, 70), rgb(80, 160, 60));
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
  }
  main {
        flex: 1; /* ocupa o espaço antes do footer */
  }
</style>

<body>
 
 <!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/img/logo.png" alt="Logo Lab Ideias" height="180">
        </a>
        <a class="navbar-brand" href="https://ifrs.edu.br/feliz/">
            <img src="assets/img/ifrs-logo.svg" alt="Logo IFRS" height="180">
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-house-fill"></i> Início</a></li>
                <li class="nav-item"><a class="nav-link" href="cadastro.php"><i class="bi bi-pen"></i> Voltar</a></li>
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5">
  <h2>Selecionar Projeto</h2>

  <!-- Formulário de seleção --> 
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

  <!-- Exibição do conteúdo -->
  <div id="conteudoProjeto" class="mt-4" style="display: none;">
    <h4 id="tipoTitulo"></h4>
    <p id="conteudoTexto"></p>
  </div>
</div>

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


