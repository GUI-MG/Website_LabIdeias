<?php
include('pdo.php');
$pdo = getPDOConnection();
$projetoId = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Obtém o ID do projeto da URL, se fornecido
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'resumo'; // Obtém o tipo de conteúdo a ser exibido (resumo ou descrição)

// Se for uma chamada AJAX, retorna conteúdo em JSON e encerra aqui
if (isset($_GET['ajax']) && isset($_GET['id']) && isset($_GET['tipo'])) {
    $id = intval($_GET['id']);
    $tipo = ($_GET['tipo'] === 'descricao') ? 'descricao' : 'resumo';
    // carregar conteúdo do projeto
    $stmtAjax = $pdo->prepare("SELECT resumo, descricao FROM projeto WHERE id = :id");
    $stmtAjax->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtAjax->execute();
    $rowAjax = $stmtAjax->fetch(PDO::FETCH_ASSOC);
    $conteudo = ($tipo === 'descricao') ? ($rowAjax['descricao'] ?? '') : ($rowAjax['resumo'] ?? '');
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['conteudo' => $conteudo]);
    exit;
}

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
      echo "        <h6 class='card-title'>( $inicio ) $situacao</h6>";
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
  <title>Projetos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
 
 <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="assets/img/logo.png" alt="Logo Lab Ideias" height="160">
      </a>
      <a class="navbar-brand" href="https://ifrs.edu.br/feliz/">
        <img src="assets/img/ifrs-logo.svg" alt="Logo IFRS" height="160">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="nav-actions">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <button id="indexNavButton" onclick="window.location.href='index.php'">
              <i class="bi bi-arrow-return-right"></i> Voltar
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main id="principal">
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
      <div id="conteudoProjeto" class="mt-4">
        <div id="conteudoProjetos" class="container">
          <h4 id="tipoTitulo"></h4>
          <p id="conteudoTexto"></p>
        </div>
      </div>
    </div>
  </main>

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

  tipo2 = tipo.split('');
  console.log(tipo2)
  tipo2[0] = tipo2[0].toUpperCase()
  tipo2[6] = 'ç'; 
  tipo2[7] = 'ã';
  tipoPronto = '';
  tipo2.forEach(letra => {
    tipoPronto+=letra;
  });

  fetch(`<?php echo $_SERVER['PHP_SELF']; ?>?ajax=1&id=${projetoId}&tipo=${tipo}`)
    .then(response => response.json())
    .then(data => {
      document.getElementById('conteudoProjeto').style.display = 'block';
      document.getElementById('tipoTitulo').innerText = (tipo == 'resumo' ? tipo.charAt(0).toUpperCase() + tipo.slice(1) + ' do Projeto:' : tipoPronto + ' do Projeto:');
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