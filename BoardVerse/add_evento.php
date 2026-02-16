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

    .card-sleek {
        background: linear-gradient(135deg, #731eac, #ab63db);
        color: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        margin: auto auto;
    }

    .card-sleek:hover {
        transform: translateY(-5px);
    }

    .card-sleek .card-body {
        padding: 2rem;
    }

    .card-sleek .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .card-sleek .card-text {
        font-size: 1rem;
        line-height: 1.5;
    }

    .card-sleek .btn-sleek {
        background-color: #fff;
        color: #667eea;
        font-weight: bold;
        transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
    }

    .card-sleek .btn-sleek:hover {
        background-color: #667eea;
        color: #fff;
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
            <div class="col-md-6 card card-sleek" style="max-width: 600px;">
                <div class="card-body">
                    <h5 class="card-title">Novo Evento</h5>
                    <form action="new_event.php" enctype="multipart/form-data" method="POST">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Titulo</label>
                                <input type="text" class="form-control" name="title">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Corpo</label>
                                <textarea type="text" class="form-control" name="body"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Imagem</label>
                                <input type="file" class="form-control" name="img_event" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Url</label>
                                <input type="tel" class="form-control" name="url">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-admin" name="add">Adicionar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>