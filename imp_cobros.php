<?php
require 'fpdf.php';
include 'conecta.php';
$rango = $_REQUEST['rango'];

$div = explode('-', $rango);
// Consulta



$sql = "SELECT CONCAT(a.nombre, ' ', a.apellido) AS nomYap, a.dni, cc.monto, cc.cuota, p.fecha, mp.medio_pago FROM alumnos a INNER JOIN cuenta_corriente cc ON (a.id_personas = cc.id_persona)
INNER JOIN pagos p ON (cc.id_cc = p.id_cc)
INNER JOIN medios_pago mp ON (mp.id_medio = p.medio) WHERE cc.pago = 1 AND (DAY(p.fecha) >= $div[0] and DAY(p.fecha) <= $div[3] and MONTH(p.fecha) >= $div[1] and MONTH(p.fecha) <= $div[4] and YEAR(p.fecha) >= $div[2] and YEAR(p.fecha) <= $div[5])";
$res_existe = $mysqli->query($sql);

$i = 0;
if (!$res_existe) {
    echo $mysqli->error;
}

$pdf = new fpdf();
$pdf->AliasNbPages();
$pdf->AddPage();


$pdf->setFillColor(232, 232, 232);
$pdf->setFont('Arial', 'B', 12);
$pdf->Cell(200, 6, 'LISTADO DE ALUMNOS', 0, 0, 'C');
$pdf->Ln(10);
$pdf->Cell(20, 6, 'ID', 1, 0, 'C', 1);
$pdf->Cell(50, 6, 'NOMBRE', 1, 0, 'C', 1);
$pdf->Cell(30, 6, 'MONTO', 1, 0, 'C', 1);
$pdf->Cell(20, 6, 'CUOTA', 1, 0, 'C', 1);
$pdf->Cell(50, 6, 'FECHA', 1, 0, 'C', 1);
$pdf->Ln(5);

$pdf->setFont('Arial', '', 10);
$i=0;
while ($row = $res_existe->fetch_array(MYSQLI_ASSOC)) {
    $fecha = date("d-m-Y",strtotime($row['fecha']));
    $i++;
    $pdf->Cell(20, 6, $i, 1, 0, 'C');
    $pdf->Cell(50, 6, utf8_decode($row['nomYap']), 1, 0, 'L');
    $pdf->Cell(30, 6, utf8_decode($row['monto']), 1, 0, 'R');
    $pdf->Cell(20, 6, utf8_decode($row['cuota']), 1, 0, 'C');
    $pdf->Cell(50, 6, utf8_decode($fecha), 1, 0, 'C');
    $pdf->Ln(6);
}

$pdf->Output();
?>