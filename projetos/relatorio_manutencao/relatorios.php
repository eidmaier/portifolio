<?php
//relatorios.php
require_once 'db.php';

// Buscar todos os clientes (relatórios)
$stmt = $pdo->query("SELECT * FROM clientes ORDER BY id DESC");
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Processar exclusão de relatório
if (isset($_POST['delete_relatorio'])) {
    $cliente_id = $_POST['cliente_id'];
    
    // Primeiro, exclua todos os posts associados ao cliente
    $stmt = $pdo->prepare("DELETE FROM posts WHERE cliente_id = ?");
    $stmt->execute([$cliente_id]);
    
    // Em seguida, exclua o cliente
    $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
    $stmt->execute([$cliente_id]);
    
    header("Location: relatorios.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Relatórios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            text-decoration: none;
            background-color: #3498db;
            color: #fff;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .btn-delete {
            background-color: #e74c3c;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        .add-relatorio {
            display: block;
            width: 200px;
            margin: 20px auto;
            text-align: center;
            padding: 10px;
            background-color: #2ecc71;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .add-relatorio:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
    <h1>Lista de Relatórios</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Cliente</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?php echo $cliente['id']; ?></td>
                    <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                    <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                    <td>
                        <a href="view_relatorio.php?id=<?php echo $cliente['id']; ?>" class="btn">Ver</a>
                        <a href="edit_relatorio.php?id=<?php echo $cliente['id']; ?>" class="btn">Editar</a>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="cliente_id" value="<?php echo $cliente['id']; ?>">
                            <button type="submit" name="delete_relatorio" class="btn btn-delete" onclick="return confirm('Tem certeza que deseja excluir este relatório?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="novo_relatorio.php" class="add-relatorio">Adicionar Novo Relatório</a>
</body>
</html>