<?php
session_start();

$id = (int) ($_POST['id'] ?? 0);
$quantidade = (int) ($_POST['quantity'] ?? 0);

if ($id <= 0 || $quantidade <= 0 || !isset($_SESSION['cart'][$id])) {
    echo json_encode(['error' => true]);
    exit;
}

$_SESSION['cart'][$id]['quantidade'] = $quantidade;

$subtotal = $_SESSION['cart'][$id]['preco'] * $quantidade;

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['preco'] * $item['quantidade'];
}

echo json_encode([
    'subtotal' => number_format($subtotal, 2, ',', '.'),
    'total'    => number_format($total, 2, ',', '.')
]);
