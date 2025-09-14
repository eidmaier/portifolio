<?php
//update.php
require_once 'db.php';
require_once 'image_utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        die("Post não encontrado.");
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $before_description = $_POST['before_description'];
    $after_description = $_POST['after_description'];

    $stmt = $pdo->prepare("UPDATE posts SET title = ?, before_description = ?, after_description = ? WHERE id = ?");
    $stmt->execute([$title, $before_description, $after_description, $id]);

    $upload_dir = 'uploads/';

    try {
        if (!empty($_FILES['before_image']['name'])) {
            $before_image = processUploadedImage($_FILES['before_image'], $upload_dir);
            $stmt = $pdo->prepare("UPDATE posts SET before_image = ? WHERE id = ?");
            $stmt->execute([$before_image, $id]);
        }

        if (!empty($_FILES['after_image']['name'])) {
            $after_image = processUploadedImage($_FILES['after_image'], $upload_dir);
            $stmt = $pdo->prepare("UPDATE posts SET after_image = ? WHERE id = ?");
            $stmt->execute([$after_image, $id]);
        }

        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Editar Post</h1>
    
    <?php if (isset($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
        
        <label for="title">Título:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        
        <label for="before_image">Imagem Antes:</label>
        <input type="file" id="before_image" name="before_image" accept="image/*">
        <img src="uploads/<?php echo $post['before_image']; ?>" alt="Imagem Antes" style="max-width: 200px;">
        
        <label for="before_description">Descrição Antes:</label>
        <textarea id="before_description" name="before_description" required><?php echo htmlspecialchars($post['before_description']); ?></textarea>
        
        <label for="after_image">Imagem Depois:</label>
        <input type="file" id="after_image" name="after_image" accept="image/*">
        <img src="uploads/<?php echo $post['after_image']; ?>" alt="Imagem Depois" style="max-width: 200px;">
        
        <label for="after_description">Descrição Depois:</label>
        <textarea id="after_description" name="after_description" required><?php echo htmlspecialchars($post['after_description']); ?></textarea>
        
        <button type="submit">Atualizar Post</button>
    </form>
    
    <a href="index.php" class="btn">Voltar para a Lista</a>
</body>
</html>