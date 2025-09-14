<?php
//upload.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descricao_antes = $_POST['descricao_antes'];
    $descricao_depois = $_POST['descricao_depois'];

    $imagem_antes = $_FILES['imagem_antes']['name'];
    $imagem_depois = $_FILES['imagem_depois']['name'];

    move_uploaded_file($_FILES['imagem_antes']['tmp_name'], "uploads/" . $imagem_antes);
    move_uploaded_file($_FILES['imagem_depois']['tmp_name'], "uploads/" . $imagem_depois);

    $conn->query("INSERT INTO relatorios (titulo, imagem_antes, descricao_antes, imagem_depois, descricao_depois) VALUES ('$titulo', '$imagem_antes', '$descricao_antes', '$imagem_depois', '$descricao_depois')");
    
    header("Location: index.php");
}
?>