<?php

// Base de dados
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'boardverse';

// Conectar à base de dados
$conn = mysqli_connect($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
