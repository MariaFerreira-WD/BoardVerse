<?php
session_start();

require_once 'sql/bd.php';

if (isset($_POST['confirm'])) {

    // Dados do formulário
    $name = $_POST['name'];
    $publisher = $_POST['publisher'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];


    $allowed = ['jpg', 'jpeg', 'png'];


    if (
        !isset($_FILES['thumbnail'], $_FILES['image_2']) ||
        $_FILES['thumbnail']['error'] !== UPLOAD_ERR_OK ||
        $_FILES['image_2']['error'] !== UPLOAD_ERR_OK
    ) {
        die("Erro no upload dos ficheiros");
    }


    $ext1 = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
    $ext2 = strtolower(pathinfo($_FILES['image_2']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext1, $allowed) || !in_array($ext2, $allowed)) {
        die("Extensão inválida. Só são permitidos JPG, JPEG e PNG.");
    }


    $uploadDir = __DIR__ . '/imagens/produtos/';


    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Permissões completas
    }

    if (!is_writable($uploadDir)) {
        die("A pasta de upload não tem permissões de escrita");
    }


    $img1 = uniqid() . '.' . $ext1;
    $img2 = uniqid() . '.' . $ext2;

    // Guardar imagens
    if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadDir . $img1)) {
        die("Falha ao guardar thumbnail");
    }
    if (!move_uploaded_file($_FILES['image_2']['tmp_name'], $uploadDir . $img2)) {
        die("Falha ao guardar imagem 2");
    }

    $url_img1 = 'imagens/produtos/' . $img1;
    $url_img2 = 'imagens/produtos/' . $img2;

    // Inserir na base de dados
    $stmt = $conn->prepare("INSERT INTO produtos 
        (nome_produto, editora, descricao, duracao, imagem, imagem_2, quantidade, preco)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssissid", $name, $publisher, $description, $duration, $url_img1, $url_img2, $stock, $price);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Redirecionar
    header("Location: admin_produtos.php");
    exit;
}
