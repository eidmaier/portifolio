## COMANDOS IMPORTANTES

# 1 # python monitora_estrutura.py

# 1 #
Para executar o script (monitora_estrutura.py) para automatizar e salvar em estrutura.txt, você pode abrir um terminal na pasta do projeto e usar o comando (sem cerquilha):
# python monitora_estrutura.py
A extensão Tree Exporter do VsCode também faz este trabalho é só clicar com o botão direito do mouse numa area vazia do Explorer do VsCode ou uma area específica que queira exportar e clicar em > Tree Exporter: Export
Exemplo:

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

Instalar o módulo watchdog: Verifique se o módulo watchdog está instalado em seu ambiente Python. Se não estiver, você pode instalá-lo usando o pip (embora, não é erro no VsCode isso tira linha amarela de código):
# pip install watchdog
Se o comando pip install watchdog não estiver instalando a biblioteca watchdog, pode haver algumas razões para isso. Aqui estão algumas coisas que você pode tentar:
# python --version
# pip --version
# pip install --upgrade pip
Se você já tem o pip instalado, mas está encontrando problemas para instalar pacotes, há algumas coisas que você pode tentar:
Atualize o pip: Embora você tenha o pip instalado, a versão pode estar desatualizada. Como você está usando o Python 3.12, que é uma versão mais recente, tente atualizar o pip para garantir que você esteja usando a versão mais recente. Você pode fazer isso com o seguinte comando:
# python -m pip install --upgrade pip
# python3.12 -m pip install watchdog
Limpe o cache do pip:
<!-- python3.12 -m pip cache purge
     python3.12 -m pip install watchdog -->


### node export.js
###### Comando para exportar código de todos os arquivos em um único arquivo txt (combined_code.txt)

