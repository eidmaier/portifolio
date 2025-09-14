//script.js
function exportToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    html2canvas(document.body).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const imgProps= doc.getImageProperties(imgData);
        const pdfWidth = doc.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        
        doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        
        const cliente = document.getElementById('cliente').value;
        const filename = `relatorio_${cliente.replace(/\s+/g, '_')}_${Date.now()}.pdf`;
        
        doc.save(filename);
        
        // Salvar o PDF no servidor
        const formData = new FormData();
        formData.append('pdf', doc.output('blob'), filename);
        
        fetch('salvar_pdf.php', {
            method: 'POST',
            body: formData
        }).then(response => response.text())
          .then(result => console.log(result))
          .catch(error => console.error('Error:', error));
    });
}