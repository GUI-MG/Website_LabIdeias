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
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="assets/img/logo.png" alt="Logo Lab Ideias" height="320">
      </a>
      <a class="navbar-brand" href="https://ifrs.edu.br/feliz/">
        <img src="assets/img/ifrs-logo.svg" alt="Logo IFRS" height="320">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div id="nav-actions" class="container">
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <button id="indexNavButton" onclick="window.location.href='index.php#objetivos'">
              <i class="bi bi-card-list"></i> Objetivos
            </button>
          </li>
          <li class="nav-item">
            <button id="indexNavButton" onclick="window.location.href='index.php#projetos'">
              <i class="bi bi-collection"></i> Projetos
            </button>
          </li>
          <li class="nav-item">
            <button id="indexNavButton" onclick="window.location.href='index.php#equipe'">
              <i class="bi bi-people-fill"></i> Equipe
            </button>
          </li>
          <li class="nav-item">
            <button id="indexNavButton" onclick="window.location.href='index.php#participacoes'">
              <i class="bi bi-easel3"></i> Participações
            </button>
          </li>
          <li class="nav-item">
            <button id="indexNavButton" onclick="window.location.href='cadastro.php'">
              <i class="bi bi-pen"></i> Cadastrar Ideia
            </button>
          </li>
        </ul>
      </div>
      </div>
    </div>
  </nav>

  <!-- Home Section -->
  <section id="home" class="py-2 text-center bg-light">
    <div class="container">
      <h1>Laboratório de Ideias</h1>
      <p>Aprendendo e criando inovações.</p>
    </div>
  </section>

  <!-- Presentation Section -->
  <section id="presentation" class="py-5">
    <div class="container">
      <h2><i class="bi bi-house-fill"></i> Início</h2>
      <h4><strong>Seja muito bem-vindo!</strong></h4>
      <p>
        O Laboratório de Ideias é um Projeto de Ensino que visa fomentar a criatividade e curiosidade de seus participantes, 
        além de desenvolver soluções para problemas e demandas. Seu foco não é apenas resolver demandas, mas também promover 
        o aprendizado dos participantes.  
        Abaixo, você encontrará mais informações sobre o projeto, seus objetivos, participações, soluções desenvolvidas, 
        integrantes e até um espaço para cadastrar sua ideia.  
        O Laboratório de Ideias faz parte do grupo 
        <strong><a href="http://dgp.cnpq.br/dgp/espelhogrupo/796428">Desenvolvimento Interdisciplinar de Sistemas e Inovações</a></strong>.  
        Tem uma ideia ou demanda para compartilhar? Clique <strong><a href="cadastro.php">aqui</a></strong> e cadastre!
      </p>
    </div>
  </section>

  <!-- Objetivos -->
  <section id="objetivos" class="py-5 bg-light">
    <div class="container">
      <h2><i class="bi bi-card-list"></i> Objetivos</h2>
      <p>
        O objetivo principal do projeto é fomentar e elaborar propostas de inovação tecnológica que atendam às demandas da sociedade local, 
        incentivando os alunos do Curso Técnico em Informática a explorar sua criatividade e espírito empreendedor.  
        Além disso, busca melhorar habilidades sociais, de apresentação e despertar o interesse por aprender mais sobre a área.
      </p>
    </div>
  </section>

  <!-- Projetos -->
  <section id="projetos" class="py-5">
    <div class="container">
      <h2><i class="bi bi-collection"></i> Projetos</h2>
      <?php require 'exibirprojetos.php'; ?>
      <button id="projetosButton" onclick="window.location.href='projetos.php'"><strong>Ver mais</strong></button>
    </div>
  </section>

  <!-- Equipe -->
<section id="equipe" class="py-5 bg-light">
  <div class="container">
    <h2><i class="bi bi-people-fill"></i> Equipe</h2>
    <div class="ps-3"> <!-- Adiciona recuo -->
      <ul>
        <li>Sandro Oliveira Dorneles</li>
        <li>Moser Fagundes</li>
        <li>Michel</li>
        <li>Alan</li>
        <li>Lucas</li>
        <li>Eloisa</li>
        <li>Thaís</li>
      </ul>
    </div>
  </div>
</section>


  <!-- Participações -->
  <section id="participacoes" class="py-5">
    <div class="container">
      <h2><i class="bi bi-easel3"></i> Participações</h2>
      <h6><strong>2025:</strong></h6>
      <ul>
        <li>Mostra da Semana da Informática</li>
        <li>3ª Oficina na Semana da Informática</li>
        <li>Mostra técnica do Campus Feliz</li>
      </ul>
      <h6><strong>2024:</strong></h6>
      <ul>
        <li>Mostra técnica do Campus Feliz</li>
        <li>Salão IFRS</li>
        <li>2ª Oficina na Semana da Informática</li>
      </ul>
    </div>
  </section>

  <!-- Rodapé -->
  <?php include 'footer.php' ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
