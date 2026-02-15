<?php

// Em caso de não haver sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'sql/bd.php';


$profile_pic = null;

$navUser = $_SESSION['id_user'] ?? null;

if (isset($_SESSION['id_user'])) {
    $navUser = (int) $_SESSION['id_user'];

    // Buscar foto de perfil
    $pic_query = "SELECT foto_utilizador FROM utilizadores WHERE id_utilizador = $navUser";
    $pic_result = $conn->query($pic_query);

    if ($pic_result && $pic_result->num_rows > 0) {
        $profile_pic = $pic_result->fetch_assoc();

        $pic = !empty($profile_pic['foto_utilizador'])
            ? $profile_pic['foto_utilizador']
            : 'imagens/default_user.png';
    }
}
?>

<script src="https://kit.fontawesome.com/7a24afdce7.js" crossorigin="anonymous"></script>
<header>
    <style>
        nav {
            height: 115px;
            margin: 0;

            border-bottom: solid 3px #2fdd2f;
            font-family: "Galaxy";
            font-size: 14px !important;
        }

        .navbar {
            position: relative;
            z-index: 1050;
        }

        .navbar-nav {
            justify-content: center;
            text-align: center;
            width: fit-content;
        }

        .navbar .nav-link,
        .dropdown-item {
            color: white !important;
        }

        .navbar .nav-link:hover {
            color: #b6dba4 !important;
        }

        .session {
            font-size: 12px;
            padding-top: 12%;
        }

        .nav-item {
            padding-right: 20px;
        }

        #navbarNav {
            justify-content: center;
            background: radial-gradient(closest-side, #2fdd2f 0%, #120b17 100%);
        }

        @media (min-width:1400px) {
            #navbarNav {
                background: radial-gradient(closest-side, #2fdd2f 0%, #120b17 70%);
            }
        }

        #logo {
            width: 150px;
            height: auto;
        }

        #bv {
            width: 175px;
            height: auto;
            padding-right: 20px;
        }

        .nav-brand {
            margin-bottom: -30px;
        }

        #profile_pic {
            width: 50px;
            height: 50px;
            object-fit: cover;
            background-color: #33ff0086;
            border-radius: 40%;
        }
    </style>
    <nav class="navbar navbar-expand-lg">

        <img src="imagens/Board_Verse_Logo-01.webp" alt="logo" id="logo" class="nav-brand">
        <img src="imagens/Board_Verse.webp" alt="logo_name" id="bv">
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="sobre.php">Sobre nós</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Loja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="eventos.php">Eventos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contactos.php">Contactos</a>
                </li>

            </ul>
        </div>

        <ul class="navbar-nav ms-auto">

            <?php if (!isset($_SESSION['id_user'])): ?>

                <li class="nav-item">
                    <a class="nav-link session" href="login.php">Login</a>
                </li>

            <?php else: ?>

                <li class="nav-item">
                    <a class="nav-link session" href="logout.php">Terminar Sessão</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="personal_data.php">
                        <img
                            src="<?= htmlspecialchars($pic) ?>"
                            alt="Foto utilizador"
                            id="profile_pic">
                    </a>
                </li>

            <?php endif; ?>

        </ul>
    </nav>
</header>