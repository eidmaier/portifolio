<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- JS -->
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="col-recibo">
            <form id="receipt-form" method="post" action="save_receipts.php">
                <div class="col-left_right">
                    <div class="col-left">
                        <h2>CANHOTO</h2>
                        <div class="col col-id-valor">
                            <div class="col-id">
                                <label for="left_id">Nº:</label>
                                <input type="text" name="id" id="left_id" class="input-field" oninput="syncInputs('left_id', 'right_id')">
                            </div>
                            <div class="col-valor">
                                <label for="left_valor">VALOR:</label>
                                <input type="text" name="valor" id="left_valor" class="input-field" oninput="formatarMoeda(this); syncInputs('left_valor', 'right_valor'); atualizarImportancia();">
                            </div>
                        </div>

                        <div class="col-pagante">
                            <label for="left_pagante">RECEBI DE:</label>
                            <input type="text" name="pagante" id="left_pagante" class="input-field" oninput="syncInputs('left_pagante', 'right_pagante')">
                        </div>
                        <div class="col-doc">
                            <label for="left_doc">DOCUMENTO:</label>
                            <input type="text" name="documento" id="left_doc" class="input-field" oninput="syncInputs('left_doc', 'right_doc')">
                        </div>

                        <div class="col col-importancia">
                            <label for="left_importancia">A IMPORTÂNCIA DE:</label>
                            <input type="text" name="importancia" id="left_importancia" class="input-field" readonly>
                        </div>

                        <div class="col col-servicos">
                            <label for="left_servicos">REFERENTE A:</label>
                            <input type="text" name="servicos" id="left_servicos" class="input-field" oninput="syncInputs('left_servicos', 'right_servicos')">
                        </div>

                        <div class="col-docum">
                            <label for="left_docum">DOCUMENTO:</label>
                            <input type="text" name="docum" id="left_docum" class="input-field" oninput="syncInputs('left_docum', 'right_docum')">
                        </div>
                        <div class="col-local">
                            <label for="left_local">LOCAL:</label>
                            <input type="text" name="local" id="left_local" class="input-field" oninput="syncInputs('left_local', 'right_local')">
                        </div>

                        <div class="col-data">
                            <label for="left_data">DATA:</label>
                            <input type="text" name="data" id="left_data" class="input-field" oninput="syncInputs('left_data', 'right_data')">
                        </div>
                        <div class="col col-ass">
                            <label for="left_ass">ASS:</label>
                            <input type="text" name="ass" id="left_ass" class="input-field" oninput="syncInputs('left_ass', 'right_ass')">
                            <div class="form-upload">
                                <div>
                                    <img id="output-left" width="200" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-right">
                        <h2>RECIBO</h2>
                        <div class="col col-id-valor">
                            <div class="col-id">
                                <label for="right_id">Nº:</label>
                                <input type="text" id="right_id" class="input-field" oninput="syncInputs('right_id', 'left_id')">
                            </div>
                            <div class="reset">
                                <button type="button" onclick="nrecibo()" style="display: inline-block; margin-left: 0px; margin-top: 20px; vertical-align: middle; background-color: white; color: white; border-radius: 10%; border: none; width: 80px; height: 40px; font-size: 20px; line-height: 10px;">♾️</button>
                            </div>
                            
                            <div class="col-pesquisa">
                                <input type="text" id="search-input" class="input-field" placeholder="Pesquisar por nome">
                                <div class="lupa">
                                <button type="button" onclick="searchReceipts()">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                                </div>
                            </div>
                            
                            <div class="col-valor">
                                <label for="right_valor">VALOR:</label>
                                <input type="text" id="right_valor" class="input-field" oninput="formatarMoeda(this); syncInputs('right_valor', 'left_valor'); atualizarImportancia();">
                            </div>
                        </div>

                        <div class="col col-pagante-doc">
                            <div class="col-pagante">
                                <label for="right_pagante">RECEBI DE:</label>
                                <input type="text" id="right_pagante" class="input-field" oninput="syncInputs('right_pagante', 'left_pagante')">
                            </div>
                            <div class="col-doc">
                                <label for="right_doc">DOCUMENTO:</label>
                                <input type="text" id="right_doc" class="input-field" oninput="syncInputs('right_doc', 'left_doc')">
                            </div>
                        </div>

                        <div class="col col-importancia">
                            <label for="right_importancia">A IMPORTÂNCIA DE:</label>
                            <input type="text" id="right_importancia" class="input-field" readonly>
                        </div>

                        <div class="col col-servicos">
                            <label for="right_servicos">REFERENTE A:</label>
                            <input type="text" id="right_servicos" class="input-field" oninput="syncInputs('right_servicos', 'left_servicos')">
                        </div>

                        <div class="col col-docum-local-data">
                            <div class="col-docum">
                                <label for="right_docum">DOCUMENTO:</label>
                                <input type="text" id="right_docum" class="input-field" oninput="syncInputs('right_docum', 'left_docum')">
                            </div>
                            <div class="col-local">
                                <label for="right_local">LOCAL:</label>
                                <input type="text" id="right_local" class="input-field" oninput="syncInputs('right_local', 'left_local')">
                            </div>
                            <div class="col-data">
                                <label for="right_data">DATA:</label>
                                <input type="text" id="right_data" class="input-field" oninput="syncInputs('right_data', 'left_data')">
                            </div>
                        </div>

                        <div class="col col-ass">
                            <label for="right_ass">ASS:</label>
                            <input type="text" id="right_ass" class="input-field" oninput="syncInputs('right_ass', 'left_ass')">
                            <div class="form-upload">
                                <input id="file-upload-right" type="file" accept="image/*" onchange="loadFile(event, 'output-left', 'output-right')" style="display: none" />
                                <div>
                                    <img id="output-right" width="200" />
                                </div>
                                <div>
                                    <label for="file-upload-right" class="custom-file-upload" style="font-size: 15px">
                                        <i class="fa-solid fa-upload" style="font-size: 20px"></i>
                                    </label>
                                    <p>Assinatura</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Botões de ação -->
            <div>
                <button type="button" onclick="copyInputs()">Copiar</button>
                <button type="button" onclick="downloadPDF()">PDF</button>
                <button type="button" onclick="document.getElementById('receipt-form').submit();">Salvar</button>
                <select id="print-options">
                    <option value="both">Imprimir Canhoto e Recibo</option>
                    <option value="left">Imprimir Canhoto</option>
                    <option value="right">Imprimir Recibo</option>
                </select>
                <button type="button" id="imprimir" onclick="printSelection()">Imprimir</button>
            </div>

            <div id="mensagem" style="display: none;"></div>
        </div>
    </div>

    <script>
        function printSelection() {
            var printOption = document.getElementById('print-options').value;
            var contentToPrint;

            switch (printOption) {
                case 'left':
                    contentToPrint = document.querySelector('.col-left').outerHTML;
                    break;
                case 'right':
                    contentToPrint = document.querySelector('.col-right').outerHTML;
                    break;
                case 'both':
                default:
                    contentToPrint = document.querySelector('.col-left_right').outerHTML;
                    break;
            }

            var originalContent = document.body.innerHTML;
            document.body.innerHTML = contentToPrint;
            window.print();
            document.body.innerHTML = originalContent;
        }

        function submitUploadForm() {
            document.getElementById('upload-form').submit();
        }
    </script>

    <script src="script.js"></script>
</body>

</html>