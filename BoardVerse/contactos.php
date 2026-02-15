<?php
session_start();

require_once 'sql/bd.php';


// Informação do ticket submetido
if (isset($_POST['send'])) {

  $title = $_POST['title'];
  $subject = 'outros';
  $description = $_POST['description'];
  $email = $_POST['email'];
  $fName = $_POST['fname'];
  $lName = $_POST['lname'];

  $fullName = "{$fName} {$lName}";


  // Enviar o ticket para a base de dados
  $ticket = $conn->prepare("INSERT INTO tickets (nome_utilizador, email, titulo, descricao, assunto) VALUES (?,?,?,?,?)");
  $ticket->bind_param("sssss", $fullName, $email, $title, $description, $subject);
  $ticket->execute();
}


?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Contacto" />
  <meta name="keywords" content="BoardVerse, Loja, Board Games" />
  <meta name="author" content="Maria Inês Ferreira" />
  <title>Contactos</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css" />
  <script
    src="https://kit.fontawesome.com/7a24afdce7.js"
    crossorigin="anonymous"></script>
  <style>
    .contact-wrapper {
      background: black;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
    }

    .contact-info {
      background: linear-gradient(135deg, #731eac, #ab63db);
      padding: 40px;
      color: white;
      height: 650px;
      border-radius: 0 0 0 10px;
    }

    .contact-item {
      display: flex;
      align-items: center;
      margin-bottom: 25px;
      transition: all 0.3s ease;
    }

    .contact-item:hover {
      transform: translateX(10px);
    }

    .contact-icon {
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
    }

    .social-links {
      padding-top: 40px;
    }

    .social-icon {
      width: 35px;
      height: 35px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-right: 10px;
      transition: all 0.3s ease;
      color: white;
    }

    .social-icon:hover {
      background: white;
      color: #731eac;
      transform: translateY(-3px);
    }

    .contact-form {
      padding: 40px;
      background-color: rgb(0, 0, 0);
    }

    .form-control {
      border-radius: 10px;
      padding: 12px 15px;
      border: 2px solid #eee;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: #731eac;
      box-shadow: none;
    }

    .form-label {
      font-weight: 500;
      margin-bottom: 8px;
      padding-left: 4px;
    }

    .btn-submit {
      color: #2fdd2f;
      background-color: transparent;
      border: 2px solid #2fdd2f;
      padding: 12px 30px;
      border-radius: 10px;
      transition: all 0.3s ease;
      float: right;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      border: 2px solid #2fdd2f;
      box-shadow: 0 5px 15px rgba(0, 204, 27, 0.3);
    }

    .inner-form {
      display: flex;
      flex-direction: column;

      button {
        align-self: flex-end;
      }
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100">
  <?php include 'componentes/navbar.php'; ?>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="contact-wrapper">
          <div class="row g-0">
            <div class="col-md-5">
              <div class="contact-info">
                <h3 class="mb-4">Contacta-nos</h3>
                <p class="mb-4">Adoraríamos ouvir a tua opinião! Entra em contacto connosco.</p>

                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                  </div>
                  <div>
                    <h6 class="mb-0">Morada</h6>
                    <p class="mb-0">Rua dos Jogos de Tabuleiro<br>Lisboa, Portugal</p>
                  </div>
                </div>

                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                  </div>
                  <div>
                    <h6 class="mb-0">Telemóvel</h6>
                    <p class="mb-0">+351 931 234 567</p>
                  </div>
                </div>

                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                  </div>
                  <div>
                    <h6 class="mb-0">Email</h6>
                    <p class="mb-0">boardverse@email.com</p>
                  </div>
                </div>

                <div class="social-links">
                  <h6 class="mb-3">Segue-nos</h6>
                  <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                  <a href="#" class="social-icon"><i class="fa-brands fa-x-twitter"></i></a>
                  <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                </div>
              </div>
            </div>

            <div class="col-md-7">
              <div class="contact-form">
                <h3 class="mb-4">Envia-nos uma mensagem</h3>
                <form class="inner-form" method="POST" action="">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Nome</label>
                      <input type="text" class="form-control" placeholder="Nome" name="fname">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Apelido</label>
                      <input type="text" class="form-control" placeholder="Apelido" name="lname">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Assunto</label>
                    <input type="text" class="form-control" placeholder="Assunto" name="title">
                  </div>

                  <div class=" mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="@exemplo.com" name="email">
                  </div>

                  <div class="mb-4">
                    <label class="form-label">Mensagem</label>
                    <textarea class="form-control" rows="6" placeholder="Escreve a tua mensagem aqui.." name="description"></textarea>
                  </div>

                  <button type="submit" class="btn btn-submit" name="send">Enviar</button>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include 'componentes/footer.php'; ?>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>