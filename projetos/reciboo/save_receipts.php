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

// Preparar e vincular
$stmt = $conn->prepare("INSERT INTO receipts (valor, pagante, documento, importancia, servicos, docum, local, data, ass) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("dssssssss", $valor, $pagante, $documento, $importancia, $servicos, $docum, $local, $data, $ass);

// Definir parâmetros e executar
// O `id` será gerado automaticamente pelo banco de dados

// Processar valor
$valor = $_POST['valor'];
// Remover símbolo de moeda e substituir vírgula por ponto
$valor = str_replace('R$ ', '', $valor);
$valor = str_replace(',', '.', $valor);
$valor = floatval($valor); // Converter para float

$pagante = $_POST['pagante'];
$documento = $_POST['documento'];
$importancia = $_POST['importancia'];
$servicos = $_POST['servicos'];
$docum = $_POST['docum'];
$local = $_POST['local'];

// Processar data
$data = $_POST['data'];
// Converter data para o formato YYYY-MM-DD
$data = DateTime::createFromFormat('d/m/Y', $data);
if ($data) {
    $data = $data->format('Y-m-d');
} else {
    die("Data inválida: " . $_POST['data']);
}

$ass = $_POST['ass'];

if ($stmt->execute()) {
    echo "Novo registro inserido com sucesso";
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
