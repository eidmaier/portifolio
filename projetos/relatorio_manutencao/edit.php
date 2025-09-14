<?php
// edit.php
require_once 'db.php';

function isAllowedImageType($file) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    return in_array($file['type'], $allowed_types);
}

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #4CAF50;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"],
        textarea {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
        }

        button:hover {
            background-color: #45a049;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        img {
            max-width: 200px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Post</h1>
        <form action="update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">

            <label for="title">Título:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>

            <label for="assunto">Assunto:</label>
            <input type="text" id="assunto" name="assunto" value="<?php echo htmlspecialchars($post['assunto']); ?>" required>

            <label for="prestador_servico">Prestador de Serviço:</label>
            <input type="text" id="prestador_servico" name="prestador_servico" value="<?php echo htmlspecialchars($post['prestador_servico']); ?>" required>

            <label for="profissao">Profissão:</label>
            <input type="text" id="profissao" name="profissao" value="<?php echo htmlspecialchars($post['profissao']); ?>" required>

            <label for="before_image">Upload Nova Imagem Antes (JPG, PNG, GIF, WebP) (opcional):</label>
            <input type="file" id="before_image" name="before_image" accept="image/jpeg,image/png,image/gif,image/webp">
            <img src="uploads/<?php echo $post['before_image']; ?>" alt="Imagem Antes">

            <label for="before_description">Descrever sobre Antes:</label>
            <textarea id="before_description" name="before_description" required><?php echo htmlspecialchars($post['before_description']); ?></textarea>

            <label for="after_image">Upload Nova Imagem Depois (JPG, PNG, GIF, WebP) (opcional):</label>
            <input type="file" id="after_image" name="after_image" accept="image/jpeg,image/png,image/gif,image/webp">
            <img src="uploads/<?php echo $post['after_image']; ?>" alt="Imagem Depois">

            <label for="after_description">Descrever sobre Depois:</label>
            <textarea id="after_description" name="after_description" required><?php echo htmlspecialchars($post['after_description']); ?></textarea>

            <button type="submit">Atualizar</button>
        </form>
        <form action="delete.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este post?');">
            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
            <button type="submit" class="btn-danger">Excluir</button>
        </form>
    </div>
</body>
</html>