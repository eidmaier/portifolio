/* export_cods.js */

const fs = require('fs');
const path = require('path');

const directoryPath = path.join(__dirname);
const outputPath = path.join(__dirname, 'combined_code.txt');

const EXCLUSOES = [
    'modules',
    'venv',
    '.git',
    'README.md',
    'COMMANDS.md',
    'LICENSE.md',
    'add_header.md',
    'add_header.py',
    'monitora_estrutura.py',
    '.htaccess',
    '.gitignore',
];

function readFilesRecursively(dir, output = '') {
    const files = fs.readdirSync(dir);

    for (const file of files) {
        const filePath = path.join(dir, file);
        
        // Ignora arquivos e pastas conforme as exclusões definidas
        if (EXCLUSOES.includes(file) || file === 'export.js' || file.startsWith('.')) {
            continue;
        }

        const stat = fs.statSync(filePath);

        if (stat.isDirectory()) {
            // Se for um diretório, chama recursivamente
            output = readFilesRecursively(filePath, output);
        } else {
            // Se for um arquivo, adiciona seu conteúdo
            const relativePath = path.relative(__dirname, filePath);
            const content = fs.readFileSync(filePath, 'utf8');
            output += `// ${relativePath}\n${content}\n\n`;
        }
    }

    return output;
}

try {
    const output = readFilesRecursively(directoryPath);
    fs.writeFileSync(outputPath, output, 'utf8');
    console.log('Código combinado foi exportado para', outputPath);
} catch (err) {
    console.error('Erro ao processar arquivos:', err);
}