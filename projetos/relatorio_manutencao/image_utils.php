<?php
//image_utils.php
function processUploadedImage($file, $upload_dir) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $max_size = 10 * 1024 * 1024; // 10 MB

    // Verificar o tamanho do arquivo
    if ($file['size'] > $max_size) {
        throw new Exception("O arquivo é muito grande. O tamanho máximo permitido é 10 MB.");
    }

    // Obter informações sobre o arquivo
    $file_info = getimagesize($file['tmp_name']);
    if ($file_info === false) {
        throw new Exception("Arquivo inválido. Por favor, envie uma imagem válida.");
    }

    // Verificar o tipo de imagem
    $detected_type = $file_info['mime'];
    if (!in_array($detected_type, $allowed_types)) {
        throw new Exception("Tipo de arquivo não permitido. Use JPG, PNG, GIF ou WebP.");
    }

    // Gerar um nome único para o arquivo
    $extension = image_type_to_extension($file_info[2]);
    $new_filename = uniqid() . $extension;

    // Caminho completo do novo arquivo
    $new_filepath = $upload_dir . $new_filename;

    // Criar uma nova imagem baseada no tipo detectado
    switch ($detected_type) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($file['tmp_name']);
            break;
        case 'image/png':
            $image = imagecreatefrompng($file['tmp_name']);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($file['tmp_name']);
            break;
        case 'image/webp':
            $image = imagecreatefromwebp($file['tmp_name']);
            break;
    }

    if (!$image) {
        throw new Exception("Não foi possível processar a imagem. Por favor, tente outra.");
    }

    // Salvar a imagem processada
    switch ($detected_type) {
        case 'image/jpeg':
            imagejpeg($image, $new_filepath, 90); // 90 é a qualidade
            break;
        case 'image/png':
            imagepng($image, $new_filepath, 9); // 9 é o nível de compressão (0-9)
            break;
        case 'image/gif':
            imagegif($image, $new_filepath);
            break;
        case 'image/webp':
            imagewebp($image, $new_filepath, 90); // 90 é a qualidade
            break;
    }

    // Liberar a memória
    imagedestroy($image);

    return $new_filename;
}