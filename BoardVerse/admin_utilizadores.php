<?php
session_start();

require_once 'sql/bd.php';

// Buscar e agrupar os utilizadores registados na base de dados
$users_query = "SELECT id_utilizador, nome_utilizador, role FROM utilizadores ORDER BY id_utilizador ASC";
$users_result = $conn->query($users_query);

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
                    <h1 class="h3 mb-0">Utilizadores</h1>
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
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($users = $users_result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= $users['id_utilizador']  ?></td>
                            <td><?= $users['nome_utilizador'] ?></td>
                            <td><?= $users['role'] ?></td>
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