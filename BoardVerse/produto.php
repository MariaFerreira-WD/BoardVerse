<?php

session_start();

require_once 'sql/bd.php';

if (!isset($_GET['id'])) {
  die("Produto não encontrado");
}

$id = intval($_GET['id']);

$product_query = "SELECT * FROM produtos WHERE id_produto = $id";
$product_result = $conn->query($product_query);

if ($product_result->num_rows == 0) {
  die("Produto não existe");
}

$product = $product_result->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Página Inicial de BoardVerse" />
  <meta name="keywords" content="BoardVerse, Loja, Board Games" />
  <meta name="author" content="Maria Inês Ferreira" />
  <title><?= $product['nome_produto'] ?></title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css" />
  <script src="https://kit.fontawesome.com/7a24afdce7.js" crossorigin="anonymous"></script>
</head>
<style>
  .product-title {
    border-bottom: 5px solid #731eac;
    text-align: center;
  }

  .product-title h3 {
    font-size: 2rem;
    font-weight: 700;
    letter-spacing: 0.5px;
  }

  .product-title h4 {
    font-size: 1.2rem;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.65);
  }

  .product-image {
    max-height: 300px;
    object-fit: cover;
    background: linear-gradient(145deg, #1b1026, #120b17);
    border-radius: 20px;
    box-shadow: 0 15px 25px rgba(183, 0, 255, 0.438);
    transition:
      transform 0.3s ease,
      box-shadow 0.3s ease;
    margin-top: 35px;

  }

  .product-description {
    color: #cfcfcf;
    font-size: 1.05rem;
    line-height: 1.6;
    max-width: 90%;
  }

  .product-price {
    color: #2fdd2f;
    font-size: 2.4rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-shadow: 0 0 10px rgba(47, 221, 47, 0.35);
  }

  .product-info label,
  .product-info h4 {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.6);
    margin: 0;
  }

  .product-info span {
    font-weight: 600;
    color: #ffffff;
  }

  .product-duration {
    font-size: 1.1rem;
    font-weight: 600;
    color: #ffffff;
  }


  .in-stock {
    color: #2fdd2f;
    font-weight: 600;
  }

  .no-stock {
    color: #ff5c5c;
    font-weight: 600;
  }

  #quantity {
    width: 60px;
    background-color: #1A1A1A;
    color: #EAEAEA;
    border: 1px solid #3A3A3A;
    text-align: center;

  }

  #quantity::-webkit-outer-spin-button,
  #quantity::-webkit-inner-spin-button {
    -webkit-appearance: none;
  }

  #quantity:hover {
    border-color: #7C4DFF;
  }

  #quantity:focus {
    border-color: #3DDC97;
    box-shadow: 0 0 0 2px rgba(61, 220, 151, 0.25);
    outline: none;
  }

  .thumbnail {
    width: 80px;
    height: 80px;
    object-fit: cover;
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.3s ease;
  }

  .thumbnail:hover,
  .thumbnail.active {
    opacity: 1;
  }

  .btn-custom {
    color: #2fdd2f;
    background-color: black;
    border: 2px solid #2fdd2f;
    transition: all 0.3s ease;
    width: 100%;
  }

  .btn-custom:hover {
    transform: translateX(5px);
    color: #2fdd2f;
    border: 2px solid #2fdd2f;
    box-shadow: -5px 5px 15px rgba(46, 204, 113, 0.3);
  }

  .quant {
    width: 30px;
    height: 30px;
    padding: 0;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .quant:hover {
    transform: none;
  }
</style>

<body class="d-flex flex-column min-vh-100">
  <?php include 'componentes/navbar.php'; ?>
  <main class="flex-fill">
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-4 mb-4">
          <img src="<?= $product['imagem'] ?>" alt="<?= $product['imagem'] ?>" class="img-fluid rounded mb-3 product-image" id="mainImage">
          <div class="justify-content-between">
            <img src="<?= $product['imagem'] ?>" alt="<?= $product['imagem'] ?>" class="thumbnail rounded active" onclick="changeImage(event, this.src)">
            <img src="<?= $product['imagem_2'] ?>" alt="<?= $product['imagem_2'] ?>" class="thumbnail rounded" onclick="changeImage(event, this.src)">
          </div>
        </div>

        <div class="col-md-8">
          <div class="mb-3 product-title d-flex justify-content-between align-items-center">
            <div class="d-flex gap-2 align-items-center">
              <h3><?= $product['nome_produto'] ?> -</h3>
              <h4 style="color:white"><?= $product['editora'] ?></h4>
            </div>
            <i class="returnBtn fa-solid fa-arrow-left fa-2xl" onclick="window.location.href='index.php'"></i>
          </div>
          <div class="mb-3 d-flex gap-2">
            <span class="product-description me-2"><?= $product['descricao'] ?></span>
          </div>
          <div class="mb-3 d-flex gap-2">
            <span class="product-price me-2"> <?= $product['preco'] ?>€</span>
          </div>
          <div class="mb-3 d-flex gap-2 product-info">
            <h4>Duração:</h4>
            <span class="product-duration"><?= $product['duracao'] ?> min</span>
          </div>
          <div class="mb-3 d-flex gap-3 product-info">
            <label for="quantity" class="h4">Quantidade:</label>
            <div class="d-flex">
              <button class="btn btn-custom quant" onclick="subQuantity()">-</button>
              <input type="number" class="form-control form-control-sm mx-2" id="quantity" value="1" min="1" style="width: 40px;">
              <button type="button" class="btn btn-custom quant" onclick="addQuantity()">+</button>
            </div>
          </div>
          <div class="mb-3 d-flex gap-2">
            <p>
              <?php
              if ($product['quantidade'] <= 0) {
                echo '<span class="no-stock">Sem stock</span>' . ' <img src="imagens/cancel.png" alt="stock" id="stock"></br>
                          </br><button class="btn btn-custom btn-lg mb-3 me-2 noStock" disabled>
              <i class="bi bi-cart-plus"></i> Produto indisponível
            </button>';
              } else {
                echo '<span class="in-stock">Em stock</span>' . ' <img src="imagens/mark.png" alt="stock" id="stock"> </br>
              </br><button class="btn btn-custom btn-lg mb-3 me-2">
              <i class="bi bi-cart-plus"></i> Adicionar o carrinho
              </button>';
              }
              ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include 'componentes/footer.php'; ?>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <script>
    function changeImage(event, src) {
      document.getElementById('mainImage').src = src;
      document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
      event.target.classList.add('active');
    }

    function addQuantity() {
      const input = document.getElementById('quantity');
      input.value = parseInt(input.value) + 1;
    }

    function subQuantity() {
      const input = document.getElementById('quantity');
      input.value = input.value > 1 ? parseInt(input.value) - 1 : 1;
    }
  </script>
</body>

</html>