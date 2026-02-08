<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Eco Track</title>

  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/inicioEco.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Eco Track</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <li class="nav-item">
            <a class="nav-link active" href="index.php">
              Inicio</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
              Clientes</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="?page=cadastrar-cliente">Cadastrar</a></li>
              <li><a class="dropdown-item" href="?page=listar-cliente">Listar</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
              Cálculos de Consumo</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="?page=cal-agua">Cálculo de Água</a></li>
              <li><a class="dropdown-item" href="?page=cal-luz">Cálculo de Luz</a></li>
              <li><a class="dropdown-item" href="?page=cal-total">Água + Luz</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
              Tarifa</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="?page=cadastrar-tarifa">Cadastrar</a></li>
              <li><a class="dropdown-item" href="?page=listar-tarifa">Listar</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
              Leitura</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="?page=cadastrar-leitura">Cadastrar</a></li>
              <li><a class="dropdown-item" href="?page=listar-leitura">Listar</a></li>
            </ul>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <?php if (!isset($_REQUEST["page"])): ?>
    <!-- INÍCIO -->
    <section class="home-container">
      <h1>Bem-vindo ao <span>Eco Track</span> </h1>
      <p>O sistema inteligente para acompanhar o consumo de <b>água</b> e <b>energia</b></p>
      <a href="#como-funciona" class="botao">Como Funciona</a>
    </section>

    <!-- O que e? -->
    <section class="terceira-imagem">
      <div class="conteudo-segunda">
        <h2>O que e o EcoTrak?</h2>

        <div class="passos">
          <p><b>EcoTrak é uma plataforma criada para facilitar o controle do seu consumo de água e energia de forma simples,
              clara e totalmente intuitiva.<br>
              Com ele, você acompanha seus gastos, entende para onde seu dinheiro está indo e descobre maneiras práticas de economizar no dia a dia.
              <br>
              Nosso objetivo é transformar dados em decisões inteligentes: você informa seu consumo e o EcoTrak calcula, analisa e apresenta relatórios fáceis de entender.
              Assim, você ganha mais controle financeiro, mais consciência ambiental e evita surpresas na conta no final do mês.
              <br>
              O EcoTrak é ideal para quem quer organizar a vida, gastar menos e adotar hábitos mais sustentáveis — tudo isso sem complicação.</b></p>
        </div>

        <p>Sistema criado para conscientizar a população dos gastos do dia a dia "inviciveis".</p>
        <p>Os dados são uma media não e 100% de certeza.</p>
      </div>
    </section>

    <!-- Importancia -->
    <section class="quarta-imagem">
      <div class="conteudo-segunda">
        <h2>Qual a importância do EcoTrak?</h2>
        <div class="passos">
          <p><b>Controlar o consumo de água e energia não é apenas uma forma de economizar —
              é uma atitude essencial para quem busca qualidade de vida e responsabilidade financeira.<br>
              Quando você sabe exatamente quanto está gastando, pode identificar desperdícios, ajustar seus hábitos e planejar melhor o seu mês.
              <br>
              Além disso, pequenas mudanças no uso diário fazem uma diferença enorme na conta e também no impacto ambiental.
              Acompanhar seus gastos permite entender seu próprio comportamento e fazer escolhas mais conscientes, sustentáveis e inteligentes.
              <br>
              Saber seu consumo é o primeiro passo para reduzir despesas, evitar sustos e viver com mais tranquilidade.
              E com ferramentas como o EcoTrak, esse controle fica muito mais fácil.</b></p>
        </div>

        <p>Os dados são uma media não e 100% de certeza.</p>
      </div>
    </section>

    <!-- COMO FUNCIONA -->
    <section id="como-funciona" class="segunda-imagem">
      <div class="conteudo-segunda">
        <h2>Como funciona o Eco Track</h2>
        <p>Siga os passos abaixo:</p>

        <div class="passos">
          <p><b>1. Cadastre o cliente</b></p>
          <p><b>2. Consulte suas contas: Água, Luz ou Água e Luz</b></p>
          <p><b>3. Registre tarifas</b></p>
          <p><b>4. Registre a leitura</b></p>
        </div>

        <p>O Eco Track calcula tudo automaticamente.</p>
      </div>
    </section>
  <?php endif; ?>

  <!-- CONTEÚDO PHP -->
  <div class="row">
    <div class="col">

      <?php
      include('includes/config.php');

      switch (@$_REQUEST["page"]) {
        //*Cliente
        case 'cadastrar-cliente':
          include('pages/cliente/cadastrar-cliente.php');
          break;
        case 'listar-cliente':
          include('pages/cliente/listar-cliente.php');
          break;
        case 'editar-cliente':
          include('pages/cliente/editar-cliente.php');
          break;
        case 'salvar-cliente':
          include('includes/salvar-cliente.php');
          break;

        //*Contas
        case 'cal-agua':
          include('logic/cal_agua.php');
          break;
        case 'cal-luz':
          include('logic/cal_luz.php');
          break;
        case 'cal-total':
          include('logic/cal_total.php');
          break;

        //*Tarifa
        case 'cadastrar-tarifa':
          include('pages/tarifa/cadastrar-tarifa.php');
          break;
        case 'listar-tarifa':
          include('pages/tarifa/listar-tarifa.php');
          break;
        case 'editar-tarifa':
          include('pages/tarifa/editar-tarifa.php');
          break;
        case 'salvar-tarifa':
          include('includes/salvar-tarifa.php');
          break;

        //*Leitura
        case 'cadastrar-leitura':
          include('pages/leitura/cadastrar-leitura.php');
          break;
        case 'listar-leitura':
          include('pages/leitura/listar-leitura.php');
          break;
        case 'editar-leitura':
          include('pages/leitura/editar-leitura.php');
          break;
        case 'salvar-leitura':
          include('includes/salvar-leitura.php');
          break;
      }
      ?>
    </div>
  </div>
  </div>

  <!-- RODAPÉ -->
  <footer class="rodape">
    <p>Eco Track © 2025 — Desenvolvido por Pedro Monteiro</p>
  </footer>


  <script src="js/bootstrap.bundle.js"></script>
</body>

</html>