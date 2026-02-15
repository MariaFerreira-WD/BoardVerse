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

// Buscar informação à tabela Utilizadores
$user_query = "SELECT * FROM utilizadores where id_utilizador = $id_user ";
$user_result = $conn->query($user_query);

if ($user_result->num_rows == 0) {
    die("Erro");
}

$user = $user_result->fetch_assoc();


?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Editar perfil do utilizador" />
    <meta name="keywords" content="BoardVerse, Loja, Board Games" />
    <meta name="author" content="Maria Inês Ferreira" />
    <title>Perfil</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://kit.fontawesome.com/7a24afdce7.js" crossorigin="anonymous"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include 'componentes/navbar.php'; ?>
    <main class="flex-fill">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <div>
            <div class="container py-5">
                <div class="row">
                    <div class="col-4 mb-4">
                        <div class="text-center">
                            <p class="text mb-3">Bem vindo, </p>
                            <h3 class="mt-3 mb-1"><?= $user['nome_utilizador'] ?></h3>
                        </div>
                    </div>
                    <div class="col-6 mb-4 d-flex" style="justify-content: center;">
                        <form id="form" action="upload_profile_pic.php" enctype="multipart/form-data" method="post">
                            <div class="upload">
                                <img src="<?= $user['foto_utilizador'] ?>" alt="profile_pic" class="img-fluid profile_pic">
                                <div class="round" style="background-color:#2fdd2f ">
                                    <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
                                    <i class="fa fa-camera-retro" style="color: black;"></i>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class=" col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    <div class="col-lg-3 border-end">
                                        <div class="p-4 sideBar">
                                            <div class="nav flex-column nav-pills">
                                                <a class="nav-link active" href="personal_data.php"><i class="fas fa-user me-2"></i>Perfil</a>
                                                <a class="nav-link" href="security.php"><i class="fas fa-lock me-2"></i>Segurança</a>
                                                <a class="nav-link" href="orders.php"><i class="fa-solid fa-dolly me-2"></i>Encomendas</a>

                                                <div class="nav-item dropdown position-static">
                                                    <div class="btn-group">
                                                        <button
                                                            type="button"
                                                            class="btn nav-link dropdown-toggle"
                                                            data-bs-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-solid fa-headset me-2"></i> Apoio ao cliente
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
                                                <h5 class="mb-4">Dados pessoais</h5>
                                                <form action="change_data.php" method="POST">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Nome</label>
                                                            <input type="text" class="form-control" name="name" placeholder="<?= $user['nome_utilizador'] ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Data de Nascimento</label>
                                                            <input type="date" class="form-control" name="date">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email" placeholder="<?= $user['email'] ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Telemóvel</label>
                                                            <input type="tel" class="form-control" name="phone" placeholder="<?= $user['telemovel'] ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Morada</label>
                                                            <input type="text" class="form-control" name="adress" placeholder="<?= $user['morada'] ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Código Postal</label>
                                                            <input type="text" class="form-control" name="zipcode" placeholder="<?= $user['codigo_postal'] ?>">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-perfil">Alterar</button>
                                                        </div>
                                                    </div>
                                                </form>
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
    <script type="text/javascript">
        document.getElementById('image').onchange = function() {
            document.getElementById('form').submit();
        }
    </script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>

</html>