<?php

session_start();

require_once 'sql/bd.php';


if (!isset($_SESSION['user'])) {
  $_SESSION['voltar'] = 'checkout.php'; // página para voltar após login
  header('Location: login.php');
  exit;
}

// Buscar os dados referentes ao utilizador que iniciou sessão
$data_stmt = $conn->prepare("SELECT nome_utilizador, data_nascimento, morada, codigo_postal FROM utilizadores WHERE id_utilizador = ?");
$data_stmt->bind_param("i", $_SESSION['id_user']);
$data_stmt->execute();

$data_result = $data_stmt->get_result();
$user = $data_result->fetch_assoc();



// Guardar na sessão
$_SESSION['nome_utilizador'] = $user['nome_utilizador'];
$_SESSION['data_nascimento'] = $user['data_nascimento'];
$_SESSION['morada'] = $user['morada'];
$_SESSION['codigo_postal'] = $user['codigo_postal'];
?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Página Inicial de BoardVerse" />
  <meta name="keywords" content="BoardVerse, Loja, Board Games" />
  <meta name="author" content="Maria Inês Ferreira" />
  <title>Checkout</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<style>
  .product-card {
    pointer-events: none;
  }
</style>

<body class="d-flex flex-column min-vh-100">
  <?php include 'componentes/navbar.php'; ?>
  <main class="flex-fill">
    <h1 style="text-align: center; margin-top: 16px">Checkout</h1>
    <div class="container d-flex gap-5">
      <?php

      if (!empty($_SESSION['cart'])) {
        $total = 0;
        echo "<div style='display:flex; gap: 0 12px; flex: 1; padding:16px;' class='product-card'>
        <ul style='display:flex; flex-direction: column; gap: 8px 0; padding-left: 0; flex: 1;'>";
        foreach ($_SESSION['cart'] as $item) {
          $subtotal = $item['preco'] * $item['quantidade'];
          $total += $subtotal;
          echo "<li style='list-style-type:none'> <div style='display:flex; gap:0 12px; align-items: center;'>
          <img style='width: 150px; height: auto;' src='{$item['imagem']}' alt='Imagem do produto'></img>
          <div style='display:flex; flex-direction: column; gap: 4px 0;'>{$item['nome']} x{$item['quantidade']} - €" . number_format($subtotal, 2, ',', '.') . "</div></div></li>";
        }
        echo "</ul>";
        echo "<p style='font-size: 24px; align-self: flex-end;'><strong>Total: €" . number_format($total, 2, ',', '.') . "</strong></p> </div>";
      } else {
        echo "<p>O carrinho está vazio.</p> </div>";
      }
      ?>


      <form name="checkoutForm" id="checkoutForm" method="POST" action="guardar_encomenda.php" style="display:flex; gap:8px 0; flex-direction: column; width:300px; flex-shrink: 0;">
        <h4 style="text-align:center">Dados de faturação</h4>
        <div style="display:flex; flex-direction:column; gap: 4px 0;">
          <label for="name" class="form-label">Nome</label>
          <input type="text" name="nome" class="form-control" id="nome" value="<?= $_SESSION['nome_utilizador'] ?>" required />
        </div>


        <div style="display:flex; flex-direction:column; gap: 4px 0;">
          <label for=" birth-date" class="form-label">Data de Nascimento:</label>
          <input type="date" name="data_nascimento" class="form-control" id="data_nascimento" value="<?= $_SESSION['data_nascimento'] ?>" required />
        </div>


        <div style="display:flex; flex-direction:column; gap: 4px 0;">
          <label for=" adress" class="form-label">Morada</label>
          <input type="text" class="form-control" name="morada_entrega" id="morada_entrega" value="<?= $_SESSION['morada'] ?>" required />
        </div>

        <div style="display:flex; flex-direction:column; gap: 4px 0;">
          <label for="adress" class="form-label">Código Postal</label>
          <input type="text" class="form-control" name="cp" id="cp" value="<?= $_SESSION['codigo_postal'] ?>" required />
        </div>

        <button class="btn btn-custom" type="submit">Concluir Compra</button>
      </form>
    </div>
  </main>
  <?php include 'componentes/footer.php'; ?>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <script src="js/script.js"></script>
</body>

</html>