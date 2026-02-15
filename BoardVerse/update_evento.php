<?php
session_start();

// Base de dados
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'boardverse';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}


$id_news = intval($_POST['id_event']);
$title = $_POST['title'];
$body = $_POST['message'];
$url = $_POST['url'];

// Update 

$edit_event = $conn->prepare(
    "UPDATE eventos SET titulo = ?, corpo = ?, url = ? WHERE id_noticia = ?"
);
$edit_event->bind_param("sssi", $title, $body, $url, $id_news);
$edit_event->execute();
$edit_event->close();
$conn->close();

header("Location:edit_evento.php?id=$id_news");
exit;
