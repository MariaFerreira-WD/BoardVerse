<?php
session_start();

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Produtos Existentes" />
    <meta name="keywords" content="BoardVerse, Loja, Board Games" />
    <meta name="author" content="Maria Inês Ferreira" />
    <title>Admin - Produtos</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="css/admin_style.css" />
    <script src="https://kit.fontawesome.com/7a24afdce7.js" crossorigin="anonymous"></script>
</head>
<style>
    .card-sleek {
        background: linear-gradient(135deg, #731eac, #ab63db);
        color: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        margin: auto auto;
    }

    .card-sleek:hover {
        transform: translateY(-5px);
    }

    .card-sleek .card-body {
        padding: 2rem;
    }

    .card-sleek .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .card-sleek .card-text {
        font-size: 1rem;
        line-height: 1.5;
    }

    .card-sleek .btn-sleek {
        background-color: #fff;
        color: #667eea;
        font-weight: bold;
        transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
    }

    .card-sleek .btn-sleek:hover {
        background-color: #667eea;
        color: #fff;
    }
</style>

<body>
    <header>
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="header">
                    <h1 class="h3 mb-0">Produtos</h1>
                </div>
                <div class="d-flex gap-2">
                    <a class='btn btn-admin' href="admin_produtos.php">Voltar</a>
                </div>
            </div>
        </div>
    </header>

    <body>
        <div class="container">
            <div class="col-md-6 card card-sleek" style="max-width: 600px;">
                <div class="card-body">
                    <h5 class="card-title">Novo Produto</h5>
                    <form action="new_product.php" enctype="multipart/form-data" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Editora</label>
                                <input type="text" class="form-control" name="publisher">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Descrição</label>
                                <input type="text" class="form-control" name="description">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Duração (min)</label>
                                <input type="tel" class="form-control" name="duration">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stock</label>
                                <input type="text" class="form-control" name="stock">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Preço</label>
                                <input type="text" class="form-control" name="price">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Thumbnail</label>
                                <input type="file" class="form-control" name="thumbnail">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Imagem 2</label>
                                <input type="file" class="form-control" name="image_2">
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-addProduct" style="float:right" name="confirm">Confirmar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <?php include 'componentes/footer.php'; ?>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>