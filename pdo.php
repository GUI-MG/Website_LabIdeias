<?php

function getPDOConnection(): PDO {
    // Configurações de conexão com o banco
    $host = 'localhost';
    $db   = 'bd_lab_ideias';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    // Criar conexão PDO
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        $pdo->exec("SET NAMES 'utf8mb4'");  // Garante que a conexão use UTF-8
    } catch (PDOException $e) {
        die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
    }

    return $pdo;
}

?>