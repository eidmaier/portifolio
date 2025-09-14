const fs = require('fs');
const path = require('path');

const directoryPath = path.join(__dirname); // Diretório do qual exportar arquivos
const outputPath = path.join(__dirname, 'combined_code.txt'); // Arquivo de saída

fs.readdir(directoryPath, (err, files) => {
    if (err) {
        return console.error('Não foi possível listar os arquivos.', err);
    }

    let output = '';

    files.forEach(file => {
        if (fs.lstatSync(path.join(directoryPath, file)).isFile() && file !== 'export.js') {
            const content = fs.readFileSync(path.join(directoryPath, file), 'utf8');
            output += `// ${file}\n${content}\n\n`;
        }
    });

    fs.writeFileSync(outputPath, output, 'utf8');
    console.log('Código combinado foi exportado para', outputPath);
});
