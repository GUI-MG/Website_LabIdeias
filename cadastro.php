<?php
require 'db.php';

// Inicializa variáveis de feedback
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $email     = trim($_POST['email']);

    // Verifica se todos os campos estão preenchidos
    if ($titulo && $descricao && $email) {
        // Prepara o comando de inserção (sem created_at, pois é automático no MySQL)
        $stmt = $conn->prepare(
            "INSERT INTO ideias (email, titulo, descricao) VALUES (?, ?, ?)"
        );

        // Liga os parâmetros (email, titulo, descricao)
        $stmt->bind_param('sss', $email, $titulo, $descricao);

        if ($stmt->execute()) {
            $success = 'Ideia cadastrada com sucesso!';
        } else {
            $error = 'Erro ao cadastrar ideia: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $error = 'Por favor, preencha todos os campos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Ideia - Laboratório de Ideias</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-5">
    <h2 class="mb-4">Cadastrar Ideia:</h2>
    <h6><b>Observação:</b></h6>
    <p>No cadastro de ideias, informe o título da ideia, uma breve descrição e um e-mail para contato, caso ela seja contemplada para desenvolvimento.</p>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post" class="form-idea">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <textarea name="descricao" id="descricao" rows="5" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
