<!-- md\treecods_export.md -->

## Exportar Códigos em TXT

### 1. Executar o script Python

Para executar o script `treecods_export.py` e salvar a estrutura em `estrutura.txt`, abra um terminal na pasta do projeto e utilize o comando:

```bash
python treecods_export.py
```

### 2. Usar a extensão Tree Exporter no VSCode

Você também pode usar a extensão **Tree Exporter** do VSCode, clicando com o botão direito em uma área vazia do Explorer VSCode ou em uma pasta específica e selecione: **Tree Exporter: Export**

### Estrutura de Exemplo

```plaintext
base
├── .gitignore
├── COMMANDS.md
├── config
│   └── estrutura.txt
├── css
│   └── styles.css
├── imgs
├── index.html
├── index.php
├── js
│   └── scripts.js
├── LICENSE.md
├── monitora_estrutura.py
├── pages
│   └── login.php
└── README.md
```

### 3. Instalar o módulo Watchdog

Certifique-se de que o módulo **watchdog** esteja instalado. Caso não esteja, instale-o usando:

```bash
pip install watchdog
```

### 4. Solução de Problemas com o Pip

Se você tiver problemas para instalar o watchdog, siga estas etapas:

1. Verifique a versão do Python:
   ```bash
   python --version
   ```

2. Verifique a versão do Pip:
   ```bash
   pip --version
   ```

3. Atualize o Pip:
   ```bash
   python -m pip install --upgrade pip
   ```

4. Instale o watchdog novamente:
   ```bash
   python -m pip install watchdog
   ```

5. Limpe o cache do Pip, se necessário:
   ```bash
   python -m pip cache purge
   python -m pip install watchdog
   ```

### Exportar código com Node.js

#### Comando para exportar código

**por fim, execute**

`python treecods_export.py`