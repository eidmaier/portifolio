// Adicione os event listeners aos botões
document.getElementById('copiar').addEventListener('click', copiar);
document.getElementById('imprimir').addEventListener('click', imprimir);
document.getElementById('pdf').addEventListener('click', gerarPdf);

// Função de sincronização de entradas
function syncInputs(sourceId, targetId) {
  const sourceElement = document.getElementById(sourceId);
  const targetElement = document.getElementById(targetId);
  targetElement.value = sourceElement.value;
}

// Função para digitar número de recibo
function nrecibo() {
  let initialNumber = prompt("Digite o número inicial para o recibo:");
  if (initialNumber !== null && initialNumber !== "") {
    document.getElementById("right_id").value = initialNumber;
    document.getElementById("left_id").value = initialNumber;
    localStorage.setItem("ultimoNumero", initialNumber - 1);
  }
}

// Função para incrementar o número de recibo
function incrementarRecibo() {
  let ultimoNumero = parseInt(localStorage.getItem("ultimoNumero")) || 0;
  let novoNumero = ultimoNumero + 1;
  document.getElementById("right_id").value = novoNumero;
  document.getElementById("left_id").value = novoNumero;
  localStorage.setItem("ultimoNumero", novoNumero);
}

let ultimoNumero = localStorage.getItem("ultimoNumero");
if (!ultimoNumero) {
  ultimoNumero = 0;
}

let proximoNumero = parseInt(ultimoNumero) + 1;
document.getElementById("numero").value = proximoNumero;
localStorage.setItem("ultimoNumero", proximoNumero);

// Função para formatar o valor como moeda
function formatarMoeda(campo) {
  var valor = campo.value.replace(/\D/g, '');
  valor = (valor / 100).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
  campo.value = 'R$ ' + valor;
}

// Função para copiar o conteúdo do formulário
function copiar() {
  var formulario = document.querySelector('.container');
  var texto = "";
  var elements = formulario.querySelectorAll('.input-field');
  elements.forEach(element => {
    var label = formulario.querySelector('label[for="' + element.id + '"]').innerText;
    texto += label + " " + element.value + "\n";
  });
  navigator.clipboard.writeText(texto);
  var mensagem = document.getElementById("mensagem");
  mensagem.style.display = "block";
  mensagem.innerText = "Copiado :D";
  setTimeout(function () {
    mensagem.style.display = "none";
  }, 3000);
}

// Função para imprimir o formulário
function imprimir() {
  window.print();
}

// Função para gerar um arquivo PDF da página do formulário e fazer o download automático
function gerarPdf() {
  const element = document.body;
  const options = {
    margin: 0,
    filename: 'recibo.pdf',
    image: { type: 'jpeg', quality: 1 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
  };

  html2pdf().from(element).set(options).save().then(() => {
    var mensagem = document.getElementById("mensagem");
    mensagem.style.display = "block";
    mensagem.innerText = "PDF gerado com sucesso :D";
    setTimeout(function () {
      mensagem.style.display = "none";
    }, 3000);
  });
}

function loadFile(event, ...outputIds) {
  outputIds.forEach(outputId => {
      var output = document.getElementById(outputId);
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
          URL.revokeObjectURL(output.src) // free memory
      }
  });
}

document.getElementById('search-button').addEventListener('click', function() {
  var query = document.getElementById('search').value;
  // Adicione a lógica de pesquisa aqui
  console.log('Pesquisa por: ' + query);
});

function syncInputs(sourceId, targetId) {
const sourceElement = document.getElementById(sourceId);
const targetElement = document.getElementById(targetId);
targetElement.value = sourceElement.value;
}

function nrecibo() {
let initialNumber = prompt("Digite o número inicial para o recibo:");
if (initialNumber !== null && initialNumber !== "") {
  document.getElementById("right_id").value = initialNumber;
  document.getElementById("left_id").value = initialNumber;
  localStorage.setItem("ultimoNumero", initialNumber - 1);
}
}

function formatarMoeda(campo) {
var valor = campo.value.replace(/\D/g, '');
valor = (valor / 100).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
campo.value = 'R$ ' + valor;
}

function searchReceipts() {
var query = document.getElementById('search-input').value;
// Implementar a lógica de pesquisa aqui
console.log('Pesquisar por: ' + query);
}

function atualizarImportancia() {
var valor = document.getElementById('right_valor').value.replace('R$ ', '').replace(/\./g, '').replace(',', '.');
var valorExtenso = numeroPorExtenso(valor);
document.getElementById('left_importancia').value = valorExtenso;
document.getElementById('right_importancia').value = valorExtenso;
}



// Função para atualizar o campo importância com o valor por extenso
function atualizarImportancia() {
  var valor = document.getElementById('left_valor').value.replace('R$ ', '').replace(/\./g, '').replace(',', '.');
  var valorExtenso = numeroPorExtenso(valor);
  document.getElementById('left_importancia').value = valorExtenso;
  document.getElementById('right_importancia').value = valorExtenso;
}

function numeroPorExtenso(valor) {
  var valorNumber = parseFloat(valor);
  var extenso = "";
  
  if (isNaN(valorNumber)) return "";

  var unidades = ["", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove"];
  var dezenas = ["", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa"];
  var especiais = ["dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove"];
  var centenas = ["", "cento", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"];
  
  if (valorNumber === 0) return "zero reais";
  
  var parteInteira = Math.floor(valorNumber);
  var parteDecimal = Math.round((valorNumber - parteInteira) * 100);
  
  function converterParteInteira(valor) {
    var resultado = "";
    if (valor >= 1000000) {
      var milhoes = Math.floor(valor / 1000000);
      resultado += (milhoes > 1 ? converterParteInteira(milhoes) + " milhões" : "um milhão");
      valor %= 1000000;
      if (valor > 0) resultado += " ";
    }
    if (valor >= 1000) {
      var milhares = Math.floor(valor / 1000);
      resultado += converterParteInteira(milhares) + " mil ";
      valor %= 1000;
      if (valor > 0 && valor < 100) resultado += "e ";
    }
    if (valor >= 100) {
      if (valor === 100) {
        resultado += "cem";
      } else {
        resultado += centenas[Math.floor(valor / 100)] + " ";
      }
      valor %= 100;
      if (valor > 0) resultado += "e ";
    }
    if (valor >= 10 && valor < 20) {
      resultado += especiais[valor - 10];
    } else if (valor > 0) {
      if (valor >= 20) {
        resultado += dezenas[Math.floor(valor / 10)];
        if (valor % 10 !== 0) resultado += " e ";
      }
      if (valor % 10 !== 0) {
        resultado += unidades[valor % 10];
      }
    }
    return resultado.trim();
  }
  

  extenso = converterParteInteira(parteInteira);
  
  if (parteInteira === 1) {
    extenso += " real";
  } else if (parteInteira > 1) {
    extenso += " reais";
  }
  
  if (parteDecimal > 0) {
    if (parteInteira > 0) {
      extenso += " e ";
    }
    if (parteDecimal === 1) {
      extenso += "um centavo";
    } else {
      extenso += converterParteInteira(parteDecimal) + " centavos";
    }
  }

  return extenso.trim();
}

// Função para formatar o valor como moeda
function formatarMoeda(campo) {
  var valor = campo.value.replace(/\D/g, '');
  valor = (valor / 100).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
  campo.value = 'R$ ' + valor;
}

// Adicionando evento ao campo de valor para formatar e atualizar importância
document.getElementById('left_valor').addEventListener('input', function () {
  formatarMoeda(this);
  atualizarImportancia();
});

document.getElementById('right_valor').addEventListener('input', function () {
  var leftValor = document.getElementById('left_valor');
  leftValor.value = this.value;
  formatarMoeda(leftValor);
  atualizarImportancia();
});




