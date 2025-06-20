<!-- Arquivo: db.php -->
<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'bd_projetos_ideias';

// Conexão
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Falha na conexão: ' . $conn->connect_error);
}
?>