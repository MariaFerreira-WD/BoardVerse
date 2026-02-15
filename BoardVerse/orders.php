<?php

session_start();

require_once 'sql/bd.php';

$id_user = $_SESSION['id_user'];

// Buscar informação à tabela Utilizadores
$user_query = "SELECT * FROM utilizadores where id_utilizador = $id_user ";
$user_result = $conn->query($user_query);

if ($user_result->num_rows == 0) {
    die("Erro");
}

$user = $user_result->fetch_assoc();



// Buscar encomendas + pedidos 

$id_user = (int) $id_user;

$client_orders_query = " SELECT
    e.id_encomenda,
    e.id_utilizador,
    e.nome,
    e.morada_entrega,
    e.codigo_postal_entrega,
    e.data_encomenda,
    e.total,
    e.estado,
    p.nome_produto,
    p.imagem,
    ep.quantidade,
    ep.preco
FROM encomendas e
JOIN encomendas_produtos ep
    ON e.id_encomenda = ep.id_encomenda
JOIN produtos p
    ON ep.id_produto = p.id_produto
WHERE e.id_utilizador = $id_user
ORDER BY e.data_encomenda DESC
";

$client_orders = $conn->query($client_orders_query);

$ordersGrouped = [];

while ($row = $client_orders->fetch_assoc()) {
    $ordersGrouped[$row['id_encomenda']][] = $row;
}

?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Editar perfil do utilizador" />
    <meta name="keywords" content="BoardVerse, Loja, Board Games" />
    <meta name="author" content="Maria Inês Ferreira" />
    <title>Encomendas</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://kit.fontawesome.com/7a24afdce7.js" crossorigin="anonymous"></script>
</head>
<style>
    .accordion-item {
        border: none;
        margin-bottom: 16px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .accordion-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .accordion-button {
        padding: 20px 25px;
        font-weight: 600;
        color: #2fdd2f;
        background-color: black;
        border: 2px solid #2fdd2f;
        transition: all 0.3s ease;
    }

    .accordion-button:not(.collapsed) {
        color: #2fdd2f;
        background-color: black;
        border: 2px solid #2fdd2f;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: #2fdd2f;
    }

    .accordion-button::after {
        background-size: 20px;
        transition: all 0.3s ease;
    }

    .accordion-button:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }

    .accordion-body {
        padding: 25px;
        color: #2fdd2f;
        background-color: black;
        border: 2px solid #2fdd2f;
    }

    table {
        background-color: black;
    }
</style>

<body class="d-flex flex-column min-vh-100">
    <?php include 'componentes/navbar.php'; ?>
    <main class="flex-fill">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <div>
            <div class="container py-5">
                <div class="row">
                    <div class="col-4 mb-4">
                        <div class="welcome text-center">
                            <p class="text mb-3">Bem vindo, </p>
                            <h3 class="mt-3 mb-1"><?= $user['nome_utilizador'] ?></h3>
                        </div>
                    </div>
                    <div class="col-6 mb-4 d-flex" style="justify-content: center;">
                        <div class="upload">
                            <img src="<?= $user['foto_utilizador'] ?>" alt="profile_pic" class="img-fluid profile_pic">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    <div class="col-lg-3 border-end">
                                        <div class="p-4 sideBar">
                                            <div class="nav flex-column nav-pills">
                                                <a class="nav-link" href="personal_data.php"><i class="fas fa-user me-2"></i>Perfil</a>
                                                <a class="nav-link" href="security.php"><i class="fas fa-lock me-2"></i>Segurança</a>
                                                <a class="nav-link active" href="orders.php"><i class="fa-solid fa-dolly me-2"></i>Encomendas</a>

                                                <div class="nav-item dropdown position-static">
                                                    <div class="btn-group">
                                                        <button
                                                            type="button"
                                                            class="btn nav-link dropdown-toggle"
                                                            data-bs-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-solid fa-headset me-2"></i>Apoio ao cliente
                                                        </button>
                                                        <div class="dropdown-menu nav-pills">
                                                            <a class="dropdown-item nav-link" href="client_support.php"><i class="fa-solid fa-plus"></i> Criar pedido</a>
                                                            <a class="dropdown-item nav-link" href="tickets_client_support.php"><i class="fa-solid fa-list"></i> Estado dos meus pedidos</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-9">
                                        <div class="p-4 editData">
                                            <div class="mb-4">
                                                <h5 class="mb-4">Consultar encomendas</h5>
                                                <div class="row g-3">
                                                    <div class="accordion" id="ordersAccordion">
                                                        <?php foreach ($ordersGrouped as $orderId => $orderItems): ?>
                                                            <?php
                                                            $order = $orderItems[0];
                                                            ?>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="heading<?= $orderId ?>">
                                                                    <button
                                                                        class="accordion-button"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#collapse<?= $orderId ?>"
                                                                        aria-expanded="true"
                                                                        aria-controls="collapse<?= $orderId ?>">
                                                                        Encomenda #<?= $orderId ?> — <?= $order['estado'] ?>
                                                                    </button>
                                                                </h2>
                                                                <div id="collapse<?= $orderId ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $orderId ?>" data-bs-parent="#ordersAccordion">
                                                                    <div class="accordion-body">
                                                                        <table class="table table-tickets table-borderless mt-3">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Morada de Entrega</th>
                                                                                    <th>Produto</th>
                                                                                    <th>Data da Encomenda</th>
                                                                                    <th>Total</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <?= $order['morada_entrega'] ?><br>
                                                                                        <?= $order['codigo_postal_entrega'] ?>
                                                                                    </td>

                                                                                    <td>
                                                                                        <?php foreach ($orderItems as $item): ?>
                                                                                            <div class="d-flex align-items-center mb-2">
                                                                                                <img src="<?= $item['imagem'] ?>" alt=""
                                                                                                    style="width:45px; height:30px; margin-right:8px;">
                                                                                                <?= $item['nome_produto'] ?> x <?= $item['quantidade'] ?>
                                                                                            </div>
                                                                                        <?php endforeach; ?>
                                                                                    </td>

                                                                                    <td><?= $order['data_encomenda'] ?></td>

                                                                                    <td>
                                                                                        <?= $order['total'] ?>€
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>

                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include 'componentes/footer.php'; ?>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>

</html>