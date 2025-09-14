<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_recibo";
$port = 3306; // Ajuste a porta se necessário

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter ID do recibo da solicitação
$id = $_GET['id'];

// Preparar e executar consulta SQL
$stmt = $conn->prepare("SELECT * FROM receipts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Converter o resultado em um array associativo
    $recibo = $result->fetch_assoc();
    // Retornar os dados do recibo como JSON
    echo json_encode($recibo);
} else {
    // Nenhum recibo encontrado
    echo json_encode(null);
}

$stmt->close();
$conn->close();
?>
