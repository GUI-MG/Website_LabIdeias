<?php

function salvarImagemProjeto(array $arquivo): ?string
{
    if (($arquivo['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if (($arquivo['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Não foi possível enviar a imagem. Tente novamente.');
    }

    if (
        !isset($arquivo['tmp_name'], $arquivo['size'])
        || !is_string($arquivo['tmp_name'])
        || !is_numeric($arquivo['size'])
        || !is_uploaded_file($arquivo['tmp_name'])
    ) {
        throw new RuntimeException('O arquivo enviado não é válido.');
    }

    if ((int)$arquivo['size'] > 5 * 1024 * 1024) {
        throw new RuntimeException('A imagem deve ter no máximo 5 MB.');
    }

    $tiposPermitidos = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];
    $tipo = (new finfo(FILEINFO_MIME_TYPE))->file($arquivo['tmp_name']);
    $informacoesImagem = getimagesize($arquivo['tmp_name']);

    if (!isset($tiposPermitidos[$tipo]) || $informacoesImagem === false || $informacoesImagem['mime'] !== $tipo) {
        throw new RuntimeException('Envie uma imagem válida nos formatos JPEG, PNG, GIF ou WebP.');
    }

    $diretorio = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'projetos';
    if (!is_dir($diretorio) && !mkdir($diretorio, 0755, true) && !is_dir($diretorio)) {
        throw new RuntimeException('Não foi possível preparar o armazenamento das imagens.');
    }

    try {
        do {
            $nomeArquivo = bin2hex(random_bytes(16)) . '.' . $tiposPermitidos[$tipo];
        } while (file_exists($diretorio . DIRECTORY_SEPARATOR . $nomeArquivo));
    } catch (Throwable $e) {
        throw new RuntimeException('Não foi possível gerar o nome da imagem.');
    }

    $destino = $diretorio . DIRECTORY_SEPARATOR . $nomeArquivo;
    if (!move_uploaded_file($arquivo['tmp_name'], $destino)) {
        throw new RuntimeException('Não foi possível armazenar a imagem enviada.');
    }

    return 'uploads/projetos/' . $nomeArquivo;
}

function removerImagemProjeto(?string $caminho): bool
{
    if ($caminho === null) {
        return true;
    }

    if (!preg_match('~\Auploads/projetos/[a-f0-9]{32}\.(?:jpg|png|gif|webp)\z~D', $caminho)) {
        return false;
    }

    $arquivo = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $caminho);
    return !is_file($arquivo) || unlink($arquivo);
}
