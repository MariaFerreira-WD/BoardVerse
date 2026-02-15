<?php
session_start();

require_once 'sql/bd.php';

// Buscar e agrupar as encomendas realizadas à base de dados
$order_query = "SELECT id_encomenda, nome, data_encomenda, total, estado FROM encomendas ORDER BY data_encomenda ASC";
$order_result = $conn->query($order_query);



?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Encomendas realizadas" />
    <meta name="keywords" content="BoardVerse, Loja, Board Games" />
    <meta name="author" content="Maria Inês Ferreira" />
    <title>Admin - Encomendas</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="css/admin_style.css" />
</head>

<body>
    <header>
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="header">
                    <h1 class="h3 mb-0">Encomendas</h1>
                </div>
                <div class="d-flex gap-2">
                    <a href="admin.php" class="btn btn-admin">Voltar</a>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container mt-4">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Data</th>
                        <th>Total</th>
                        <th>Estado da Encomenda</th>
                        <th>Alterar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $order_result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= $order['id_encomenda']  ?></td>
                            <td><?= $order['nome'] ?></td>
                            <td><?= $order['data_encomenda'] ?></td>
                            <td><?= $order['total'] ?> €</td>
                            <td><?= $order['estado'] ?></td>
                            <td>

                                <form action="status_encomenda.php" method="POST">

                                    <input type="hidden" name="id" value="<?= $order['id_encomenda'] ?>">

                                    <select name="status" onchange="this.form.submit()">

                                        <option value="Em processamento" <?= $order['estado'] == 'Em processamento' ? 'selected' : '' ?>>Em processamento</option>
                                        <option value="Centro de Distribuicao" <?= $order['estado'] == 'Centro de Distribuicao' ? 'selected' : '' ?>>Centro de Distribuicao</option>
                                        <option value="Em transito" <?= $order['estado'] == 'Em transito' ? 'selected' : '' ?>>Em transito</option>
                                        <option value="Entregue" <?= $order['estado'] == 'Entregue' ? 'selected' : '' ?>>Entregue</option>

                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include 'componentes/footer.php'; ?>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>