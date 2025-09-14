<!-- COMMANDS.md -->

## COMANDOS IMPORTANTES

***Para automatizar e salvar arquivos em uma estrutura de árvore***
`cd config`

`python treecods_export.py`

*e fica salvo em config/estrutura.txt*

* Nota: No VSCode a extensão Tree Export faz esse trabalho também
___
***Exportar os código de todos os arquivos em um único arquivo txt (combined_code.txt)***

`node export_cods.js`

___


#### inserir Nome do Arquivo em Comentário na Primeira Linha do Código
```
venv\Scripts\activate
```
```
python add_header.py
```
*Para sair*
```
deactivate
```

* Nota
Em todos os arquivos você pode escoler mais exceções, para o que deve ou não aparecer na estrutura dos códigos `python treecods_export.py` . `node export_cods.js` . `add_header.py`

___

#### Para criar divs com comentários digite: `divc` 
* sairá assim:
```html
<div class=""><!-- INI class -->

</div><!-- FIM class -->
```
#### ou digite: `divci`
* sairá assim:
```html
<div class="" id=""><!-- INI class  - id  -->
      
</div><!-- FIM class  - id  -->
```