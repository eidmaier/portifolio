<?php
// edit_relatorio.php
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

// Fetch existing posts for the client
$stmt = $pdo->prepare("SELECT * FROM posts WHERE cliente_id = ? ORDER BY id DESC");
$stmt->execute([$cliente_id]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_cliente'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $assunto = $_POST['assunto'];
        $prestador_servico = $_POST['prestador_servico'];
        $profissao = $_POST['profissao'];

        $stmt = $pdo->prepare("UPDATE clientes SET nome = ?, email = ?, telefone = ?, assunto = ?, prestador_servico = ?, profissao = ? WHERE id = ?");
        $stmt->execute([$nome, $email, $telefone, $assunto, $prestador_servico, $profissao, $cliente_id]);
    } elseif (isset($_POST['add_post'])) {
        $title = $_POST['title'];
        $before_description = $_POST['before_description'];
        $after_description = $_POST['after_description'];

        // Process image uploads from base64 data
        $before_image = $_POST['before_image_data'];
        $after_image = $_POST['after_image_data'];

        // Convert base64 to image and save
        $before_image_filename = 'before_' . time() . '.png';
        $after_image_filename = 'after_' . time() . '.png';

        file_put_contents("uploads/" . $before_image_filename, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $before_image)));
        file_put_contents("uploads/" . $after_image_filename, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $after_image)));

        $stmt = $pdo->prepare("INSERT INTO posts (cliente_id, title, before_image, before_description, after_image, after_description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$cliente_id, $title, $before_image_filename, $before_description, $after_image_filename, $after_description]);
    } elseif (isset($_POST['edit_post'])) {
        $post_id = $_POST['post_id'];
        $title = $_POST['edit_title'];
        $before_description = $_POST['edit_before_description'];
        $after_description = $_POST['edit_after_description'];

        $stmt = $pdo->prepare("UPDATE posts SET title = ?, before_description = ?, after_description = ? WHERE id = ?");
        $stmt->execute([$title, $before_description, $after_description, $post_id]);

        // Handle image updates
        if (!empty($_POST['edit_before_image_data'])) {
            $before_image = $_POST['edit_before_image_data'];
            $before_image_filename = 'before_' . time() . '.png';
            file_put_contents("uploads/" . $before_image_filename, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $before_image)));
            
            $stmt = $pdo->prepare("UPDATE posts SET before_image = ? WHERE id = ?");
            $stmt->execute([$before_image_filename, $post_id]);
        }

        if (!empty($_POST['edit_after_image_data'])) {
            $after_image = $_POST['edit_after_image_data'];
            $after_image_filename = 'after_' . time() . '.png';
            file_put_contents("uploads/" . $after_image_filename, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $after_image)));
            
            $stmt = $pdo->prepare("UPDATE posts SET after_image = ? WHERE id = ?");
            $stmt->execute([$after_image_filename, $post_id]);
        }
    } elseif (isset($_POST['delete_post'])) {
        $post_id = $_POST['post_id'];
        $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->execute([$post_id]);
    }

    header("Location: edit_relatorio.php?id=" . $cliente_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Relatório - <?php echo htmlspecialchars($cliente['nome']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
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

        h1, h2 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="file"] {
            margin-bottom: 15px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2980b9;
        }

        .post {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .post h3 {
            margin-top: 0;
            color: #3498db;
        }

        .image-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .image-container img {
            width: 48%;
            height: auto;
        }

        #cropModal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        #cropImage {
            max-width: 100%;
            display: block;
            margin: 0 auto;
        }

        @media (max-width: 600px) {
            .image-container {
                flex-direction: column;
            }
            .image-container img {
                max-width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <h1>Editar Relatório de <?php echo htmlspecialchars($cliente['nome']); ?></h1>
    
    <h2>Dados do Cliente</h2>
    <form method="post">
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

        <button type="submit" name="update_cliente">Atualizar Dados do Cliente</button>
    </form>

    <h2>Adicionar Novo Post</h2>
    <form method="post" enctype="multipart/form-data" id="addPostForm">
        <label for="title">Título:</label>
        <input type="text" id="title" name="title" required>

        <label for="before_image">Imagem Antes:</label>
        <input type="file" id="before_image" name="before_image" accept="image/*" required>
        <input type="hidden" id="before_image_data" name="before_image_data">
        <img id="before_image_preview" src="" alt="Preview" style="max-width: 200px; display: none;">

        <label for="before_description">Descrição Antes:</label>
        <textarea id="before_description" name="before_description" required></textarea>

        <label for="after_image">Imagem Depois:</label>
        <input type="file" id="after_image" name="after_image" accept="image/*" required>
        <input type="hidden" id="after_image_data" name="after_image_data">
        <img id="after_image_preview" src="" alt="Preview" style="max-width: 200px; display: none;">

        <label for="after_description">Descrição Depois:</label>
        <textarea id="after_description" name="after_description" required></textarea>

        <button type="submit" name="add_post">Adicionar Post</button>
    </form>

    <h2>Posts Existentes</h2>
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
            <p><strong>Descrição Antes:</strong> <?php echo htmlspecialchars($post['before_description']); ?></p>
            <p><strong>Descrição Depois:</strong> <?php echo htmlspecialchars($post['after_description']); ?></p>
            <div class="image-container">
                <img src="uploads/<?php echo htmlspecialchars($post['before_image']); ?>" alt="Imagem Antes">
                <img src="uploads/<?php echo htmlspecialchars($post['after_image']); ?>" alt="Imagem Depois">
            </div>

            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                
                <label for="edit_title_<?php echo $post['id']; ?>">Título:</label>
                <input type="text" name="edit_title" id="edit_title_<?php echo $post['id']; ?>" value="<?php echo htmlspecialchars($post['title']); ?>" required>

                <label for="edit_before_image_<?php echo $post['id']; ?>">Nova Imagem Antes:</label>
                <input type="file" name="edit_before_image" id="edit_before_image_<?php echo $post['id']; ?>" accept="image/*">
                <input type="hidden" name="edit_before_image_data" id="edit_before_image_data_<?php echo $post['id']; ?>">
                <img id="edit_before_image_preview_<?php echo $post['id']; ?>" src="" alt="Preview" style="max-width: 200px; display: none;">

                <label for="edit_before_description_<?php echo $post['id']; ?>">Descrição Antes:</label>
                <textarea name="edit_before_description" id="edit_before_description_<?php echo $post['id']; ?>" required><?php echo htmlspecialchars($post['before_description']); ?></textarea>

                <label for="edit_after_image_<?php echo $post['id']; ?>">Nova Imagem Depois:</label>
                <input type="file" name="edit_after_image" id="edit_after_image_<?php echo $post['id']; ?>" accept="image/*">
                <input type="hidden" name="edit_after_image_data" id="edit_after_image_data_<?php echo $post['id']; ?>">
                <img id="edit_after_image_preview_<?php echo $post['id']; ?>" src="" alt="Preview" style="max-width: 200px; display: none;">

                <label for="edit_after_description_<?php echo $post['id']; ?>">Descrição Depois:</label>
                <textarea name="edit_after_description" id="edit_after_description_<?php echo $post['id']; ?>" required><?php echo htmlspecialchars($post['after_description']); ?></textarea>

                <button type="submit" name="edit_post">Atualizar Post</button>
                <button type="submit" name="delete_post" onclick="return confirm('Tem certeza que deseja excluir este post?')">Excluir Post</button>
            </form>
        </div>
    <?php endforeach; ?>

    <a href="relatorios.php" style="display: inline-block; margin-top: 20px; background-color: #3498db; color: #fff; padding: 10px 15px; text-decoration: none; border-radius: 4px;">Voltar para a lista de relatórios</a>

    <div id="cropModal">
        <div class="modal-content">
            <h2>Recortar Imagem</h2>
            <img id="cropImage" src="" alt="Imagem para recortar">
            <button id="cropButton">Recortar</button>
            <button id="cancelCropButton">Cancelar</button>
        </div>
    </div>

    <script>
        let cropper;
        let currentImageInput;

        function initCropper(imageInput, previewElement, dataInput) {
            const file = imageInput.files[0];
            const reader = new FileReader();

            reader.onload = function(event) {
                const cropImage = document.getElementById('cropImage');
                cropImage.src = event.target.result;

                const modal = document.getElementById('cropModal');
                modal.style.display = 'block';

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(cropImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                });

                currentImageInput = {
                    preview: previewElement,
                    data: dataInput
                };
            }

            reader.readAsDataURL(file);
        }

        document.getElementById('before_image').addEventListener('change', function(e) {
            initCropper(this, document.getElementById('before_image_preview'), document.getElementById('before_image_data'));
        });

        document.getElementById('after_image').addEventListener('change', function(e) {
            initCropper(this, document.getElementById('after_image_preview'), document.getElementById('after_image_data'));
        });

        // Add event listeners for edit image inputs
        <?php foreach ($posts as $post): ?>
            document.getElementById('edit_before_image_<?php echo $post['id']; ?>').addEventListener('change', function(e) {
                initCropper(this, document.getElementById('edit_before_image_preview_<?php echo $post['id']; ?>'), document.getElementById('edit_before_image_data_<?php echo $post['id']; ?>'));
            });

            document.getElementById('edit_after_image_<?php echo $post['id']; ?>').addEventListener('change', function(e) {
                initCropper(this, document.getElementById('edit_after_image_preview_<?php echo $post['id']; ?>'), document.getElementById('edit_after_image_data_<?php echo $post['id']; ?>'));
            });
        <?php endforeach; ?>

        document.getElementById('cropButton').addEventListener('click', function() {
            const croppedCanvas = cropper.getCroppedCanvas();
            
            currentImageInput.preview.src = croppedCanvas.toDataURL('image/png');
            currentImageInput.preview.style.display = 'block';
            currentImageInput.data.value = croppedCanvas.toDataURL('image/png');

            document.getElementById('cropModal').style.display = 'none';
            cropper.destroy();
        });

        document.getElementById('cancelCropButton').addEventListener('click', function() {
            document.getElementById('cropModal').style.display = 'none';
            if (cropper) {
                cropper.destroy();
            }
        });
    </script>
</body>
</html>