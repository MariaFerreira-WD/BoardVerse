<?php

session_start();

require_once 'sql/bd.php';

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql_login = "SELECT * FROM utilizadores WHERE nome_utilizador = ?";
  $stmt_login = $conn->prepare($sql_login);
  $stmt_login->bind_param('s', $username);
  $stmt_login->execute();
  $result = $stmt_login->get_result();

  if ($result->num_rows === 1) {

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {

      // Guardar sessão
      $_SESSION['id_user'] = $user['id_utilizador'];
      $_SESSION['user'] = $user['nome_utilizador'];
      $_SESSION['role'] = $user['role'];



      // Admin -> admin.php
      if ($user['role'] === 'admin') {
        header("Location: admin.php");
        exit;
      }

      // Se houver página para retornar
      if (!empty($_SESSION['voltar'])) {
        $url = $_SESSION['voltar'];
        unset($_SESSION['voltar']);
        header("Location: $url");
        exit;
      }

      // Se não houver página guardada, vai para index
      header("Location: login.php");
      exit;
    } else {
      // Password incorreta
      $msg1 = "Senha incorreta.";
    }
  } else {
    // Utilizador não existe
    $msg2 = "Utilizador não encontrado.";
  }
}
?>




<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Página Inicial de BoardVerse" />
  <meta name="keywords" content="BoardVerse, Loja, Board Games" />
  <meta name="author" content="Maria Inês Ferreira" />
  <link rel="stylesheet" href="css/style.css" />
  <title>Login</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous" />

  <style>
    .modal-content {
      border: none;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      font-family: "Poppins";
    }

    .modal-header {
      padding: 20px;
      border: none;
      color: white;
      margin-top: 30px;
      justify-content: center;
    }

    .modal-body {
      padding: 30px;
    }

    .form-control {
      padding: 12px 15px;
      border-radius: 10px;
      border: 2px solid #eee;
      transition: all 0.3s ease;
    }

    .input-group-text {
      border: none;
      background: transparent;
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #666;
    }

    .input-group {
      position: relative;
      border-radius: 10px;
    }


    .btn-login {
      margin-top: 10px;
      padding: 12px 20px;
      background: linear-gradient(135deg, #731eac, #ab63db);
      border: none;
      border-radius: 10px;
      font-weight: 500;
      width: 50%;
      transition: all 0.3s ease;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px #ac57e46b;
    }

    .register-link {
      text-align: center;
      margin-top: 20px;
      font-size: 0.9rem;
      display: flex;
    }

    button {
      margin-right: 20px;
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100">
  <?php include 'componentes/navbar.php'; ?>
  <main class="flex-fill">
    <section class="container">
      <div class="row" style="justify-content:center;">
        <div class="col-md-6">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title">Login</h2>
              </div>
              <div class="modal-body">
                <form method="POST" action="login.php">
                  <div class="mb-4">
                    <label class="form-label" for="user">Utilizador</label>
                    <div class="input-group">
                      <input type="user" class="form-control" name="username" placeholder="Utilizador">
                    </div>
                    <?php if (!empty($msg2)): ?>
                      <div style="color:red"><?= $msg2 ?></div>
                    <?php endif; ?>
                  </div>
                  <div class="mb-4">
                    <label class="form-label" for="password">Palavra Passe</label>
                    <div class="input-group">
                      <input type="password" class="form-control" name="password" placeholder="Insira a sua palavra passe">
                    </div>
                    <?php if (!empty($msg1)): ?>
                      <div style="color:red"><?= $msg1 ?></div>
                    <?php endif; ?>
                  </div>
                  <div class="register-link">
                    <button type="submit" class="btn btn-login btn-success text-white">Iniciar Sessão</button>
                    <a href="registar.php" class="btn btn-login text-white">Registar</a>
                  </div>
                </form>
              </div>
            </div>
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