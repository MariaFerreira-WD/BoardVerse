<?php

session_start();

require_once 'sql/bd.php';

// Formulário submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];

  // Define o role padrão (cliente)
  $role = 'cliente';

  // Verifica se os campos estão preenchidos
  if ($username === '' || $password === '' || $confirmPassword === '') {
    $msg = "Por favor preencha todos os campos";
    // Verifica se as passwords coincidem
  } elseif ($password !== $confirmPassword) {
    $msg = "As passwords não coincidem";
  } else {

    // Verifica se o utilizador já existe na base de dados
    $sql_check = "SELECT * FROM utilizadores WHERE nome_utilizador = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();

    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
      $msg = "Esse nome de utilizador já está a ser utilizado";
    } else {

      // Encriptar a password
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      // Inserir o novo utilizador na base de dados
      $sql_insert = "INSERT INTO utilizadores (nome_utilizador, email, password, role) VALUES (?,?,?,?)";
      $stmt_insert = $conn->prepare($sql_insert);
      $stmt_insert->bind_param("ssss", $username, $email, $hashed_password, $role);

      if ($stmt_insert->execute()) {
        $_SESSION['mensagem'] = "Registo efetuado com sucesso!";
        header("Location: index.php");
        exit;
      } else {
        $msg = "Erro ao criar utilizador. Tenta novamente";
      }
    }
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
  <title>Registar</title>
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
      margin-top: 20px;
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
                <h2 class="modal-title">Registar</h2>
                <?php if (!empty($msg)): ?>
                  <div style="color:red"><?= $msg ?></div>
                <?php endif; ?>
              </div>
              <div class="modal-body">
                <form method="POST" action="registar.php">
                  <div class="mb-4">
                    <label class="form-label" for="username">Utilizador</label>
                    <div class="input-group">
                      <input type="user" class="form-control" id="username" name="username" placeholder="Utilizador" required>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label" for="email">Email</label>
                    <div class="input-group">
                      <input type="email" class="form-control" id="email" name="email" placeholder="Insira o seu email" required>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label" for="password">Palavra-Passe</label>
                    <div class="input-group">
                      <input type="password" class="form-control" id="password" name="password" placeholder="Insira palavra-passe" required>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label" for="password">Confirmar Palavra-Passe</label>
                    <div class="input-group">
                      <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Insira palavra-passe novamente" required>
                    </div>
                  </div>
                  <div class="register-link">
                    <button type="submit" class="btn btn-login text-white">Registar</button>
                    <a href="login.php" class="btn btn-login text-white">Voltar</a>
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