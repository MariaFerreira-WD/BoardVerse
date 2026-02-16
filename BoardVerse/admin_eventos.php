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
    <meta name="description" content="Admin - Eventos" />
    <meta name="keywords" content="BoardVerse, Loja, Board Games" />
    <meta name="author" content="Maria Inês Ferreira" />
    <title>Admin - Eventos</title>
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

    .event-card {
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .event-card:hover {
        transform: translateY(-4px);
    }

    .event-img {
        transition: filter 0.3s ease;
        height: 200px;
    }

    .event-img:hover {
        filter: brightness(0.85);
    }

    .card-body {
        background-color: #120b17;
        color: white;
    }

    .card-title {
        font-weight: 600;
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
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <button class="btn btn-admin" onclick="add_event()">
                    Adicionar evento
                </button>
            </div>
            <div class="row">
                <?php while ($events = $events_result->fetch_assoc()): ?>
                    <div class="col-lg-3 mb-4">
                        <div class="card event-card">
                            <img
                                src="<?= $events['imagem'] ?>"
                                class="card-img-top event-img"
                                alt="img_evento"
                                data-bs-toggle="collapse"
                                data-bs-target="#event<?= $events['id_evento'] ?>"
                                style="cursor: pointer;">

                            <div class="collapse" id="event<?= $events['id_evento'] ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $events['titulo'] ?></h5>
                                    <p class="card-text"><?= $events['corpo'] ?></p>

                                    <div class="event_btn">
                                        <form action="edit_eventos.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $events['id_evento'] ?>">
                                            <button class="btn editBtn">Editar</button>
                                        </form>

                                        <form action="admin_eventos.php" method="get">
                                            <input type="hidden" name="id_event" value="<?= $events['id_evento'] ?>">
                                            <button class="btn deleteBtn">Apagar</button>
                                        </form>
                                    </div>
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
    <script>
        function add_event() {
            window.location.href = "add_evento.php";
        }
    </script>
</body>

</html>