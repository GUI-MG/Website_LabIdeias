<?php 
// Conexão com o banco de dados
$host = 'localhost';
$db   = 'bd_projetos_ideias';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Se for uma chamado AJAX, responde o conteúdo em JSON e encerra
if (isset($_GET['ajax']) && isset($_GET['id']) && isset($_GET['tipo'])) {
    $id = intval($_GET['id']);
    $tipo = ($_GET['tipo'] === 'descricao') ? 'descricao' : 'resumo';

    // Evita interpolar diretamente na SQL
    $stmt = $conn->prepare("SELECT `$tipo` FROM Projetos WHERE id = ?");
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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Projetos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h2>Selecionar Projeto</h2>

  <!-- Formulário de seleção -->
  <form>
    <div class="mb-3">
      <label for="projetoSelect" class="form-label">Projeto:</label>
      <select id="projetoSelect" class="form-select" onchange="buscarConteudo()">
        <option value="">Selecione um Projeto</option>
        <?php while($row = $result->fetch_assoc()): ?>
          <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['titulo']); ?> </option>
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
  <div id="conteudoProjeto" class="mt-4" style="display: none">
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
      document.getElementById('conteudoProjeto').style.display = '';
      document.getElementById('tipoTitulo').innerText = 
        (tipo.charAt(0).toUpperCase() + tipo.slice(1)) + " do Projeto:";
      document.getElementById('conteudoTexto').innerText = 
        data.conteudo ? data.conteudo : 'Conteúdo não disponível';
    })
    .catch(error => {
      console.error('Erro!', error);
    });
}
</script>

</body>
</html>

<?php $conn->close(); ?>
