<?php
session_start();

// Base de dados
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'boardverse';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se ID existe
if (!isset($_POST['id'])) {
    die('ID da notícia não fornecido');
}

$id = (int) $_POST['id'];

// Verificar upload
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
    die('Erro no upload da imagem');
}

// Extensão
$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png'];

if (!in_array($ext, $allowed)) {
    die('Extensão inválida');
}

// Tamanho máximo (2MB)
if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
    die('Imagem demasiado grande');
}

// Gerar nome único
$newName = uniqid('eventos_', true) . '.' . $ext;
$path = 'imagens/eventos/' . $newName;

// Mover ficheiro
if (!move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
    die('Erro ao guardar imagem');
}

// Update
$stmt = $conn->prepare(
    "UPDATE eventos SET imagem = ? WHERE id_noticia = ?"
);

$stmt->bind_param("si", $path, $id);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: edit_evento.php?id=$id");
exit;
