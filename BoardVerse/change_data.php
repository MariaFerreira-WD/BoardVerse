<?php
session_start();

require_once 'sql/bd.php';

if (!isset($_SESSION['id_user'])) {
    die("Acesso negado.");
}

$id_user = $_SESSION['id_user'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name    = $_POST['name'] ?? '';
    $date    = $_POST['date'] ?? null;
    $email   = $_POST['email'] ?? '';
    $phone   = $_POST['phone'] ?? '';
    $adress  = $_POST['adress'] ?? '';
    $zipcode = $_POST['zipcode'] ?? '';

    if (empty($name) || empty($email)) {
        die("Nome e Email são obrigatórios.");
    }

    $stmt = $conn->prepare("
        UPDATE utilizadores 
        SET nome_utilizador = ?, 
            data_nascimento = ?, 
            email = ?, 
            telemovel = ?, 
            morada = ?, 
            codigo_postal = ?
        WHERE id_utilizador = ?
    ");

    $stmt->bind_param(
        "ssssssi",
        $name,
        $date,
        $email,
        $phone,
        $adress,
        $zipcode,
        $id_user
    );

    if ($stmt->execute()) {
        header("Location: personal_data.php?sucesso=1");
        exit();
    } else {
        echo "Erro ao atualizar dados.";
    }
}
