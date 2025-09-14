<!-- header.php -->

<?php

?>

<!-- <link rel="stylesheet" type="text/css" href="css/crop.css"> -->
<link rel="stylesheet" type="text/css" href="src/layout.css">
<link rel="stylesheet" type="text/css" href="src/css/search.css">
<link rel="stylesheet" type="text/css" href="src/css/header.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">

<div class="header"><!-- INI class header -->

    <div class="logo"><!-- • logo • -->
        <a href="index.php">
            <span id="logo-text">Partilhi</span>
        </a>
    </div><!-- X logo X -->

    <div class="search"><!-- • search • -->
        <div class="search-box">
            <form id="search-form" action="javascript:void(0);" method="GET">
                <input id="search-input" class="search-input" name="query" placeholder="Pesquisar" required />
                <div class="search-buttons">
                    <button id="clear-button" class="clear-button" type="button" onclick="clearSearch()">
                        <i class="fas fa-times"></i>
                    </button>
                    <button id="search-button" class="search-button" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="keyboard-button" type="button" onclick="toggleKeyboard()">
                        <i class="fas fa-keyboard"></i>
                    </button>
                    <button class="audio-button" type="button" onclick="startAudio()">
                        <i class="fas fa-microphone"></i>
                    </button>
                </div>
            </form>
        </div>

        <div id="virtual-keyboard" class="virtual-keyboard">
            <div class="row">
                <button onclick="addCharacter('1')">1</button>
                <button onclick="addCharacter('2')">2</button>
                <button onclick="addCharacter('3')">3</button>
                <button onclick="addCharacter('4')">4</button>
                <button onclick="addCharacter('5')">5</button>
                <button onclick="addCharacter('6')">6</button>
                <button onclick="addCharacter('7')">7</button>
                <button onclick="addCharacter('8')">8</button>
                <button onclick="addCharacter('9')">9</button>
                <button onclick="addCharacter('0')">0</button>
                <button onclick="addCharacter('-')">-</button>
                <button onclick="addCharacter('=')">=</button>
                <button onclick="backspace()">Backspace</button>
            </div>
            <div class="row">
                <button onclick="addCharacter('q')">q</button>
                <button onclick="addCharacter('w')">w</button>
                <button onclick="addCharacter('e')">e</button>
                <button onclick="addCharacter('r')">r</button>
                <button onclick="addCharacter('t')">t</button>
                <button onclick="addCharacter('y')">y</button>
                <button onclick="addCharacter('u')">u</button>
                <button onclick="addCharacter('i')">i</button>
                <button onclick="addCharacter('o')">o</button>
                <button onclick="addCharacter('p')">p</button>
                <button onclick="addCharacter('[')">[</button>
                <button onclick="addCharacter(']')">]</button>
                <button onclick="addCharacter('\\')">\\</button>
            </div>
            <div class="row">
                <button class="shift" onclick="toggleShift()">Shift</button>
                <button onclick="addCharacter('a')">a</button>
                <button onclick="addCharacter('s')">s</button>
                <button onclick="addCharacter('d')">d</button>
                <button onclick="addCharacter('f')">f</button>
                <button onclick="addCharacter('g')">g</button>
                <button onclick="addCharacter('h')">h</button>
                <button onclick="addCharacter('j')">j</button>
                <button onclick="addCharacter('k')">k</button>
                <button onclick="addCharacter('l')">l</button>
                <button onclick="addCharacter('ç')">ç</button>
                <button onclick="addCharacter(';')">;</button>
                <button onclick="addCharacter('\'')">\'</button>
                <button onclick="addCharacter('Enter')">Enter</button>
            </div>
            <div class="row">
                <button class="capslock" onclick="toggleCapsLock()">Caps Lock</button>
                <button onclick="addCharacter('z')">z</button>
                <button onclick="addCharacter('x')">x</button>
                <button onclick="addCharacter('c')">c</button>
                <button onclick="addCharacter('v')">v</button>
                <button onclick="addCharacter('b')">b</button>
                <button onclick="addCharacter('n')">n</button>
                <button onclick="addCharacter('m')">m</button>
                <button onclick="addCharacter(',')">,</button>
                <button onclick="addCharacter('.')">.</button>
                <button onclick="addCharacter('/')">/</button>
            </div>
            <div class="row">
                <button class="ctrl" onclick="toggleCtrl()">Ctrl</button>
                <button class="tab" onclick="addCharacter('Tab')">Tab</button>
                <button onclick="addCharacter(' ')" style="width: 150px;">Space</button>
                <button onclick="addCharacter('?')">?</button>
                <button onclick="addCharacter('!')">!</button>
                <button onclick="addCharacter('@')">@</button>
                <button onclick="addCharacter('#')">#</button>
                <button onclick="addCharacter('$')">$</button>
                <button onclick="addCharacter('%')">%</button>
                <button onclick="addCharacter('&')">&</button>
                <button onclick="addCharacter('*')">*</button>
            </div>
        </div>
        <script>
            function clearSearch() {
                document.getElementById('search-input').value = '';
            }
        </script>
        <script src="src/js/search.js"></script>
    </div><!-- X search X -->

    <div class="#"><!-- INI class # -->
    
    </div><!-- FIM class # -->

</div><!-- FIM class header -->