<?php
session_start();

require_once 'sql/bd.php';

$edit_id = null;

if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
}

// Atualizar o produto na base de dados
if (isset($_POST['save'])) {
    $id = $_POST['id_produto'];
    $nome = $_POST['nome_produto'];
    $descricao = $_POST['descricao'];
    $editora = $_POST['editora'];
    $duracao = $_POST['duracao'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];

    // Buscar imagem atual
    $img_query = mysqli_query($conn, "SELECT imagem FROM produtos WHERE id_produto = $id");
    $img_data = mysqli_fetch_assoc($img_query);
    $imagemAtual = $img_data['imagem'];

    // Se foi enviada nova imagem
    if (!empty($_FILES['imagem']['name'])) {

        if ($_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
            die("Erro no upload");
        }

        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            die("Extensão inválida");
        }

        $newName = uniqid() . '.' . $ext;

        $uploadPath = __DIR__ . '/../imagens/produtos/';

        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadPath . $newName)) {
            die("Falha ao guardar imagem");
        }

        // apagar imagem antiga
        if (!empty($imagemAtual) && file_exists(__DIR__ . '/../' . $imagemAtual)) {
            unlink(__DIR__ . '/../' . $imagemAtual);
        }

        $imagemAtual = 'imagens/produtos/' . $newName;
    }


    $stmt = $conn->prepare("
    UPDATE produtos SET
        imagem = ?,
        nome_produto = ?,
        descricao = ?,
        editora = ?,
        duracao = ?,
        quantidade = ?,
        preco = ?
    WHERE id_produto = ?
");

    $stmt->bind_param(
        "ssssiidi",
        $imagemAtual,
        $nome,
        $descricao,
        $editora,
        $duracao,
        $quantidade,
        $preco,
        $id
    );

    $stmt->execute();
    $stmt->close();

    header("Location: admin_produtos.php");
    exit;
}

// Produtos Existentes 
$products_query = "SELECT * FROM produtos ORDER BY id_produto ASC";
$products_result = $conn->query($products_query);

// Apagar produto selecionado

if (isset($_GET['id_product'])) {
    $id_product = (int) $_GET['id_product'];
    $delete = $conn->prepare("DELETE FROM produtos WHERE id_produto = ?");
    $delete->bind_param("i", $id_product);
    $delete->execute();
    $delete->close();


    header("Location: admin_produtos.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Produtos Existentes" />
    <meta name="keywords" content="BoardVerse, Loja, Board Games" />
    <meta name="author" content="Maria Inês Ferreira" />
    <script src="https://kit.fontawesome.com/7a24afdce7.js" crossorigin="anonymous"></script>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="css/admin_style.css" />
    <title>Admin - Produtos</title>
</head>

<body>
    <header>
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="header">
                    <h1 class="h3 mb-0">Produtos</h1>
                </div>
                <div class="d-flex gap-2">
                    <a class='btn btn-admin' href="admin.php">Voltar</a>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <button class="btn btn-admin" type="submit" onclick="add_product()" style="float:right">Adicionar produto</button>
    </div>
    <div class="container mt-4">
        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Editora / Duração</th>
                    <th>Stock</th>
                    <th>Preço</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $products_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $product['id_produto'] ?></td>

                        <?php if ($edit_id == $product['id_produto']): ?>
                            <form method="POST" enctype="multipart/form-data">
                                <td>
                                    <img src="<?= htmlspecialchars($product['imagem']) ?>" class="img-fluid mb-2" style="max-height:100px">
                                    <input type="file" name="imagem" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="nome_produto" value="<?= $product['nome_produto'] ?>" class="form-control">
                                </td>
                                <td>
                                    <textarea name="descricao" class="form-control" rows="4" maxlength="255" oninput="contador(this)"><?= htmlspecialchars($product['descricao']) ?></textarea>
                                    <small>255 caracteres restantes</small>
                                </td>
                                <td>
                                    <input type="text" name="editora" value="<?= $product['editora'] ?>" class="form-control mb-1">
                                    <input type="text" name="duracao" value="<?= $product['duracao'] ?>" class="form-control">
                                </td>
                                <td>
                                    <input type="number" name="quantidade" value="<?= $product['quantidade'] ?>" class="form-control">
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="preco" value="<?= $product['preco'] ?>" class="form-control">
                                </td>
                                <td>
                                    <input type="hidden" name="id_produto" value="<?= $product['id_produto'] ?>">
                                    <button type="submit" name="save" class="btn btn-admin btn-sm">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </td>
                            </form>
                        <?php else: ?>
                            <td><img src="<?= $product['imagem'] ?>" id="img_product"></td>
                            <td><?= $product['nome_produto'] ?></td>
                            <td>
                                <p><?= $product['descricao'] ?></p>
                            </td>
                            <td>
                                <p><?= $product['editora'] ?></p>
                                <p> <?= $product['duracao'] ?> min</p>
                            </td>
                            <td><?= $product['quantidade'] ?></td>
                            <td><?= $product['preco'] ?>€</td>
                            <td>
                                <div class="actions d-flex gap-2">
                                    <div class="edit">
                                        <form method="POST" action="admin_produtos.php">
                                            <input type="hidden" name="edit_id" value="<?= $product['id_produto'] ?>">
                                            <button type="submit" class="editBtn btn-sm">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="delete">
                                        <form method="GET" action="admin_produtos.php">
                                            <input type="hidden" name="id_product" value="<?= $product['id_produto'] ?>">
                                            <button class="deleteBtn btn-sm">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script>
        function contador(textarea) {
            const max = 255;
            const restantes = max - textarea.value.length;
            textarea.nextElementSibling.innerText =
                restantes + " caracteres restantes";
        }

        function add_product() {
            window.location.href = "add_produto.php";
        }
    </script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>