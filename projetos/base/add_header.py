# add_header.py

import os

# Função para definir o cabeçalho com base na extensão do arquivo
def get_header(file_path, extension):
    relative_path = os.path.relpath(file_path, start='.')  # Caminho relativo ao diretório raiz
    headers = {
        '.html': f"<!-- {relative_path} -->\n\n",
        '.md': f"<!-- {relative_path} -->\n\n",
        '.php': f"<!-- {relative_path} -->\n\n",
        '.css': f"/* {relative_path} */\n\n",
        '.js': f"/* {relative_path} */\n\n",
        '.ts': f"/* {relative_path} */\n\n",
        '.json': f"/* {relative_path} */\n\n",
        '.py': f"# {relative_path}\n\n",
        '.sql': f"-- {relative_path} -->\n\n",
    }
    return headers.get(extension, f"/* {relative_path} */\n\n")  # Padrão para outras extensões

# Função para adicionar o cabeçalho ao arquivo, caso ainda não esteja presente
def add_header_to_file(file_path):
    extension = os.path.splitext(file_path)[1]
    header = get_header(file_path, extension)
    
    with open(file_path, 'r+', encoding='utf-8') as file:
        content = file.read()
        if not content.startswith(header):
            file.seek(0, 0)
            file.write(header + content)

# Função para processar arquivos em um diretório específico, ignorando pastas específicas
def process_files(directory, ignore_folders=[], specific_ignore_paths=[], extensions=('.html', '.md', '.php', '.css', '.js', '.ts', '.json', '.py', '.sql')):
    for root, dirs, files in os.walk(directory):
        # Remove pastas ignoradas do processamento
        dirs[:] = [d for d in dirs if d not in ignore_folders]

        # Verifica cada arquivo dentro do diretório atual
        for file in files:
            file_path = os.path.join(root, file)
            # Ignora arquivos dentro de caminhos específicos
            if any(ignored_path in file_path for ignored_path in specific_ignore_paths):
                continue
            # Processa apenas arquivos com extensões especificadas
            if file.endswith(extensions):
                add_header_to_file(file_path)
                print(f"Header added to {file_path}")

# Diretório da raiz e das pastas específicas
if __name__ == "__main__":
    # Pastas para ignorar genericamente
    ignore_folders = ['modules', 'venv', 'Scripts', 'Lib']  # Substitua com as pastas que deseja ignorar
    
    # Caminhos específicos para ignorar
    specific_ignore_paths = [
        os.path.join('src', 'componentes', 'dispensados'),  # Caminho específico a ser ignorado
    ]
    
    # Processa arquivos na raiz
    process_files('.', ignore_folders=ignore_folders, specific_ignore_paths=specific_ignore_paths, extensions=('.html', '.md', '.php', '.css', '.js', '.ts', '.json', '.py', '.sql'))

    # Processa arquivos em pastas específicas
    specific_folders = ['src', 'app', 'config']  # Substitua com as pastas desejadas
    for folder in specific_folders:
        if os.path.exists(folder):
            process_files(folder, ignore_folders=ignore_folders, specific_ignore_paths=specific_ignore_paths)
