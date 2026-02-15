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

// Informação do ticket submetido
if (isset($_POST['send'])) {
    $id_order = $_POST['id_order'];
    $title_ticket = $_POST['title_ticket'];
    $subject = $_POST['subject'];
    $description = $_POST['description'];

    $file = NULL;
    $target_dir = "tickets_files/";

    // Caminho do file
    if (!empty($_FILES['ticket_file']['name'])) {

        $file_name = time() . "_" . basename($_FILES['ticket_file']['name']);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['ticket_file']['tmp_name'], $target_file)) {
            $file = $file_name;
        }
    }

    // Atualizar tabela ticket com o pedido
    $ticket = $conn->prepare("INSERT INTO tickets (id_utilizador, id_encomenda, titulo, assunto, descricao, file) VALUES (?,?,?,?,?,?)");
    $ticket->bind_param("iissss", $id_user, $id_order, $title_ticket, $subject, $description, $file);
    $ticket->execute();

    header("Location: tickets_client_support.php");
    exit;
}


?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Enviar ticket" />
    <meta name="keywords" content="BoardVerse, Loja, Board Games" />
    <meta name="author" content="Maria Inês Ferreira" />
    <title>Apoio ao cliente</title>
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
                                                            <a class="dropdown-item nav-link active" href="client_support.php"><i class="fa-solid fa-plus"></i> Criar pedido</a>
                                                            <a class="dropdown-item nav-link" href="tickets_client_support.php"><i class="fa-solid fa-list"></i> Estado dos meus pedidos</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Enviar Pedido -->

                                    <div class="col-lg-9">
                                        <div class="p-4 editData">
                                            <div class="mb-4">
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <h5 class="mb-4">Enviar pedido</h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button onclick="consult()" class="btn btn-perfil consult">Consultar Pedidos</button>
                                                    </div>
                                                </div>
                                                <form action="client_support.php" name="ticket" enctype="multipart/form-data" method="POST">
                                                    <div class="row g-4">
                                                        <input type="hidden" name="id_user" value="<?= $id_user ?>">
                                                        <div class="col-md-6">
                                                            <label class="form-label d-flex">Id da encomenda</label>
                                                            <input type="text" class="form-control" name="id_order" placeholder="#">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label d-flex">Título do pedido</label>
                                                            <input type="text" class="form-control" name="title_ticket">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label d-flex">Assunto</label>
                                                            <select class="form-select" aria-label="Default select example" name="subject">
                                                                <option selected>Selecione o assunto</option>
                                                                <option value="devolucao">Devolução</option>
                                                                <option value="troca">Troca</option>
                                                                <option value="encomenda">Encomenda</option>
                                                                <option value="outros">Outros</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label d-flex">Descrição da situação</label>
                                                            <textarea class="form-control" id="description" name="description" rows="4" cols="120"></textarea>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label d-flex">Anexar ficheiro (se necessário)</label>
                                                            <input type="file" name="ticket_file" id="file" multiple>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button class="btn btn-perfil" name="send">Enviar</button>
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
    <script>
        function consult() {
            window.location.href = 'tickets_client_support.php';
        }
    </script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>

</html>