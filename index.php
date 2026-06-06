<?php 

include('pdo.php');
$pdo = getPDOConnection();

function exibirProjetos(PDO $pdo): void {
  // Ano atual
  $anoAtual = date('Y');

  // Consulta com filtro pelo ano atual
  $sql = "SELECT titulo, resumo, inicio, termino 
          FROM projetos 
          WHERE termino IS NULL OR YEAR(termino) = :ano";

  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':ano', $anoAtual, PDO::PARAM_INT);
  $stmt->execute();
  $projetos = $stmt->fetchAll();

  if ($projetos) {
    echo '<div class="row">';

    foreach ($projetos as $projeto) {
      $periodo = htmlspecialchars($projeto['inicio']) . ' - ' . ($projeto['termino'] ? htmlspecialchars($projeto['termino']) : 'em andamento');
      echo '<div class="col-md-6 mb-4">';
      echo '  <div class="card">';
      echo '    <div class="card-body">';
      echo '      <h5 class="card-title">' . htmlspecialchars($projeto['titulo']) . '</h5>';
      echo '      <h6 class="card-title">' . $periodo . '</h6>';
      echo '      <p class="card-text">' . nl2br(htmlspecialchars($projeto['resumo'])) . '</p>';
      echo '    </div>';
      echo '  </div>';
      echo '</div>';
    }

    echo '</div>';
  } else {
    echo '<p class="text-muted">Nenhum projeto encontrado para o ano de ' . $anoAtual . '.</p>';
  }
}

function exibirEquipe(PDO $pdo): void {
  // Ano atual
  $anoAtual = date('Y');

  // Puxar a EQUIPE do banco
  // puxar apenas os membros que participaram de um projeto do ano atual
  $sql = "SELECT p.nome_completo,
                 GROUP_CONCAT(DISTINCT pp.tipo ORDER BY pp.tipo SEPARATOR '/') AS tipos
          FROM partic_proj_relacao pp
          JOIN projetos pr ON pp.id_proj = pr.id
          JOIN participantes p ON pp.id_partc = p.id
          WHERE pr.termino IS NULL OR YEAR(pr.termino) = :ano
          GROUP BY p.id, p.nome_completo";

  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':ano', $anoAtual, PDO::PARAM_INT);
  $stmt->execute();
  $equipe = $stmt->fetchAll();

  if ($equipe) {  
    echo '<div class="team-list">';
    echo '<ul class="list-unstyled">';
    foreach ($equipe as $membro) {
      echo '<li class="mb-2"><i class="bi bi-person-check text-success"></i>' . htmlspecialchars($membro['nome_completo']) . ' - ' . htmlspecialchars($membro['tipos']) . '</li>';
    }
    echo '</ul>';
    echo '</div>';
  } else {
    echo '<p class="text-muted">Nenhum membro encontrado para este ano.</p>';
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laboratório de Ideias</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">

  <!-- Custom CSS -->
  <link href="assets/css/reset.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark-green">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center gap-2" href="#">
        <img src="assets/img/logo_simples.png" alt="Logo Lab Ideias" class="navbar-logo">
        <span class="brand-name">LABORATÓRIO<br>DE IDEIAS</span>
      </a>
      <a class="navbar-brand ms-auto me-3 d-none d-lg-flex" href="#">
        <img src="assets/img/ifrs-logo.svg" alt="Logo IFRS" class="ifrs-logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php#objetivos">
              <i class="bi bi-card-list"></i> Objetivos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#projetos">
              <i class="bi bi-collection"></i> Projetos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#equipe">
              <i class="bi bi-people-fill"></i> Equipe
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#participacoes">
              <i class="bi bi-easel3"></i> Participações
            </a>
          </li>
          <li class="nav-item nav-cadastro">
            <a class="nav-link" href="cadastro.php">
              <i class="bi bi-pen" style="color: yellow"></i> Cadastrar Ideia
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <!-- Breadcrumb -->
  <nav class="navbar navbar-light bg-light-gray p-2">
    <div class="container-fluid">
      <a class="navbar-brand active" href="#">
        <i class="bi bi-house-fill text-success me-2"></i>Início
      </a>
    </div>
  </nav>

  <!-- Conteúdo principal que preenche o espaço disponível -->
  <main class="site-main flex-fill">

  <!-- Home Section -->
  <section id="home" class="py-5 bg-white">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h1 class="display-4 fw-bold text-dark mb-2">Laboratório de Ideias</h1>
          <p class="text-success fs-5 fw-bold mb-3">Aprendendo e criando inovações.</p>
          <hr class="divider-yellow" style="width: 80px; height: 4px;">
          <p class="text-muted mb-4">
            Seja muito bem-vindo! O Laboratório de Ideias é um Projeto de Ensino que visa fomentar 
            a criatividade e curiosidade de seus participantes, além de desenvolver soluções para problemas e demandas. 
            Seu foco não é apenas resolver demandas, mas também promover o aprendizado dos participantes. 
            Abaixo, você encontrará mais informações sobre o projeto, suas atividades, integrantes e um espaço para cadastrar sua ideia.
          </p>
          <a href="cadastro.php" class="btn btn-success btn-lg">
            <i class="bi bi-plus-circle"></i> Cadastrar ideia
          </a>
        </div>
        <div class="col-lg-6 text-center">
          <img src="assets/img/home-img.jpg" alt="Illustration" class="img-fluid" style="max-width: 80%;">
        </div>
      </div>
    </div>
  </section>

  <!-- Objetivos -->
  <section id="objetivos" class="py-5 bg-white-green">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 order-lg-2">
          <h2 class="mb-4"><i class="bi bi-bullseye text-success"></i> Objetivos</h2>
          <p class="text-muted">
            O objetivo principal do projeto é fomentar e elaborar propostas de inovação tecnológica que atendam às demandas da sociedade local, 
            incentivando os alunos do Curso Técnico em Informática a explorar sua criatividade e espírito empreendedor.  
            Além disso, busca melhorar habilidades sociais, de apresentação e despertar o interesse por aprender mais sobre a área.
          </p>
        </div>
        <div class="col-lg-6 order-lg-1 text-center mb-4 mb-lg-0">
          <img src="assets/img/objetivos-img.jpg" alt="Objetivos Illustration" class="img-fluid">
        </div>
      </div>
    </div>
  </section>

  <!-- Projetos -->
  <section id="projetos" class="py-5 bg-white-green">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 order-lg-1">
          <h2 class="mb-4"><i class="bi bi-collection text-success"></i> Projetos de <?= date('Y') ?></h2>
          <div class="text-center mt-4">
            <a href="projetos.php" class="btn btn-outline-success">Ver mais projetos</a>
          </div>
        </div>
        <div class="col-lg-6 order-lg-2 text-center mb-4 mb-lg-0">
          <img src="assets/img/projetos-img.jpg" alt="Projetos Illustration" class="img-fluid">
        </div>
      </div>
      <div>
        <?php exibirProjetos($pdo) ?>
      </div>
    </div>
  </section>

  <!-- Equipe -->
  <section id="equipe" class="py-5 bg-white-green">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 order-lg-2">
          <h2 class="mb-4"><i class="bi bi-people-fill text-success"></i> Equipe de <?= date('Y') ?></h2>
          <?php exibirEquipe($pdo)?>
        </div>
        <div class="col-lg-6 order-lg-1 text-center mb-4 mb-lg-0">
          <img src="assets/img/equipe-img.jpg" alt="Equipe Illustration" class="img-fluid">
        </div>
      </div>
    </div>
  </section>


  <!-- Participações -->
   <section id="participacoes" class="py-5 bg-white-green">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 order-lg-1">
          <h2 class="mb-4"><i class="bi bi-easel3 text-success"></i> Participações</h2>
          <div class="row">
            <div class="col-md-6">
              <h6 class="fw-bold text-success mb-3">2025:</h6>
              <ul class="list-unstyled">
                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Mostra da Semana da Informática</li>
                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> 3ª Oficina na Semana da Informática</li>
                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Mostra técnica do Campus Feliz</li>
              </ul>
            </div>
            <div class="col-md-6">
              <h6 class="fw-bold text-success mb-3">2024:</h6>
              <ul class="list-unstyled">
                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Mostra técnica do Campus Feliz</li>
                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Salão IFRS</li>
                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> 2ª Oficina na Semana da Informática</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-6 order-lg-2 text-center mb-4 mb-lg-0">
          <img src="assets/img/participacoes-img.jpg" alt="Participações Illustration" class="img-fluid">
        </div>
      </div>
    </div>
  </section>

  </main>

  <!-- Rodapé -->
  <?php include 'footer.php' ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
