<?php

session_start();

require_once 'sql/bd.php';

$_SESSION['voltar'] = $_SERVER['REQUEST_URI'];

// Quantos produtos por página
$limit = 8;

// Página atual
$page = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($page - 1) * $limit;

// Verifica se há pesquisa
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : "";


if (!empty($keyword)) {
  // Pesquisar na barra de pesquisa 
  $sql = "SELECT * FROM produtos
          WHERE nome_produto LIKE ?
             OR editora LIKE ?
          LIMIT ? OFFSET ?";

  $stmt = $conn->prepare($sql);
  $param = "%" . $keyword . "%";
  $stmt->bind_param("ssii", $param, $param, $limit, $offset);
} else {

  // Pesquisar todos os produtos na base de dados caso não aja pesquisa
  $sql = "SELECT * FROM produtos LIMIT ? OFFSET ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $limit, $offset);
}

$stmt->execute();
$result = $stmt->get_result();



// Carrinho
if (isset($_POST['add_to_cart'])) {
  $id = $_POST['id_produto'];
  $name = $_POST['nome_produto'];
  $price = $_POST['preco'];
  $imagem = $_POST['imagem'];

  // Se já existir sessão usa se não cria
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }

  // Se já existe produto no carrinho, aumenta a quantidade
  if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantidade'] += 1;
  } else {
    $_SESSION['cart'][$id] = [
      'nome' => $name,
      'preco' => $price,
      'quantidade' => 1,
      'imagem' => $imagem
    ];
  }
}


// Diminuir quantidade
if (isset($_POST['decrease'])) {
  $id = $_POST['prod_id'];
  $_SESSION['cart'][$id]['quantidade'] -= 1;
  if ($_SESSION['cart'][$id]['quantidade'] <= 0) {
    unset($_SESSION['cart'][$id]); // Remove se for 0
  }
}

// Esvaziar carrinho
if (isset($_POST['clear_cart'])) {
  unset($_SESSION['cart']);
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
  <title>Homepage</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css" />
  <script src="https://kit.fontawesome.com/7a24afdce7.js" crossorigin="anonymous"></script>
</head>

<body class="d-flex flex-column min-vh-100">
  <?php include 'componentes/navbar.php'; ?>
  <main class="flex-fill">

    <!-- Search Bar -->

    <div class="container-fluid mt-3">
      <div class="row">
        <div class="col-lg-9">
        </div>
        <div class="col-lg-3 search-bar">
          <form action="index.php" method="GET">
            <div class="input-group">
              <input type="text"
                class="form-control"
                id="keyword"
                name="keyword"
                placeholder="Pesquisar..."
                aria-label="Search"
                aria-describedby="search-addon"
                required>
              <button class="btn" type="submit" id="search-addon" name="search">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Produtos -->

    <div class="container-fluid mt-3">
      <div class="row">
        <div class="col-lg-9">
          <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
              <div class="col-lg-3">
                <div class="card product-card border-0" style=" height: 400px">
                  <div class="position-relative">
                    <div class="overflow-hidden">
                      <img src="<?= $row['imagem'] ?>" id="img-produto" class="card-img-top product-image" alt="<?= $row['nome_produto'] ?>">
                    </div>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title"><?= $row['nome_produto'] ?></h5>
                    <p class="card-text">Preço: <?= number_format($row['preco'], 2, ',', '.') ?> €</p>
                    <div class="d-flex gap-2 align-items-center">
                      <div class="d-flex">
                        <form method="post" action="" class="d-inline-flex">
                          <input type="hidden" name="id_produto" value="<?= $row['id_produto'] ?>">
                          <input type="hidden" name="nome_produto" value="<?= $row['nome_produto'] ?>">
                          <input type="hidden" name="preco" value="<?= $row['preco'] ?>">
                          <input type="hidden" name="imagem" value="<?= $row['imagem'] ?>">

                          <?php
                          // Verificar a quantidade do produto
                          $quantidade = (int) $row['quantidade'];

                          if ($quantidade <= 0): ?>
                            <button type='submit' name='add_to_cart' class='noStock px-4 py-2 rounded-pill' disabled>
                              <i class='fa-solid fa-cart-plus'></i>
                            </button>

                          <?php else: ?>
                            <button type='submit' name='add_to_cart' class='addCart px-4 py-2 rounded-pill'>
                              <i class='fa-solid fa-cart-plus'></i>
                            </button>
                          <?php endif; ?>

                        </form>
                      </div>
                      <div class="d-flex">
                        <button
                          type="button"
                          class="moreInfo px-4 py-2 rounded-pill"
                          onclick="window.location.href='produto.php?id=<?= $row['id_produto'] ?>'">
                          <i class="fa-solid fa-info"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>

        <!-- Carrinho -->

        <div class="col-lg-3">
          <div class="card cart-summary">
            <div class="card-body cart-body" border-radius: 10px;>
              <h4 class="card-title mb-4 d-flex">Carrinho</h4>

              <?php
              if (!empty($_SESSION['cart'])) {
                $total = 0;
                foreach ($_SESSION['cart'] as $id => $item) {
                  $subtotal = $item['preco'] * $item['quantidade'];
                  $total += $subtotal;
                  echo "
<div class='d-flex align-items-center mb-3'>

  <div class='d-flex align-items-center gap-2'>

  <strong>{$item['nome']}</strong><br>
  
  <span>" . number_format($item['preco'], 2, ',', '.') . "€ x 
    <input type='number' class='quantity' name='quantity' value='{$item['quantidade']}'  data-id='$id'  min='1' style='width: 40px'>
  </span>

    </div>
    
    <div class='ms-auto'>
  <form method='post' action='index.php'>
    <input type='hidden' name='prod_id' value='$id'>
    <button type='submit' name='clear_cart' class='btn-cart'>
      <i class='fa-solid fa-xmark'></i>
    </button>
  </form>
</div>
</div>
    

<hr>
";
                }
                echo "
              <div class='d-flex justify-content-between mb-4'>
                <p><strong>Total: 
                <span id='total'>" . number_format($total, 2, ',', '.') . "</span> 
                €</strong></p>
                <form method='post' action='index.php'>
                  <input type='hidden' name='prod_id' value='$id'>
                  <button type='submit' name='clear_cart' class='btn-cart'>
                  <i class='fa-solid fa-trash fa-lg'></i>
                  </button>
                  </form>
                </div>
                <div class='d-flex justify-content-between mb-3'>
                <a href='checkout.php' class='btn btn-checkout'>Checkout</a>
                </div>";
              } else {
                echo "<p>O carrinho está vazio.</p>
            </div>
          </div>";
              }
              ?>
            </div>
          </div>
        </div>
        <div class="container my-4">
          <nav aria-label="Page navigation" class="nav_page">
            <ul class="pagination justify-content-center">
              <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?pagina=<?= $page - 1 ?><?php if (!empty($keyword)) echo "&keyword=$keyword"; ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>

              </li>
              <?php
              // Conta o número total de produtos
              $total_result = $conn->query("SELECT COUNT(*) AS products from produtos")->fetch_assoc();
              $total_products = $total_result['products'];

              // Calcular o total de páginas
              $total_pages = ceil($total_products / $limit);

              for ($i = 1; $i <= $total_pages; $i++):
                $active = ($i == $page) ? 'active' : '';
              ?>

                <li class="page-item <?= $active ?>">
                  <a class="page-link" href="?pagina=<?= $i ?><?php if (!empty($keyword)) echo "&keyword=$keyword"; ?>"><?= $i ?></a>
                </li>
              <?php endfor; ?>
              <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?pagina=<?= $page + 1 ?><?php if (!empty($keyword)) echo "&keyword=$keyword"; ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
  </main>
  <?php include 'componentes/footer.php'; ?>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <script>
    document.querySelectorAll('.quantity').forEach(input => {
      input.addEventListener('input', function() {

        fetch('update_cart.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + this.dataset.id + '&quantity=' + this.value
          })
          .then(res => res.json())
          .then(data => {

            // Atualiza total
            document.getElementById('total').innerText = data.total;
          });

      });
    });
  </script>





</body>

</html>