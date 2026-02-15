<?php


session_start();

// Elimina todas as variaveis
session_unset();

// Destrói a sessão
session_destroy();

// Redireciona o utilizador para a página inicial (ou login)
header("Location: index.php");
exit();
