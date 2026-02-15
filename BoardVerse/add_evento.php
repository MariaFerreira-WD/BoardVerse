<?php
session_start();

require_once 'sql/bd.php';

// Buscar eventos na tabela Eventos
$events_result = $conn->query("SELECT * FROM eventos");

// Apagar evento

if (isset($_GET['id_event'])) {
    $id_event = (int) $_GET['id_event'];
    $delete = $conn->prepare("DELETE FROM eventos WHERE id_evento = ?");
    $delete->bind_param("i", $id_event);
    $delete->execute();
    $delete->close();
}


?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Add novo evento" />
    <meta name="keywords" content="BoardVerse, Loja, Board Games" />
    <meta name="author" content="Maria Inês Ferreira" />
    <title>Adicionar novo evento</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="css/admin_style.css" />
</head>
<style>
    .event_btn {
        display: flex;
        justify-content: space-between;
    }
</style>

<body>
    <header>
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="header">
                    <h1 class="h3">Eventos</h1>
                </div>
                <div class="d-flex gap-2">
                    <a class='btn btn-admin' href="admin.php">Voltar</a>
                </div>
            </div>
        </div>
    </header>
    <main>

    </main>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>