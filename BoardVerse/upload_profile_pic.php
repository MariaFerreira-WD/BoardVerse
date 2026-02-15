<?php
session_start();

require_once 'sql/bd.php';

if (!isset($_SESSION['id_user'])) {
    exit;
}

if (!isset($_FILES['image'])) {
    exit;
}

$id = $_SESSION['id_user'];

$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png'];

if (!in_array($ext, $allowed)) {
    die('Extensão inválida');
}

$newName = uniqid('profile_', true) . '.' . $ext;
$path = 'imagens/utilizador/' . $newName;

move_uploaded_file($_FILES['image']['tmp_name'], $path);

$stmt = $conn->prepare(
    "UPDATE utilizadores SET foto_utilizador = ? WHERE id_utilizador = ?"
);
$stmt->bind_param("si", $path, $id);
$stmt->execute();

header("Location: personal_data.php");
exit;
