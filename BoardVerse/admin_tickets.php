<?php
session_start();

require_once 'sql/bd.php';

// Buscar e agrupar os tickets enviados
$tickets_query = "SELECT * FROM tickets ORDER BY id_ticket ASC";
$tickets_result = $conn->query($tickets_query);

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Utilizadores registados" />
    <meta name="keywords" content="BoardVerse, Loja, Board Games" />
    <meta name="author" content="Maria Inês Ferreira" />
    <title>Admin - Utilizadores</title>
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
                    <h1 class="h3 mb-0">Tickets</h1>
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
                    <tr class="sticky-top">
                        <th>ID Ticket</th>
                        <th>ID Utilizador</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Titulo</th>
                        <th>Assunto</th>
                        <th>Descrição</th>
                        <th>Data</th>
                        <th>Estado</th>
                        <th>Anexo(s)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($tickets = $tickets_result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= $tickets['id_ticket']  ?></td>
                            <td><?= $tickets['id_utilizador'] ?></td>
                            <td><?= $tickets['nome_utilizador'] ?></td>
                            <td><?= $tickets['email'] ?></td>
                            <td><?= $tickets['titulo'] ?></td>
                            <td><?= $tickets['assunto'] ?></td>
                            <td><?= $tickets['descricao'] ?></td>
                            <td><?= $tickets['data'] ?></td>
                            <td><?= $tickets['estado'] ?></td>
                            <td>
                                <a href="tickets_files/<?= htmlspecialchars($tickets['file']) ?>" target="_blank">
                                    <img src="tickets_files/<?= htmlspecialchars($tickets['file']) ?>" style="width: 50px; height: auto; cursor: pointer;" alt="Anexo">
                                </a>

                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>