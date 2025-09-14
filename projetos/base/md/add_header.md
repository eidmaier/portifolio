<!-- add_header.md -->

# Adicionando Cabeçalhos aos Arquivos com Python

## 1. **Configuração do Ambiente Python**

1. **Verifique a instalação do Python**:
   No terminal do VSCode, execute:
   

```bash
   python --version
   ```

2. **Crie um ambiente virtual**:
   No terminal, no diretório do seu projeto, execute:
   

```bash
   python -m venv venv
   ```

3. **Ative o ambiente virtual**:
   - **Windows**:

     

```bash
     venv\Scripts\activate
     ```

   - **Mac/Linux**:

     

```bash
     source venv/bin/activate
     ```

     >> Execute: 

     

```
python add_header.py
```

   Isso criará uma pasta chamada `venv` no seu projeto.

4. **Para desativar o ambiente virtual**:
   Execute:
   

```bash
   deactivate
   ```

---

## 2. **Criar o Script Python para Inserir o Cabeçalho**

Crie um arquivo chamado `add_header.py` e adicione o seguinte código. Este script adiciona o nome do arquivo como cabeçalho em arquivos dentro de uma pasta específica (por exemplo, `src/` ).

```python
import os

# Função para definir o cabeçalho com base na extensão do arquivo
def get_header(file_name, extension):
    headers = {
        '.html': f"<!-- {file_name} -->\n\n",
        '.md': f"<!-- {file_name} -->\n\n",
        '.php': f"<!-- {file_name} -->\n\n",
        '.css': f"/* {file_name} */\n\n",
        '.js': f"/* {file_name} */\n\n",
        '.json': f"/* {file_name} */\n\n",
        '.py': f"# {file_name}\n\n",
        '.sql': f"-- {file_name}\n\n",
    }
    return headers.get(extension, f"/* {file_name} */\n\n")  # Padrão para outras extensões

# Função para adicionar o cabeçalho ao arquivo, caso ainda não esteja presente
def add_header_to_file(file_path):
    file_name = os.path.basename(file_path)
    extension = os.path.splitext(file_name)[1]
    header = get_header(file_name, extension)
    
    with open(file_path, 'r+') as file:
        content = file.read()
        if not content.startswith(header):
            file.seek(0, 0)
            file.write(header + content)

# Função para processar arquivos em um diretório específico
def process_files(directory, extensions=('.html', '.md', '.php', '.css', '.js', '.json', '.py', '.sql')):
    for root, _, files in os.walk(directory):
        for file in files:
            if file.endswith(extensions):
                file_path = os.path.join(root, file)
                add_header_to_file(file_path)
                print(f"Cabeçalho adicionado a {file_path}")

# Diretório da raiz e pastas específicas
if __name__ == "__main__":
    process_files('.')  # Processa arquivos na raiz
    specific_folders = ['src', 'app', 'config']  # Substitua pelos nomes das suas pastas
    for folder in specific_folders:
        process_files(folder)
```

---

## 3. **Como Usar o Script**

Para executar o script, utilize o seguinte comando no terminal:

```bash
python add_header.py
```

---

## 4. **Automatizar a Execução do Script**

Para automatizar a execução do script sempre que um novo arquivo for criado ou modificado:

1. No VSCode, vá em **Terminal > Configure Tasks**.
2. Selecione **Create tasks.json file from template**.
3. Escolha **Others** e edite o arquivo `tasks.json` para executar `add_header.py`:
   

```json
   {
     "version": "2.0.0",
     "tasks": [
       {
         "label": "Run add_header.py",
         "type": "shell",
         "command": "${workspaceFolder}/venv/Scripts/python",
         "args": ["${workspaceFolder}/add_header.py"],
         "group": {
           "kind": "build",
           "isDefault": true
         },
         "presentation": {
           "reveal": "always",
           "panel": "shared"
         },
         "problemMatcher": []
       }
     ]
   }
   ```

Agora, sempre que precisar adicionar cabeçalhos, você pode executar a tarefa **Add Header** diretamente no VSCode usando `Ctrl+Shift+B` . Isso aplicará automaticamente o cabeçalho com o nome do arquivo a todos os arquivos no diretório escolhido.
