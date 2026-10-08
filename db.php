<!-- Arquivo: db.php -->
<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'bd_lab_ideias';

// Conexão
$conn = new mysqli($host, $user, $pass, $db);
mysqli_set_charset($conn, "utf8mb4");
if ($conn->connect_error) {
    die('Falha na conexão: ' . $conn->connect_error);
}
?>