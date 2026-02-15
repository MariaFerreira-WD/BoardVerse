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

if (!isset($_GET['id'])) {
    die("Ticket não encontrado");
}

$id = intval($_GET['id']);

$ticket = "SELECT * FROM tickets WHERE id_ticket = $id";
$ticket_result = $conn->query($ticket);

$ticket_selected = $ticket_result->fetch_assoc();




?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Ticket" />
    <meta name="keywords" content="BoardVerse, Loja, Board Games" />
    <meta name="author" content="Maria Inês Ferreira" />
    <title>Editar Perfil</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/7a24afdce7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css" />
</head>
<style>
    .contact-wrapper {
        background: black;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
    }

    .contact-info {
        background: transparent;
        padding: 40px;
        color: white;
        height: 560px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }

    .contact-item:hover {
        transform: translateX(10px);
    }

    .contact-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    .social-links {
        margin-top: 30px;
    }

    .social-icon {
        width: 35px;
        height: 35px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        transition: all 0.3s ease;
        color: white;
    }

    .social-icon:hover {
        background: white;
        color: #731eac;
        transform: translateY(-3px);
    }

    .contact-form {
        padding: 40px;
        background-color: rgb(0, 0, 0);
    }

    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        border: 2px solid #eee;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #731eac;
        box-shadow: none;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 8px;
        padding-left: 4px;
    }
</style>

<body class="d-flex flex-column min-vh-100">
    <?php include 'componentes/navbar.php'; ?>
    <main class="flex-fill">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <div>
            <div class="container py-5">
                <div class="row ">
                    <div class="col-4 mb-4">
                        <div class="text-center">
                            <p class="text mb-3">Bem vindo,</p>
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
                                                <a class="nav-link" href="security.php"><i class="fas fa-lock me-2"></i>Segurança</a>
                                                <a class="nav-link" href="orders.php"><i class="fa-solid fa-dolly me-2"></i>Encomendas</a>

                                                <div class="nav-item dropdown position-static">
                                                    <div class="btn-group">
                                                        <button
                                                            type="button"
                                                            class="btn nav-link active dropdown-toggle"
                                                            data-bs-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-solid fa-headset me-2"></i> Apoio ao cliente
                                                        </button>
                                                        <div class="dropdown-menu nav-pills">
                                                            <a class="dropdown-item nav-link" href="client_support.php"><i class="fa-solid fa-plus"></i> Criar pedido</a>
                                                            <a class="dropdown-item nav-link active" href="tickets_client_support.php"><i class="fa-solid fa-list"></i> Estado dos meus pedidos</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Estado do Pedido  -->

                                    <div class="col-lg-9">
                                        <div class="contact-wrapper">
                                            <div class="row g-0">
                                                <div class="col-md-12">
                                                    <div class="contact-form">
                                                        <h3 class="mb-4"><?= ucfirst($ticket_selected['titulo']) ?>
                                                            <i class="returnBtn fa-solid fa-arrow-left fa-xl" style="float:right;" onclick="window.location.href='tickets_client_support.php'"></i>
                                                        </h3>
                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Id do pedido </label>
                                                                <p class="form-control">#<?= $ticket_selected['id_ticket'] ?></p>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Assunto</label>
                                                                <p class="form-control"><?= $ticket_selected['assunto'] ?></p>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Data</label>
                                                                <p class="form-control"><?= date($ticket_selected['data']) ?></p>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Descrição</label>
                                                            <p class="form-control"><?= $ticket_selected['descricao'] ?></p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Anexo(s)</label>
                                                            <p>
                                                                <?php

                                                                // Ver o anexo
                                                                $file = $ticket_selected['file'];
                                                                $file_path = "tickets_files/$file";

                                                                // Verificar o tipo de ficheiro
                                                                if (!empty($file) && file_exists($file_path)) {
                                                                    $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

                                                                    // Se for imagem, mostrar diretamente
                                                                    if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                                                        echo '<img src="' . $file_path . '" alt="Anexo" class="img-fluid">';
                                                                    }
                                                                    // Se for PDF, fornecer link
                                                                    elseif ($file_extension === 'pdf') {
                                                                        echo '<a href="' . $file_path . '" target="_blank">Abrir PDF</a>';
                                                                    }
                                                                    // Outros tipos de arquivo
                                                                    else {
                                                                        echo '<a href="' . $file_path . '" download>Download do anexo</a>';
                                                                    }
                                                                } else {
                                                                    echo "Sem anexos";
                                                                }
                                                                ?>
                                                            </p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Estado</label>
                                                            <p class="form-control"><?= $ticket_selected['estado'] ?></p>
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
        </div>
    </main>
    <?php include 'componentes/footer.php'; ?>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>

</html>