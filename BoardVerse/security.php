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





?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Editar perfil do utilizador" />
    <meta name="keywords" content="BoardVerse, Loja, Board Games" />
    <meta name="author" content="Maria Inês Ferreira" />
    <title>Segurança</title>
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

        <div class="bg">
            <div class="container py-5">
                <div class="row">
                    <div class="col-4 mb-4">
                        <div class="text-center">
                            <p class="text mb-3">Bem vindo, </p>
                            <h3 class="mt-3 mb-1"><?= $user['nome_utilizador'] ?></h3>
                        </div>
                    </div>
                    <div class="col-6 mb-4 d-flex" style="justify-content: center;">
                        <div class="upload">
                            <img src="<?= $user['foto_utilizador'] ?>" alt="profile_pic" class="img-fluid profile_pic">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    <div class="col-lg-3 border-end">
                                        <div class="p-4 sideBar">
                                            <div class="nav flex-column nav-pills">
                                                <a class="nav-link" href="personal_data.php"><i class="fas fa-user me-2"></i>Perfil</a>
                                                <a class="nav-link active" href="security.php"><i class="fas fa-lock me-2"></i>Segurança</a>
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
                                                <div class="row g-3">
                                                    <div class="new_password">
                                                        <h5 class="mb-4">Alterar palavra-passe</h5>
                                                        <?php if (isset($_GET['success'])): ?>
                                                            <div class="alert alert-success">
                                                                Palavra-passe alterada com sucesso!
                                                            </div>
                                                        <?php endif; ?>
                                                        <form action="change_password.php" method="POST">

                                                            <div class="mb-4">
                                                                <label class="form-label">Palavra-passe atual</label>
                                                                <input type="password" class="form-control" name="password_atual" required>
                                                            </div>

                                                            <div class="mb-4">
                                                                <label class="form-label">Palavra-passe nova</label>
                                                                <input type="password" class="form-control" name="password_nova" required>
                                                            </div>

                                                            <div class="mb-4">
                                                                <label class="form-label">Confirmar palavra-passe</label>
                                                                <input type="password" class="form-control" name="password_confirmar" required>
                                                            </div>

                                                            <button class="btn btn-perfil" type="submit" name="change">
                                                                Alterar
                                                            </button>

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
            </div>
        </div>
    </main>
    <?php include 'componentes/footer.php'; ?>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>

</html>