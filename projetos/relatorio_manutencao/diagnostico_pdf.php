<?php
ob_start();

function check_output($stage) {
    $output = ob_get_contents();
    if (!empty($output)) {
        echo "Saída detectada no estágio: $stage\n";
        echo "Conteúdo:\n$output\n";
        echo "--------------------\n";
        ob_clean();
    }
}

check_output('Início');

require_once 'db.php';
check_output('Após db.php');

$cliente_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$cliente_id) {
    echo "ID do cliente não fornecido ou inválido";
    exit;
}

check_output('Após verificação de ID');

// Buscar dados do cliente
$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->execute([$cliente_id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    echo "Cliente não encontrado";
    exit;
}

check_output('Após busca do cliente');

// Buscar posts do cliente
$stmt = $pdo->prepare("SELECT * FROM posts WHERE cliente_id = ? ORDER BY id DESC");
$stmt->execute([$cliente_id]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

check_output('Após busca dos posts');

echo "Diagnóstico concluído sem problemas de saída.";