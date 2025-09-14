<?php
// salvar_pdf.php

ob_start();
error_reporting(0);
ini_set('display_errors', 0);

require_once 'db.php';
require_once 'tcpdf/tcpdf.php';

$cliente_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$cliente_id) {
    header("Location: relatorios.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->execute([$cliente_id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    header("Location: relatorios.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE cliente_id = ? ORDER BY id DESC");
$stmt->execute([$cliente_id]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_end_clean();

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Seu Nome');
$pdf->SetTitle('Relatório - ' . $cliente['nome']);
$pdf->SetSubject('Relatório do Cliente');
$pdf->SetKeywords('Relatório, Cliente, PDF');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetMargins(15, 15, 15);

// Adiciona a primeira página com as informações do cliente
$pdf->AddPage();

$pdf->SetFont('helvetica', '', 12);

$html = '<h1 style="font-size: 24pt; color: #2c3e50; text-align: center; margin-bottom: 20px;">Relatório de ' . htmlspecialchars($cliente['nome']) . '</h1>';
$html .= '<div style="font-size: 12pt; color: #333; margin-bottom: 15px;">';
$html .= '<p style="margin: 5px 0; color: #2c3e50;"><strong>Email:</strong> ' . htmlspecialchars($cliente['email']) . '</p>';
$html .= '<p style="margin: 5px 0; color: #2c3e50;"><strong>Telefone:</strong> ' . htmlspecialchars($cliente['telefone']) . '</p>';
$html .= '<p style="margin: 5px 0; color: #2c3e50;"><strong>Sobre:</strong> ' . htmlspecialchars($cliente['assunto']) . '</p>';
$html .= '<p style="margin: 5px 0; font-size: 9px"; color: #2c3e50;><strong>Prestador:</strong> ' . htmlspecialchars($cliente['prestador_servico']) . '</p>';
$html .= '<p style="margin: 5px 0; font-size: 9px; color: #2c3e50;"><strong></strong> ' . htmlspecialchars($cliente['profissao']) . '</p>';
$html .= '</div>';

$pdf->writeHTML($html, true, false, true, false, '');

// Adiciona uma nova página para os posts
if (!empty($posts)) {
    $pdf->AddPage(); // Inicia a segunda página para os posts

    $post_count = 0;
    foreach ($posts as $post) {
        if ($post_count % 2 == 0 && $post_count != 0) {
            $pdf->AddPage(); // Adiciona nova página após cada dois posts
        }

        $html = '<div style="margin-bottom: 20px; border: 1px solid #e0e0e0; padding: 10px; border-radius: 5px; background-color: #f9f9f9;">';
        $html .= '<h3 style="color: #3498db; margin-bottom: 10px;">' . htmlspecialchars($post['title']) . '</h3>';
        
        $html .= '<table cellpadding="5" cellspacing="0" style="width: 100%;">';
        $html .= '<tr>';
        $html .= '<td style="width: 50%; text-align: center; font-weight: bold; background-color: #e0e0e0;">Antes</td>';
        $html .= '<td style="width: 50%; text-align: center; font-weight: bold; background-color: #e0e0e0;">Depois</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="width: 50%;"><img src="' . realpath('uploads/' . $post['before_image']) . '" style="min-width: 100%; height: 200px; object-fit: cover;"/></td>';
        $html .= '<td style="width: 50%;"><img src="' . realpath('uploads/' . $post['after_image']) . '" style="min-width: 100%; height: 200px; object-fit: cover;"/></td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="width: 50%;">' . htmlspecialchars($post['before_description']) . '</td>';
        $html .= '<td style="width: 50%;">' . htmlspecialchars($post['after_description']) . '</td>';
        $html .= '</tr>';
        $html .= '</table>';
        $html .= '</div>';

        $pdf->writeHTML($html, true, false, true, false, '');

        $post_count++;
    }
}

$pdf->lastPage();

ob_end_clean();

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="relatorio_' . $cliente['nome'] . '.pdf"');

$pdf->Output('relatorio_' . $cliente['nome'] . '.pdf', 'I');
exit;
?>