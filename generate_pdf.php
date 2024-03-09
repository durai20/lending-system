<?php




    require_once('tcpdf/tcpdf.php');
require 'php/show_history.php';

// Fetch data
$data = getPurchaseHistoryData();

// Generate PDF content
$content = '<h1>Purchase History Report</h1>';
$content .= '<table border="1"><tr><th>SL.</th><th>Student Id</th><th>Student Name</th><th>Product Name</th><th>Quantity</th><th>Product Price</th><th>Date</th></tr>';

foreach ($data as $row) {
    $content .= '<tr>';
    $content .= '<td>' . $row['no'] . '</td>';
    $content .= '<td>' . $row['id'] . '</td>';
    $content .= '<td>' . $row['name'] . '</td>';
    $content .= '<td>' . $row['product_name'] . '</td>';
    $content .= '<td>' . $row['product_quantity'] . '</td>';
    $content .= '<td>' . $row['product_price'] . '</td>';
    $content .= '<td>' . $row['date'] . '</td>';
    $content .= '</tr>';
}

$content .= '</table>';

// Generate PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->writeHTML($content);

// Output PDF to the browser with the name 'purchase_history_report.pdf'
$pdf->Output('purchase_history_report.pdf', 'D');
?>
