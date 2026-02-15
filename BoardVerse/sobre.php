 <?php
  session_start();

  // Base de dados
  $host = 'localhost';
  $user = 'root';
  $password = '';
  $dbname = 'boardverse';

  // Conectar à base de dados
  $conn = mysqli_connect($host, $user, $password, $dbname);

  if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
  }

  // Buscar texto à base de dados
  $about_us = $conn->query("SELECT sobre_nos FROM conteudo");
  $about_us_text = $about_us->fetch_assoc();



  ?>

 <!DOCTYPE html>
 <html lang="pt">

 <head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <meta name="description" content="Página Inicial de BoardVerse" />
   <meta name="keywords" content="BoardVerse, Loja, Board Games" />
   <meta name="author" content="Maria Inês Ferreira" />
   <title>Sobre nós</title>
   <link
     href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
     rel="stylesheet"
     integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
     crossorigin="anonymous" />
   <link rel="stylesheet" href="css/style.css" />
   <script
     src="https://kit.fontawesome.com/7a24afdce7.js"
     crossorigin="anonymous"></script>
 </head>
 <style>
   .btn {
     color: #2fdd2f;
     background-color: black;
     border: 2px solid #2fdd2f;
     text-decoration: none;
   }

   .about_text {
     white-space: pre-line;
   }

   #about {
     margin-top: 16px;
   }
 </style>

 <body class="d-flex flex-column min-vh-100">
   <?php include 'componentes/navbar.php'; ?>
   <main class="flex-fill">
     <section id="about" class="py-5">
       <div class="container px-4 px-lg-5">
         <div class="row gx-4 gx-lg-5 align-items-center">
           <div class="col-lg-6">
             <h3 style="margin-bottom: 20px;">História do BoardVerse</h3>
             <p class="mb-4 about_text"><?= $about_us_text['sobre_nos'] ?>
             </p>
             <a class="btn  btn-lg px-4 me-sm-3" href="index.php">A nossa Loja</a>
             <a class="btn  btn-lg px-4" href="contactos.php">Contacta-nos</a>
           </div>
           <div class="col-lg-6 pt-4">
             <img src="imagens/about_us.png" style="padding-bottom: 75px;" alt="BoardVerse" class="img-fluid rounded">
           </div>
         </div>
       </div>
     </section>
   </main>
   <?php include 'componentes/footer.php'; ?>
   <script
     src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
     crossorigin="anonymous"></script>
 </body>

 </html>