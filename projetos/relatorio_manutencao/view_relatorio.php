<?php
//view_relatorio.php
require_once 'db.php';

$cliente_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$cliente_id) {
    header("Location: relatorios.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->execute([$cliente_id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    header("Location: relatorios.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE cliente_id = ? ORDER BY id DESC");
$stmt->execute([$cliente_id]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Relatório - <?php echo htmlspecialchars($cliente['nome']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1, h2 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        .cliente-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .cliente-info p {
            margin: 10px 0;
        }

        .post {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .post h3 {
            color: #3498db;
            margin-top: 0;
        }

        .before, .after {
            margin-top: 20px;
        }

        .before h4, .after h4 {
            color: #2c3e50;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        img {
            width: 100%;
            height: auto;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        @media (min-width: 768px) {
            .post-content {
                display: flex;
                justify-content: space-between;
            }

            .before, .after {
                width: 48%;
            }
        }
    </style>
</head>
<body>
<h1>Relatório de <?php echo htmlspecialchars($cliente['nome']); ?></h1>

<div class="cliente-info">
    <p><strong>Nome:</strong> <?php echo htmlspecialchars($cliente['nome']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($cliente['email']); ?></p>
    <p><strong>Telefone:</strong> <?php echo htmlspecialchars($cliente['telefone']); ?></p>
    <p><strong>Assunto:</strong> <?php echo htmlspecialchars($cliente['assunto']); ?></p>
    <p><strong>Prestador de Serviço:</strong> <?php echo htmlspecialchars($cliente['prestador_servico']); ?></p>
    <p><strong>Profissão:</strong> <?php echo htmlspecialchars($cliente['profissao']); ?></p>
</div>

<h2>Posts</h2>
<?php if (empty($posts)): ?>
    <p>Nenhum post encontrado para este cliente.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
            <div class="post-content">
                <div class="before">
                    <h4>Antes</h4>
                    <img src="uploads/<?php echo $post['before_image']; ?>" alt="Antes">
                    <p><?php echo htmlspecialchars($post['before_description']); ?></p>
                </div>
                <div class="after">
                    <h4>Depois</h4>
                    <img src="uploads/<?php echo $post['after_image']; ?>" alt="Depois">
                    <p><?php echo htmlspecialchars($post['after_description']); ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

    <a href="relatorios.php" class="btn">Voltar para a lista de relatórios</a>
    <a href="salvar_pdf.php?id=<?php echo $cliente_id; ?>" class="btn">Exportar PDF</a>
</body>
</html>