<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title src="assets/img/logo.png">Laboratório de Ideias</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- Custom CSS -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="assets/img/logo.png" alt="Logo Lab Ideias"  height="220">
      </a>
      <a class="navbar-brand" href="#">
        <img src="assets/img/logoIfrs.png" alt="Logo IFRS" height="320">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php#objetivos">Objetivos</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php#projetos">Projetos</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php#equipe">Equipe</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php#participações">Participações</a></li>
          <li class="nav-item"><a class="nav-link" href="cadastro.php">Cadastrar Ideia</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section id="home" class="py-5 text-center bg-light">
    <div class="container">
      <h1>Laboratório de Ideias</h1>
      <p>Aprendendo e criando inovações.</p>
    </div>
  </section>
  
  <!-- Home Section -->
  <section id="presentation" class="py-5 bg-light">
    <div class="container">
      <h2>Início</h2>
      <h4><b>Seja muito bem vindo!</b></h4>
      <p>O Laboratório de Ideias é um Projeto de Ensino na qual visa fomentar a criatividade e a curiosidade de seus participantes, 
        além de desenvolver soluções para problemas e demandas. Por conseguinte, o Laboratório de Ideias é voltado, não somente à resolução de demandas, mas também ao aprendizado dos participantes que auxiliam na mesma.
        Para tal, abaixo tem-se mais informações sobre o mesmo, seus objetivos, participações, soluções já desenvolvidas, integrantes e, inclusive, o cadastro de alguma ideia de demanda que possuas e que queiras compartilhar conosco.
        Tens uma ideia ou demanda que queiras compartilhar conosco? Clique abaixo e cadastre-a!
      </p>
      <button><a href="cadastro.php">Cadastrar</a></button>
    </div>
  </section>

  <!-- Objetivos -->
  <section id="objetivos" class="py-5">
    <div class="container">
      <h2>Objetivos</h2>
      <p>O projeto tem como objetivo principal fomentar e elaborar propostas de projetos de inovação tecnológica, 
        que visem atender às demandas da sociedade local, 
        ao mesmo tempo em que incentiva os alunos do Curso Técnico em Informática a explorar sua criatividade e espírito empreendedor. 
        Inclusive, além do projeto ajudar a incentivar os alunos a explorar melhor suas capacidades e ajudar a sociedade com seus projetos, 
        faz com que os alunos melhorem sua interação social, apresentação em público e os faz ter curiosidade e interesse por aprender e se aprofundar mais na área.</p>
    </div>
  </section>

  <!-- Projetos -->
  <section id="projetos" class="py-5 bg-light">
    <div class="container">
      <h2>Projetos</h2>
      <?php
      require 'exibirprojetos.php'
      ?>
      <button><a href="projetos.php"><h8>Ver mais</h8></a></button>
      

  <!-- Equipe -->
  <section id="equipe" class="py-5">
    <div class="container">
      <h2>Equipe</h2>
      <h4><b>Membros Atuais:</b></h4>
      <p>Coordenador: Sandro Oliveira Dorneles</p>
      <p>Bolsistas atuais: Ivan Lucas Schaurich e Guilherme Martins Glaeser</p>
      <p>Demais professores: Moser Fagundes<br></p>
      <h4><b>Membros Anteriores:</b></h4>
      <p>Kauã Klassmann</p>
      <p>Lucas</p>
      <p>Rafael</p>
    </div>
  </section>

  <!-- Participações -->
  <section id="participações" class="py-5 bg-light">
    <div class="container">
      <h2>Participações</h2>
      <p><b>2024:</b></p>
      <p>Mostra técnica do Campus Feliz</p>
      <p>Salão IFRS</p>
      <p>2º Oficina na Semana da Informática</p>
    </div>
  </section>

  <!-- Rodapé -->
  <footer class="bg-dark text-white py-3 text-center">
    <div class="container">
      <small>&copy; 2025 Laboratório de Ideias</small>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
