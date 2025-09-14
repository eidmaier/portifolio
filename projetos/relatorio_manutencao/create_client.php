<?php
// create_client.php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_name = $_POST['client_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $pdo->prepare("INSERT INTO clients (name, email, phone) VALUES (?, ?, ?)");
    $stmt->execute([$client_name, $email, $phone]);

    header('Location: create.php?client_id=' . $pdo->lastInsertId());
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Formulário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Novo Formulário</h1>
    <form action="salvar_cliente.php" method="post">
    <!-- Campos existentes -->
    <input type="text" name="nome" required>
    <input type="email" name="email" required>
    <input type="tel" name="telefone" required>
    
    <!-- Novos campos -->
    <input type="text" name="assunto" placeholder="Assunto" required>
    <input type="text" name="prestador_servico" placeholder="Nome do Prestador de Serviço" required>
    <input type="text" name="profissao" placeholder="Profissão do Prestador" required>
    
    <button type="submit">Salvar Cliente</button>
</form>
</body>
</html>