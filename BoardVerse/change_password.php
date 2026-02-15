<?php
session_start();
require_once 'sql/bd.php';

if (!isset($_SESSION['id_user'])) {
    die("Acesso não autorizado.");
}

$id_user = $_SESSION['id_user'];

$password_atual = $_POST['password_atual'];
$password_nova = $_POST['password_nova'];
$password_confirmar = $_POST['password_confirmar'];

//  Verificar se as novas passwords coincidem
if ($password_nova !== $password_confirmar) {
    die("As palavras-passe não coincidem.");
}

//  Buscar password atual da BD
$sql = "SELECT password FROM utilizadores WHERE id_utilizador = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

//  Verificar password atual
if (!password_verify($password_atual, $user['password'])) {
    die("Palavra-passe atual incorreta.");
}

//  Criar hash da nova password
$nova_password_hash = password_hash($password_nova, PASSWORD_DEFAULT);

// Atualizar na BD
$update = "UPDATE utilizadores SET password = ? WHERE id_utilizador = ?";
$stmt = $conn->prepare($update);
$stmt->bind_param("si", $nova_password_hash, $id_user);
$stmt->execute();

// Sucesso
header("Location: security.php?success=1");
exit;
