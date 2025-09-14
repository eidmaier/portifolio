<?php
// novo_relatorio.php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar o formulário de novo cliente
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $assunto = $_POST['assunto'];
    $prestador_servico = $_POST['prestador_servico'];
    $profissao = $_POST['profissao'];

    $stmt = $pdo->prepare("INSERT INTO clientes (nome, email, telefone, assunto, prestador_servico, profissao) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $email, $telefone, $assunto, $prestador_servico, $profissao]);
    $cliente_id = $pdo->lastInsertId();

    // Redirecionar para a página de criação de posts com o novo cliente_id
    header("Location: create.php?cliente_id=$cliente_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Relatório</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Novo Relatório</h1>
    <form action="novo_relatorio.php" method="post">
        <label for="nome">Nome do Cliente:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" placeholder="(xx) xxxx-xxxx" required>

        <label for="assunto">Assunto:</label>
        <input type="text" id="assunto" name="assunto" required>

        <label for="prestador_servico">Prestador de Serviço:</label>
        <input type="text" id="prestador_servico" name="prestador_servico" required>

        <label for="profissao">Profissão:</label>
        <input type="text" id="profissao" name="profissao" required>

        <button type="submit">Criar Novo Relatório</button>
    </form>
    <a href="index.php" class="btn">Voltar</a>
</body>
</html>