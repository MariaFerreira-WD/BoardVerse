<?php

session_start();


require_once 'sql/bd.php';

// Buscar à base de dados
$event_result = $conn->query("SELECT * FROM eventos WHERE id_evento >= 1 ORDER BY id_evento ASC LIMIT 5");

?>



<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Página de Eventos" />
    <meta name="keywords" content="BoardVerse, Loja, Board Games" />
    <meta name="author" content="Maria Inês Ferreira" />
    <title>Eventos</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://kit.fontawesome.com/7a24afdce7.js" crossorigin="anonymous"></script>

    <style>
        .container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .panel-container {
            display: flex;
            width: 80vh;
            margin-top: 20px;
        }

        .panel {
            height: 81vh;
            border-radius: 50px;
            color: #fff;
            flex: 0.5;
            position: relative;
            transition: all 700ms ease-in;
            overflow: hidden;
        }

        .panel h3,
        .panel a {
            font-size: 20px;
            bottom: 20px;
            left: 20px;
            margin: 0;
            opacity: 0;
        }

        .panel p {
            opacity: 0;
            font-size: 14px;
        }

        .panel.active {
            flex: 5;
        }

        .panel.active h3,
        .panel.active p,
        .panel.active a {
            opacity: 1;
            transition: opacity 0.3s ease-in 0.4s;
            margin: 20px;
        }

        @media (max-width: 480px) {
            .container {
                width: 100vw;
            }

            .panel:nth-of-type(4),
            .panel:nth-of-type(5) {
                display: none;
            }
        }


        .panel.active img {
            filter: blur(0);
            object-fit: fill;

        }

        .panel img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            filter: blur(8px);
            transition: filter 0.4s ease;
        }

        .panel.active p {
            display: block;
        }

        a {
            font-size: 24px;
            font-weight: bold;
            padding-left: 35%;
        }

        h3 {
            text-align: center;
        }

        p {
            text-align: justify;
        }

        .carousel-control-prev,
        .carousel-control-next {
            top: 50%;
            height: 200px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: brightness(0) saturate(190%) invert(63%) sepia(93%) saturate(1071%) hue-rotate(68deg) brightness(98%) contrast(200%);
            width: 4rem;
            height: 4rem;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include 'componentes/navbar.php'; ?>
    <main class="flex-fill">

        <div class="panel-container container " id="panel">
            <?php $first = true ?>
            <?php while ($event = $event_result->fetch_assoc()): ?>
                <div class="panel <?= $first ? 'active' : '' ?>">
                    <img src="<?= $event['imagem'] ?>" alt="imgPanel">
                    <h3><?= $event['titulo'] ?></h3>
                    <p><?= $event['corpo'] ?></p>
                    <a style="color:#2fdd2f" href="<?= $event['url'] ?>" target="_blank">Saber mais</a>
                </div>
                <?php $first = false; ?>
            <?php endwhile; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#panel" data-bs-slide="prev" onclick="prev()">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#panel" data-bs-slide="next" onclick="next()">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

    </main>
    <?php include 'componentes/footer.php'; ?>
    <script>
        let panels = document.querySelectorAll(".panel");
        let currentIndex = 0;

        function showPanel(index) {
            panels.forEach((panel) => panel.classList.remove("active"));
            panels[index].classList.add("active");
        }

        function next() {
            currentIndex = (currentIndex + 1) % panels.length;
            showPanel(currentIndex);
        }

        function prev() {
            currentIndex = (currentIndex - 1 + panels.length) % panels.length;
            showPanel(currentIndex);
        }
    </script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>

</html>