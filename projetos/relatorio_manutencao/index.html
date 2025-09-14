<?php
// index.php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atualizar dados do cliente
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    $stmt = $pdo->prepare("UPDATE clientes SET nome = ?, email = ?, telefone = ? WHERE id = ?");
    $stmt->execute([$nome, $email, $telefone, $cliente_id]);

    // Adicionar novo post
    if (isset($_FILES['before_image']) && isset($_FILES['after_image'])) {
        $title = $_POST['title'];
        $before_description = $_POST['before_description'];
        $after_description = $_POST['after_description'];

        // Função para processar upload de imagem (mesma lógica que antes)
        function processImageUpload($file, $upload_dir) {
            $target_file = $upload_dir . basename($file["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $unique_filename = uniqid() . '.' . $imageFileType;
            $target_file = $upload_dir . $unique_filename;

            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $unique_filename;
            } else {
                return false;
            }
        }

        $upload_dir = "uploads/";
        $before_image = processImageUpload($_FILES["before_image"], $upload_dir);
        $after_image = processImageUpload($_FILES["after_image"], $upload_dir);

        if ($before_image && $after_image) {
            $stmt = $pdo->prepare("INSERT INTO posts (cliente_id, title, before_image, before_description, after_image, after_description) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$cliente_id, $title, $before_image, $before_description, $after_image, $after_description]);
        }
    }

    header("Location: relatorios.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Relatório - <?php echo htmlspecialchars($cliente['nome']); ?></title>
    <style>
        /* Estilos conforme necessário */
    </style>
</head>
<body>
<h1>Editar Relatório de <?php echo htmlspecialchars($cliente['nome']); ?></h1>
<form method="post" enctype="multipart/form-data">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($cliente['nome']); ?>" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" required>

    <label for="telefone">Telefone:</label>
    <input type="tel" id="telefone" name="telefone" value="<?php echo htmlspecialchars($cliente['telefone']); ?>" required>

    <label for="assunto">Assunto:</label>
    <input type="text" id="assunto" name="assunto" value="<?php echo htmlspecialchars($cliente['assunto']); ?>" required>

    <label for="prestador_servico">Prestador de Serviço:</label>
    <input type="text" id="prestador_servico" name="prestador_servico" value="<?php echo htmlspecialchars($cliente['prestador_servico']); ?>" required>

    <label for="profissao">Profissão:</label>
    <input type="text" id="profissao" name="profissao" value="<?php echo htmlspecialchars($cliente['profissao']); ?>" required>

    <h2>Adicionar Novo Post</h2>
    <label for="title">Título:</label>
    <input type="text" id="title" name="title" required>

    <label for="before_image">Imagem Antes:</label>
    <input type="file" id="before_image" name="before_image" required>

    <label for="before_description">Descrição Antes:</label>
    <textarea id="before_description" name="before_description" required></textarea>

    <label for="after_image">Imagem Depois:</label>
    <input type="file" id="after_image" name="after_image" required>

    <label for="after_description">Descrição Depois:</label>
    <textarea id="after_description" name="after_description" required></textarea>

    <button type="submit">Atualizar e Adicionar Post</button>
</form>
<a href="relatorios.php" class="btn">Cancelar</a>
</body>
</html>