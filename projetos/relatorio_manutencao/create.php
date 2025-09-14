<?php
// create.php
require_once 'db.php';

$cliente_id = isset($_GET['cliente_id']) ? intval($_GET['cliente_id']) : null;

if (!$cliente_id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->execute([$cliente_id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $before_description = $_POST['before_description'];
    $after_description = $_POST['after_description'];

    // Processar o upload das imagens
    $upload_dir = "uploads/";

    function processImageUpload($file, $upload_dir) {
        $target_file = $upload_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $unique_filename = uniqid() . '.' . $imageFileType;
        $target_file = $upload_dir . $unique_filename;

        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return false;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            return false;
        }

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $unique_filename;
        } else {
            return false;
        }
    }

    $before_image = processImageUpload($_FILES["before_image"], $upload_dir);
    $after_image = processImageUpload($_FILES["after_image"], $upload_dir);

    if ($before_image && $after_image) {
        $stmt = $pdo->prepare("INSERT INTO posts (cliente_id, title, before_image, before_description, after_image, after_description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$cliente_id, $title, $before_image, $before_description, $after_image, $after_description]);

        header("Location: create.php?cliente_id=$cliente_id&success=1");
        exit;
    } else {
        $error = "Erro no upload das imagens. Por favor, tente novamente.";
    }
}

$success = isset($_GET['success']) ? $_GET['success'] : null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Novo Post</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        button[type="submit"] {
            background-color: #3498db;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
        }

        .btn {
            display: inline-block;
            background-color: #2ecc71;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #27ae60;
        }

        .success {
            background-color: #2ecc71;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .error {
            background-color: #e74c3c;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        #cropModal {
    display: none; /* Inicialmente escondido */
    position: fixed; /* Posiciona o modal fixo em relação à viewport */
    z-index: 1000; /* Certifique-se de que está acima de outros elementos */
    left: 0;
    top: 0;
    width: 100%; /* Largura total */
    height: 100%; /* Altura total */
    overflow: auto; /* Permite rolagem, se necessário */
    background-color: rgba(0, 0, 0, 0.8); /* Fundo escurecido */
    justify-content: center; /* Centraliza horizontalmente */
    align-items: center; /* Centraliza verticalmente */
    display: flex; /* Usar flexbox para centralizar */
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto; /* Ajuste a margem para centralizar melhor */
    padding: 0;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    position: relative; /* Adicione esta linha */
}

        .modal-body {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #image-preview {
            max-width: 100%;
            max-height: 60vh;
            /* Ajusta a altura máxima da imagem */
            object-fit: contain;
            /* Mantém as proporções da imagem */
        }
    </style>
</head>
<body>
    <h1>Criar Novo Post para <?php echo htmlspecialchars($cliente['nome']); ?></h1>
    <?php if ($success): ?>
        <p class="success">Post criado com sucesso!</p>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form action="create.php?cliente_id=<?php echo $cliente_id; ?>" method="post" enctype="multipart/form-data">
        <label for="title">Título:</label>
        <input type="text" id="title" name="title" required>

        <label for="before_image">Imagem Antes:</label>
        <input type="file" id="before_image" name="before_image" required>
        <input type="hidden" id="before_image_data" name="before_image_data">

        <label for="before_description">Descrição Antes:</label>
        <textarea id="before_description" name="before_description" required></textarea>

        <label for="after_image">Imagem Depois:</label>
        <input type="file" id="after_image" name="after_image" required>
        <input type="hidden" id="after_image_data" name="after_image_data">

        <label for="after_description">Descrição Depois:</label>
        <textarea id="after_description" name="after_description" required></textarea>

        <button type="submit">Criar Post</button>
    </form>
    
    <a href="index.php?cliente_id=<?php echo $cliente_id; ?>" class="btn">Finalizar Relatório</a>

    <div id="cropModal" style="display:none;">
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

        function initCropper(imageInput, dataInput) {
            const file = imageInput.files[0];
            const reader = new FileReader();

            reader.onload = function(event) {
                const cropImage = document.getElementById('cropImage');
                cropImage.src = event.target.result;

                const modal = document.getElementById('cropModal');
                modal.style.display = 'flex';

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(cropImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                });

                currentImageInput = dataInput;
            }

            reader.readAsDataURL(file);
        }

        document.getElementById('before_image').addEventListener('change', function() {
            initCropper(this, document.getElementById('before_image_data'));
        });

        document.getElementById('after_image').addEventListener('change', function() {
            initCropper(this, document.getElementById('after_image_data'));
        });

        document.getElementById('cropButton').addEventListener('click', function() {
            const croppedCanvas = cropper.getCroppedCanvas();
            currentImageInput.value = croppedCanvas.toDataURL('image/png');
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