<?php

session_start();

// Impedir acesso se utilizador se não tiver role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: index.php");
  exit;
}

require_once 'sql/bd.php';


// Total de Utilizadores
$total_u = $conn->query("SELECT COUNT(*) AS total FROM Utilizadores");
$row = $total_u->fetch_assoc();
$total_users = $row['total'];

// Total de Produtos
$total_p = $conn->query("SELECT COUNT(*) AS total FROM Produtos");
$row = $total_p->fetch_assoc();
$total_products = $row['total'];

// Total de Encomendas
$total_e = $conn->query("SELECT COUNT(*) AS total FROM Encomendas");
$row = $total_e->fetch_assoc();
$total_orders = $row['total'];

// Total de Tickets
$total_t = $conn->query("SELECT COUNT(*) AS total from tickets");
$row = $total_t->fetch_assoc();
$total_tickets = $row['total'];

// Total de Eventos
$total_ev = $conn->query("SELECT COUNT(*) AS total FROM eventos");
$row = $total_ev->fetch_assoc();
$total_events = $row['total'];

// Texto Sobre Nós
$about_us = $conn->query("SELECT sobre_nos FROM conteudo");
$about_us_text = $about_us->fetch_assoc();

// Atualizar texto 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sobre_nos'])) {
  $new_text = mysqli_real_escape_string($conn, $_POST['sobre_nos']);

  $conn->query("UPDATE conteudo SET sobre_nos = '$new_text'");

  // Recarrega o valor atualizado
  $about_us = $conn->query("SELECT sobre_nos FROM conteudo");
  $about_us_text = $about_us->fetch_assoc();
}

$edit = isset($_POST['edit_text']);


?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Painel do admin" />
  <meta name="keywords" content="BoardVerse, Loja, Board Games" />
  <meta name="author" content="Maria Inês Ferreira" />
  <title>Admin</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="css/admin_style.css" />
  <script src="https://kit.fontawesome.com/7a24afdce7.js" crossorigin="anonymous"></script>
</head>
<style>
  .btn-exit {
    border: 2px solid #2fdd2f;
    color: #2fdd2f;
    text-decoration: none;
  }


  .bento-item {
    height: 200px;
    border-radius: 15px;
    overflow: hidden;
    position: relative;
    transition: transform 0.3s ease;
    cursor: pointer;
  }

  #products {
    padding: 40px;
  }

  img {
    filter: drop-shadow(0 5px 10px rgba(0, 255, 21, 0.664));
    padding: 20px;
  }

  img:hover {
    filter: drop-shadow(0 5px 10px #ab63db);

  }

  .bento-item:hover {
    transform: scale(1.05);
  }


  .main:hover {
    transform: none;
  }

  .main img,
  .main img:hover {
    filter: none;
  }

  .bento-tall {
    height: 400px;
  }

  .bento-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    color: white;
    justify-content: center;
  }

  .main {
    cursor: default;
    box-shadow: none;
  }

  .bento-item img {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }
</style>

<body>

  <div class="container py-4">
    <div class="container my-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="header">
          <h3>Bem vindo, Admin!</h3>
        </div>
        <div class="d-flex gap-2">
          <?php
          // Verifica se o utilizador está autenticado ou não
          if (!isset($_SESSION['id_user'])) {
            header("Location: login.php");
          } else {
            echo "<a class='btn btn-exit' href='logout.php'>Terminar Sessão</a>";
          }
          ?>
        </div>
      </div>

      <div class="row g-4">
        <div class="col-md-7">
          <div class="bento-item main bento-tall">
            <img src="imagens/Board_Verse_Logo_WL-01.webp" style="object-fit: contain;" alt="Logo">
            <div class="bento-content d-flex gap-2">
            </div>
          </div>
        </div>

        <div class="col-md-5">
          <div class="row g-4">
            <div class="d-flex">
              <h4 class="col-lg-11 d-flex">Sobre Nós</h4>
              <form method="POST">
                <button type="submit" name="edit_text" class="editBtn" style="float:right">
                  <i class="fa-solid fa-pencil"></i>
                </button>
              </form>
            </div>
            <?php if ($edit): ?>
              <form method="POST">
                <textarea
                  name="sobre_nos"
                  class="about_text form-control mb-2"
                  rows="6"><?= $about_us_text['sobre_nos'] ?></textarea>

                <button type="submit" class="btn editBtn btn-sm">Guardar</button>
                <a href="admin.php" class="btn editBtn btn-sm">Cancelar</a>
              </form>
            <?php else: ?>
              <p class="about_text"><?= nl2br($about_us_text['sobre_nos']) ?></p>
            <?php endif; ?>

          </div>
        </div>

        <div class="col-md">
          <div class="bento-item" onclick="user()">
            <img src="imagens/admin/utilizador.png" alt="Utilizadores">
            <div class="bento-content d-flex gap-2">
              <h4>Utilizadores</h4>
            </div>
          </div>
        </div>

        <div class="col-md">
          <div class="bento-item" onclick="orders()">
            <img src="imagens/admin/orders.png" alt="Encomendas">
            <div class="bento-content d-flex gap-2">
              <h4>Encomendas</h4>
            </div>
          </div>
        </div>

        <div class="col-md">
          <div class="bento-item" onclick="events()">
            <img src="imagens/admin/events.png" alt="Eventos">
            <div class="bento-content d-flex gap-2">
              <h4>Eventos</h4>

            </div>
          </div>
        </div>

        <div class="col-md">
          <div class="bento-item" onclick="client_support()">
            <img src="imagens/admin/client_support.png" alt="Apoio ao cliente">
            <div class="bento-content d-flex gap-2">
              <h4>Tickets</h4>

            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="bento-item" onclick="products()">
            <img src="imagens/admin/products.png" id="products" alt="Produtos">
            <div class="bento-content d-flex gap-2">
              <h4>Produtos</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <script>
    function user() {
      window.location.href = "admin_utilizadores.php";
    }

    function products() {
      window.location.href = "admin_produtos.php";
    }

    function events() {
      window.location.href = "admin_eventos.php";
    }

    function orders() {
      window.location.href = "admin_encomendas.php";
    }

    function client_support() {
      window.location.href = "admin_tickets.php";
    }
  </script>
</body>

</html>