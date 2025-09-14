<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = 'uploads/';
    $reciboId = $_POST['recibo_id'];
    $uploadFile = $uploadDir . basename($_FILES['file-upload']['name']);

    if (move_uploaded_file($_FILES['file-upload']['tmp_name'], $uploadFile)) {
        echo "Arquivo válido e enviado com sucesso.\n";
    } else {
        echo "Possível ataque de upload de arquivo!\n";
    }
}
?>
