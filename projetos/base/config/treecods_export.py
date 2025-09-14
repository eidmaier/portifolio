# config\treecods_export.py

import os
from watchdog.observers import Observer
from watchdog.events import FileSystemEventHandler

# Pastas a serem ignoradas (sem conteúdo)
IGNORAR_CONTEUDO_PASTAS = {'modules', 'venv'}

class MyHandler(FileSystemEventHandler):
    def on_any_event(self, event):
        print(f'Detectado evento: {event.event_type} em {event.src_path}')  # Diagnóstico
        if event.is_directory:
            return
        elif event.event_type in ['created', 'deleted', 'modified']:
            if not event.src_path.endswith('estrutura.txt'):
                print(f'Arquivo alterado: {event.src_path}')  # Diagnóstico
                atualizar_estrutura()

def atualizar_estrutura():
    try:
        path = 'C:/laragon/www/zona/base/config/estrutura.txt'
        print(f'Atualizando estrutura no caminho: {path}')  # Diagnóstico
        with open(path, 'w', encoding='utf-8') as f:
            escrever_estrutura('', 'C:/laragon/www/zona/base', f)
        print('Estrutura atualizada com sucesso.')  # Diagnóstico
    except Exception as e:
        print(f'Erro ao atualizar estrutura: {e}')  # Tratamento de erros

def escrever_estrutura(prefixo, diretorio, arquivo):
    arquivo.write(prefixo + os.path.basename(diretorio) + '\n')
    
    arquivos = sorted(os.listdir(diretorio), key=lambda x: os.path.isdir(os.path.join(diretorio, x)))
    
    for item in arquivos:
        caminho_item = os.path.join(diretorio, item)
        if os.path.isdir(caminho_item):
            if item in IGNORAR_CONTEUDO_PASTAS:
                arquivo.write(prefixo + '   └── ' + item + '\n')
            else:
                escrever_estrutura(prefixo + '    ', caminho_item, arquivo)
        else:
            if not any(pasta in caminho_item for pasta in IGNORAR_CONTEUDO_PASTAS):
                arquivo.write(prefixo + '   └── ' + item + '\n')

if __name__ == "__main__":
    path_projeto = 'C:/laragon/www/zona/base'
    if not os.path.exists(path_projeto):
        print(f'O caminho {path_projeto} não existe. Verifique e tente novamente.')
    else:
        event_handler = MyHandler()
        observer = Observer()
        observer.schedule(event_handler, path=path_projeto, recursive=True)
        
        print(f'Monitorando a pasta: {path_projeto}')  # Diagnóstico
        observer.start()
        
        try:
            while True:
                print("Executando...")  # Diagnóstico
        except KeyboardInterrupt:
            observer.stop()
        observer.join()
