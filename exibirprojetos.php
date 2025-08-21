<?php
// Configurações de conexão com o banco
$host = 'localhost';
$db   = 'bd_ideias_projetos';
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

    // Ano atual
    $anoAtual = date('Y');

    // Consulta com filtro pelo ano atual
    $sql = "SELECT titulo, resumo, periodo_desenvolvimento 
            FROM projetos 
            WHERE periodo_desenvolvimento = :ano";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ano', $anoAtual, PDO::PARAM_INT);
    $stmt->execute();
    $projetos = $stmt->fetchAll();

    if ($projetos) {
        echo '<div class="container">';
        echo '<h3>Projetos de ' . $anoAtual . '</h3>';
        echo '<div class="row">';

        foreach ($projetos as $projeto) {
            echo '<div class="col-md-6 mb-4">';
            echo '  <div class="card">';
            echo '    <div class="card-body">';
            echo '      <h5 class="card-title">' . htmlspecialchars($projeto['titulo']) . '</h5>';
            echo '      <p class="card-text"><strong>Resumo:</strong> ' . nl2br(htmlspecialchars($projeto['resumo'])) . '</p>';
            echo '      <p class="card-text"><strong>Ano:</strong> ' . htmlspecialchars($projeto['periodo_desenvolvimento']) . '</p>';
            echo '    </div>';
            echo '  </div>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
    } else {
        echo '<p class="text-muted">Nenhum projeto encontrado para o ano de ' . $anoAtual . '.</p>';
    }

} catch (PDOException $e) {
    echo '<p class="text-danger">Erro ao conectar ou buscar dados: ' . $e->getMessage() . '</p>';
}
?>
