<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title src="assets/img/logo.png">Laboratório de Ideias</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  </head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <!-- Custom CSS -->
   <link href="assets/css/reset.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  
</head>
<body>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="assets/img/logo.png" alt="Logo Lab Ideias"  height="220">
      </a>
      <a class="navbar-brand" href="#">
        <img src="assets/img/ifrs-logo.svg" alt="Logo IFRS" height="320">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
  <ul class="navbar-nav ms-auto">
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2" href="index.php#objetivos">
        <i class="bi bi-card-list"></i> Objetivos
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2" href="index.php#projetos">
        <i class="bi bi-collection"></i> Projetos
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2" href="index.php#equipe">
        <i class="bi bi-people-fill"></i> Equipe
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2" href="index.php#participações">
        <i class="bi bi-easel3"></i> Participações
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center gap-2" href="cadastro.php">
        <i class="bi bi-pen"></i> Cadastrar Ideia
      </a>
    </li>
  </ul>
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
      <h4><b>Seja muito bem vindo!</b></h4>
      <p>O Laboratório de Ideias é um Projeto de Ensino na qual visa fomentar a criatividade e a curiosidade de seus participantes, 
        além de desenvolver soluções para problemas e demandas. Por conseguinte, o Laboratório de Ideias é voltado, não somente à resolução de demandas, mas também ao aprendizado dos participantes que auxiliam na mesma.
        Para tal, abaixo tem-se mais informações sobre o mesmo, seus objetivos, participações, soluções já desenvolvidas, integrantes e, inclusive, o cadastro de alguma ideia de demanda que queiras compartilhar conosco.
        O projeto Laboratório de Ideias faz parte de um grupo chamado <b><a href="http://dgp.cnpq.br/dgp/espelhogrupo/796428">Desenvolvimento Interdisciplinar de Sistemas e Inovações</a></b>, caso você queria saber mais, clique no nome do grupo.
        Porventura, tens uma ideia ou demanda que queiras compartilhar conosco? Clique <b><a href="cadastro.php">aqui</a></b> e cadastre-a!
      </p>
    </div>
  </section>

  <!-- Objetivos -->
  <section id="objetivos" class="py-5 bg-light">
    <div class="container">
      <h2><i class="bi bi-card-list"></i> Objetivos</h2>
      <p>O projeto tem como objetivo principal fomentar e elaborar propostas de projetos de inovação tecnológica, 
        que visem atender às demandas da sociedade local, 
        ao mesmo tempo em que incentiva os alunos do Curso Técnico em Informática a explorar sua criatividade e espírito empreendedor. 
        Inclusive, além do projeto ajudar a incentivar os alunos a explorar melhor suas capacidades e ajudar a sociedade com seus projetos, 
        faz com que os alunos melhorem sua interação social, apresentação em público e os faz ter curiosidade e interesse por aprender e se aprofundar mais na área.
      </p>
    </div>
  </section>

  <!-- Projetos -->
  <section id="projetos" class="py-5">
    <div class="container">
      <h2><i class="bi bi-collection"></i> Projetos</h2>
      <?php require 'exibirprojetos.php'?>
    <ul><b><a href="projetos.php">Ver mais</a></b></ul>
      

  <!-- Equipe -->
  <section id="equipe" class="py-5 bg-light">
    <div class="container">
      <h2><i class="bi bi-people-fill"></i> Equipe</h2>
      <h5><b>Membros Atuais:</b></h5>
      <p>Coordenador: Sandro Oliveira Dorneles</p>
      <p>Bolsistas atuais: Ivan Lucas Schaurich e Guilherme Martins Glaeser</p>
      <p>Demais professores: Moser Fagundes<br></p>
    </div>
  </section>
  
  <!-- Participações -->
  <section id="participações" class="py-5">
    <div class="container">
      <h2><i class="bi bi-easel3"></i> Participações</h2>
      <h6><b>2025:</b></h6>
      <li>Mostra da Semana da Informática</li>
      <li>3º Oficina na Semana da Informática</li>
      <li>Mostra técnica do Campus Feliz</li>
      <h6><b>2024:</b></h6> 
      <li>Mostra técnica do Campus Feliz</li>
      <li>Salão IFRS</li>
      <li>2º Oficina na Semana da Informática</li>
    </div>
  </section>

  <!-- Rodapé -->
  <footer class="bg-dark text-white py-3 text-center">
    <div class="container">
      <small>&copy; 2025 Laboratório de Ideias</small>
    </div>
  </footer>
  
</body>
</html>