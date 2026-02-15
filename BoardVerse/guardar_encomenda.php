<?php

session_start();

require_once 'sql/bd.php';

// Verificar login
if (!isset($_SESSION['id_user'])) {
    die("Erro: utilizador não autenticado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['cart'])) {
    $id_utilizador = (int) $_SESSION['id_user'];
    $nome = $_POST['nome'];
    $morada = trim($_POST['morada_entrega'] ?? '');

    if ($morada === '') {
        die("Erro: a morada de entrega é obrigatória.");
    }

    // Total
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['preco'] * $item['quantidade'];
    }

    // Inserir encomenda
    $order_sql = 'INSERT INTO encomendas (id_utilizador, nome, morada_entrega, total) VALUES (?,?,?,?)';
    $stmt = $conn->prepare($order_sql);
    $stmt->bind_param("issd", $id_utilizador, $nome, $morada, $total);
    $stmt->execute();

    // Id da encomenda criada
    $id_encomenda = $conn->insert_id;

    // Inserir cada produto na tabela encomendas_produtos
    $sql_prod = 'INSERT INTO encomendas_produtos (id_encomenda, id_produto, quantidade, preco) VALUES (?,?,?,?)';
    $stmt_prod = $conn->prepare($sql_prod);

    foreach ($_SESSION['cart'] as $id_produto => $item) {
        $quantidade = $item['quantidade'];
        $preco = $item['preco'];

        $stmt_prod->bind_param("iiid", $id_encomenda, $id_produto, $quantidade, $preco);
        $stmt_prod->execute();
    }

    unset($_SESSION['cart']);


    header("Location: index.php");
    exit;
}
