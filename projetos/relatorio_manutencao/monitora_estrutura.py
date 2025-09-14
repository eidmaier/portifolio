import os
from watchdog.observers import Observer
from watchdog.events import FileSystemEventHandler

class MyHandler(FileSystemEventHandler):
    def on_any_event(self, event):
        if event.is_directory:
            return
        elif event.event_type in ['created', 'deleted', 'modified']:
            if not event.src_path.endswith('estrutura.txt'):
                print(f'Arquivo alterado: {event.src_path}')
                atualizar_estrutura()


def atualizar_estrutura():
    # Aqui você pode implementar a lógica para atualizar o arquivo estrutura.txt
    with open('C:/laragon/www/base/config/estrutura.txt', 'w', encoding='utf-8') as f:
        # Escreve a estrutura atual do diretório no arquivo
        escrever_estrutura('', 'C:/laragon/www/base', f)

def escrever_estrutura(prefixo, diretorio, arquivo):
    # Adiciona o prefixo para a formatação da árvore
    arquivo.write(prefixo + os.path.basename(diretorio) + '\n')
    
    # Lista todos os arquivos e pastas no diretório atual
    arquivos = sorted(os.listdir(diretorio), key=lambda x: os.path.isdir(os.path.join(diretorio, x)))
    
    # Itera sobre os arquivos e pastas
    for item in arquivos:
        # Verifica se o item é um diretório
        if os.path.isdir(os.path.join(diretorio, item)):
            # Escreve a estrutura para o diretório com um recuo adicional
            escrever_estrutura(prefixo + '    ', os.path.join(diretorio, item), arquivo)
        else:
            # Escreve os arquivos dentro do diretório com recuo adicional
            arquivo.write(prefixo + '   └── ' + item + '\n')

                

if __name__ == "__main__":
    event_handler = MyHandler()
    observer = Observer()
    path_projeto = 'C:/laragon/www/base'  # Pasta do projeto
    observer.schedule(event_handler, path=path_projeto, recursive=True)
    observer.start()
    try:
        while True:
            pass
    except KeyboardInterrupt:
        observer.stop()
    observer.join()
