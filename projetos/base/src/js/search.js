/* js\search.js */

/* ==================
    PESQUISA
==================**/

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const clearButton = document.getElementById('clear-button');
    const searchForm = document.getElementById('search-form');

    // Inicialmente o botão de limpar deve estar oculto
    clearButton.style.display = 'none';

    // Adiciona um evento para o formulário de busca
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const query = searchInput.value.trim();
        if (query) {
            searchContent(query);
        } else {
            clearResults(); // Limpa os resultados se o campo estiver vazio
        }
    });

    // Adiciona um evento para mostrar/ocultar o botão de limpar
    searchInput.addEventListener('input', function() {
        toggleClearButton();
    });
});


// Adiciona um evento de click no botão "Enter" do teclado virtual
document.querySelector('.virtual-keyboard button[onclick="addCharacter(\'Enter\')"]').addEventListener('click', function() {
    const query = document.getElementById('search-input').value.trim();
    if (query) {
        searchContent(query);
    }
});

// Adiciona um evento de click nos ícones do teclado virtual e do microfone
document.querySelector('.keyboard-button').addEventListener('click', function(event) {
    event.preventDefault();
});

document.querySelector('.audio-button').addEventListener('click', function(event) {
    event.preventDefault();
});


document.getElementById('search-form').addEventListener('click', function(event) {
    if (event.target.classList.contains('keyboard-button') || event.target.classList.contains('audio-button')) {
        event.preventDefault();
    }
});


function clearSearch() {
    const searchInput = document.getElementById('search-input');
    searchInput.value = '';
    toggleClearButton();
    clearResults(); // Limpa os resultados
}

function searchContent(query) {
    fetch(`search.php?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            displayResults(data);
        })
        .catch(error => {
            console.error('Erro na busca:', error);
        });
}

function clearResults() {
    const resultsContainer = document.getElementById('search-results');
    resultsContainer.innerHTML = ''; // Limpa os resultados
}

function displayResults(results) {
    const resultsContainer = document.getElementById('search-results');
    resultsContainer.innerHTML = '';

    if (results.length === 0) {
        resultsContainer.innerHTML = '<p>Nenhum resultado encontrado.</p>';
        return;
    }

    results.forEach(result => {
        const div = document.createElement('div');
        div.className = 'result-item';
        div.innerHTML = `
            <div class="result-title">${result.titulo}</div>
            <div class="result-description">${result.descricao}</div>
            <div class="result-url"><a href="${result.url}" target="_blank">${result.url}</a></div>
            <div class="result-type">Tipo: ${result.tipo}</div>
        `;
        resultsContainer.appendChild(div);
    });
}

/*

///// TECLADO VIRTUAL \\\\\

*/

let shift = false;
let capsLock = false;

// Alterna o estado da tecla Shift
function toggleShift() {
    shift = !shift;
    updateShift();
}

// Atualiza a exibição das teclas conforme o estado da tecla Shift
function updateShift() {
    let buttons = document.querySelectorAll('#virtual-keyboard button');
    buttons.forEach(button => {
        if (shift) {
            button.textContent = button.textContent.toUpperCase();
        } else {
            button.textContent = button.textContent.toLowerCase();
        }
    });
}

// Alterna o estado da tecla Caps Lock
function toggleCapsLock() {
    capsLock = !capsLock;
    updateCapsLock();
}

// Atualiza a exibição das teclas conforme o estado da tecla Caps Lock
function updateCapsLock() {
    let buttons = document.querySelectorAll('#virtual-keyboard button');
    if (capsLock) {
        buttons.forEach(button => {
            button.textContent = button.textContent.toUpperCase();
        });
    } else {
        updateShift(); // Atualiza o Shift para o estado normal
    }
}

// Adiciona um caractere ao campo de entrada
function addCharacter(char) {
    let input = document.querySelector('.search-input');
    if (char === 'Enter') {
        input.value += '\n';
        autoResize(input);
    } else {
        if ((capsLock || shift) && char.match(/[a-z]/i)) {
            input.value += char.toUpperCase();
        } else {
            input.value += char.toLowerCase();
        }
        autoResize(input);
        toggleClearButton(); // Mostra o botão "x" quando algo é digitado
    }
    if (shift) {
        shift = false;
        updateShift();
    }
}

// Remove o caractere mais à direita do campo de entrada
function backspace() {
    let input = document.querySelector('.search-input');
    input.value = input.value.slice(0, -1);
    autoResize(input);
    toggleClearButton(); // Mostra o botão "x" quando algo é digitado
}

// Alterna a visibilidade do teclado virtual
function toggleKeyboard() {
    var keyboard = document.getElementById('virtual-keyboard');
    if (keyboard.style.display === 'none' || keyboard.style.display === '') {
        keyboard.style.display = 'block';
    } else {
        keyboard.style.display = 'none';
    }
}

// Redimensiona automaticamente a área de texto conforme o conteúdo
function autoResize(textarea) {
    textarea.style.height = "";
    textarea.style.height = Math.min(textarea.scrollHeight, 150) + "px";
}

// Mostra ou oculta o botão "x" conforme o conteúdo do campo de entrada
function toggleClearButton() {
    const input = document.querySelector('.search-input');
    const clearButton = document.querySelector('.clear-button');
    if (input.value.length > 0) {
        clearButton.style.display = 'block';
    } else {
        clearButton.style.display = 'none';
    }
}

// Limpa o campo de entrada ao clicar no botão "x"
function clearInput() {
    const input = document.querySelector('.search-input');
    input.value = '';
    toggleClearButton(); // Oculta o botão "x"
}

/*

///// AUDIO \\\\\

*/

function startAudio() {
    // Pergunta ao usuário se ele deseja iniciar a gravação de áudio
    const userConfirmed = confirm('Deseja iniciar o reconhecimento de voz?');
    
    if (userConfirmed) {
        // Verifica se a API de reconhecimento de voz está disponível
        if ('webkitSpeechRecognition' in window) {
            const recognition = new webkitSpeechRecognition(); // Cria uma nova instância de reconhecimento de voz
            recognition.continuous = false; // Define se o reconhecimento deve continuar em um loop
            recognition.interimResults = false; // Não exibe resultados parciais

            recognition.onstart = function() {
                console.log('Reconhecimento de voz iniciado');
            };

            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript; // Obtém a transcrição da fala
                document.querySelector('.search-input').value = transcript; // Preenche o campo de entrada com a transcrição
                autoResize(document.querySelector('.search-input')); // Redimensiona o textarea
                toggleClearButton(); // Mostra o botão "x"
            };

            recognition.onerror = function(event) {
                console.error('Erro no reconhecimento: ', event.error); // Exibe erros no console
            };

            recognition.onend = function() {
                console.log('Reconhecimento de voz finalizado');
            };

            recognition.start(); // Inicia o reconhecimento de voz
        } else {
            alert('A API de reconhecimento de voz não é suportada neste navegador.');
        }
    } else {
        console.log('Reconhecimento de voz cancelado pelo usuário.');
    }
}

// Realiza uma pesquisa com base no valor do campo de entrada
function search() {
    const input = document.querySelector('.search-input');
    searchContent(input.value);
}