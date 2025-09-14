<?php
// src/structure/nav_top.php
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>base</title>

    <!-- <link rel="stylesheet" href="src/css/style.css"> -->
    <link rel="stylesheet" href="src/css/nav_top.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body class="light">
    <nav class="nav-top">

        <div class="navtop-item left">
            <a href="">Link1</a>
            <a href="">Link2</a>
            <a href="">Link3</a>
        </div>

        <div class="navtop-item item right">

            <div class="socicons"><!-- • socicons • -->
                <a href="https://wa.me/SEU_NUMERO" target="_blank" title="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://www.facebook.com/SEU_PERFIL" target="_blank" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/SEU_PERFIL" target="_blank" title="X (Twitter)">
                    <i class="fab fa-twitter"></i>
                </a>
                <!-- <a href="https://www.linkedin.com/in/SEU_PERFIL" target="_blank" title="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a> -->
            </div><!-- X social icons X -->

            <div>
                <a href="#" class="links-navtop">Cadastrar</a>
            </div>

            <div>
                <a href="#" class="links-navtop">Login</a>
            </div>

            <div class="theme-controls">
                <button class="dropdown-trigger">
                    <i class="fa-solid fa-palette"></i>
                </button>
                <div class="theme-dropdown">
                    <button class="theme-toggle">
                        <i class="fas fa-sun"></i>
                    </button>
                    <div class="color-picker-wrapper">
                        <input type="color" class="color-picker" value="#d0d0d0">
                        <i class="fa-solid fa-brush"></i>
                    </div>
                </div>
            </div>
        </div>
        <script src="src/js/theme.js"></script>
    </nav>


</body>

</html>