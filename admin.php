<?php
$host = 'localhost';
$db = 'bd_projetos_ideias';
$user = 'root';
$pass = '';

// Conectar ao banco
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Pegar dados do formulário
$usuario = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';

// Prevenir SQL Injection
$usuario = $conn->real_escape_string($usuario);
$senhaHash = hash('sha256', $senha); // Criptografar senha

// Verificar no banco
$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senhaHash'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    echo "Login realizado com sucesso!";
    // Aqui você pode iniciar uma sessão, redirecionar etc.
    // session_start();
    // $_SESSION['usuario'] = $usuario;
    // header("Location: painel.php");
} else {
    echo "Usuário ou senha inválidos!";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br><br>

        <input type="submit" value="Entrar">
    </form>
</body>
</html>
