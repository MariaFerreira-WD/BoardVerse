<?php

session_start();

require_once 'sql/bd.php';

if (isset($_POST['status'], $_POST['id'])) {

    $status = $_POST['status'];
    $id = (int)$_POST['id'];

    $statusAllowed = [
        'Em processamento',
        'Centro de Distribuicao',
        'Em transito',
        'Entregue'
    ];

    if (in_array($status, $statusAllowed)) {

        // Atualizar o status na base de dados
        $update = $conn->prepare("UPDATE encomendas SET status = ?  WHERE id_encomenda = ?");
        $update->bind_param("si", $status, $id);
        $update->execute();
        $update->close();
    }
}

$conn->close();

// Redirecionar para Admin - Encomendas
header("Location: admin_encomendas.php");
exit;
