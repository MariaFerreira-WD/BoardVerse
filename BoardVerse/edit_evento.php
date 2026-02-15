<?php
session_start();

require_once 'sql/bd.php';


?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Editar evento" />
    <meta name="keywords" content="BoardVerse, Loja, Board Games" />
    <meta name="author" content="Maria Inês Ferreira" />
    <title>Editar evento</title>
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

<body class="d-flex flex-column min-vh-100">
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
    <main class="flex-fill">
        <div class="container">
            <div class="row">
                <?php while ($events = $events_result->fetch_assoc()): ?>
                    <div class="col-lg-3">
                        <div class="card" style="width: 18rem;">
                            <img src="<?= $events['imagem'] ?>" class="card-img-top" alt="img_evento">
                            <div class="card-body">
                                <h5 class="card-title"><?= $events['titulo'] ?></h5>
                                <p class="card-text"><?= $events['corpo'] ?></p>
                                <div class="event_btn">
                                    <form action="edit_eventos.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value=<?= $events['id_evento'] ?>>
                                        <button type="submit" class="btn btn-admin" name="edit">Editar</button>
                                    </form>
                                    <form action="admin_eventos.php" method="get">
                                        <input type="hidden" name="id_event" value=<?= $events['id_evento'] ?>>
                                        <button class="btn btn-delete" type="submit">Apagar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>