<?php

session_start();

require_once 'sql/bd.php';

if (isset($_POST['add'])) {

    // Dados do formulário
    $title = $_POST['title'];
    $body = $_POST['body'];
    $url = $_POST['url'];


    $ext1 = strtolower(pathinfo($_FILES['img_event']['name'], PATHINFO_EXTENSION));

    $uploadDir = __DIR__ . '/imagens/eventos/';


    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Permissões completas
    }

    if (!is_writable($uploadDir)) {
        die("A pasta de upload não tem permissões de escrita");
    }


    $img1 = uniqid() . '.' . $ext1;

    // Guardar imagens
    if (!move_uploaded_file($_FILES['img_event']['tmp_name'], $uploadDir . $img1)) {
        die("Falha ao guardar evento");
    }

    $url_img1 = 'imagens/eventos/' . $img1;

    // Inserir na base de dados
    $stmt = $conn->prepare("INSERT INTO eventos 
        (titulo, corpo, imagem, url)
        VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $body, $url_img1, $url);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Redirecionar
    header("Location: admin_eventos.php");
    exit;
}
