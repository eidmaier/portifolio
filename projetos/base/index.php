<!-- index.php -->

<?php
// PHP code can go here if needed
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>base</title>

    <!-- <link rel="stylesheet" href="src/css/style.css"> -->
    <link rel="stylesheet" href="src/css/layout.css">
    <link rel="stylesheet" href="src/css/nav_top.css">
    <!-- <link rel="stylesheet" type="text/css" href="src/css/search.css"> -->
    <link rel="stylesheet" type="text/css" href="src/css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <!-- JS -->
    <script src="script.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>

</head>

<body class="light">

    <div class="container"><!-- INI class container -->
        <nav class="nav-top">
            <?php include "src/layout/nav_top.php"; ?>
        </nav>

        <header>
            <?php include "src/layout/header.php"; ?>
        </header>

        <div class="content">
            <nav class="nav-left">
                <h2>Menu</h2>
                <ul>
                    <li><a href="index.html">Início</a></li>
                    <li><a href="sobre.html">Sobre</a></li>
                    <li><a href="contato.html">Contato</a></li>
                </ul>
            </nav>

            <main>
                <h2>Main Content</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            </main>

            <aside>
                <h2>Aside</h2>
            </aside>
        </div>

        <footer>
            <p>Footer</p>
        </footer>

        <script src="script.js"></script>
</body>
</div><!-- FIM class container -->

</html>