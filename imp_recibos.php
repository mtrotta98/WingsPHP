<?php

require 'fpdf.php';

include 'conecta.php';

$id_cc = $_REQUEST["id"];
// Consulta
$sql = "SELECT CONCAT(a.nombre, ' ', a.apellido) AS apYnom, p.fecha, cc.cuota, cc.monto, r.id_recibo, a.dni, p.fecha_clase, p.cant_horas FROM cuenta_corriente cc LEFT JOIN pagos p ON (cc.id_cc = p.id_cc) LEFT JOIN alumnos a ON (cc.id_persona = a.id_personas) LEFT JOIN recibos r ON (cc.id_cc = r.id_cc) WHERE cc.id_cc = $id_cc";
$res_existe = $mysqli->query($sql);

if (!$res_existe) {
    echo $mysqli->error;
}
$row = $res_existe->fetch_array(MYSQLI_ASSOC);

$fecha_carga = date("d-m-Y",strtotime($row['fecha']));


$pdf = new fpdf();
$pdf->AliasNbPages();
$pdf->AddPage();


$pdf->setFillColor(232, 232, 232);
$pdf->setFont('Arial', 'B', 12);
$pdf->SetXY(100, 20);
$pdf->Cell(30, 6, 'R', 1, 0, 'C');
$pdf->Ln(30);
$pdf->setFillColor(232, 232, 232);
$pdf->setFont('Arial','' ,10);
$pdf->Cell(30, 6, 'Instituto WINGS', 0, 0, 'L', 0);
$pdf->Cell(150, 6, 'RECIBO NRO: ' . $row['id_recibo'], 0, 0, 'R', 0);
$pdf->ln(7);
$pdf->Cell(30, 6, 'Calle 8 1879, B1894GJK Villa Elisa, Provincia de Buenos Aires', 0, 0, 'L', 0);
$pdf->Cell(150, 6, 'FECHA: ' . $fecha_carga, 0, 0, 'R', 0);
$pdf->ln(7);
$pdf->Cell(30, 6, 'Telefono: 473-3694', 0, 0, 'L', 0);
$pdf->Ln(10);
$pdf->Cell(70, 6, 'APELLIDO Y NOMBRE: ' . $row['apYnom'], 0, 0, 'L', 0);
$pdf->ln(7);
$pdf->Cell(70, 6, 'DNI: ' . $row['dni'], 0, 0, 'L', 0);
$pdf->Ln(10);
$pdf->Cell(30, 6, 'CANTIDAD', 1, 0, 'L', 1);
$pdf->Cell(70, 6, 'DESCRIPCION', 1, 0, 'L', 1);
$pdf->Cell(40, 6, 'PRECIO UNITARIO', 1, 0, 'L', 1);
$pdf->Cell(40, 6, 'TOTAL', 1, 0, 'L', 1);
$pdf->Ln(10);
$pdf->Cell(30, 6, '1', 1, 0, 'L');
if($row["cuota"] == 0){
    $pdf->Cell(70, 6, 'Pago de Matricula', 1, 0, 'C');
}elseif($row["cuota"] != 0){
    if($row["cuota"] < 13){
        $pdf->Cell(70, 6, 'Pago de Cuota Nro: ' . $row["cuota"], 1, 0, 'C');
    }else{
        $pdf->Cell(70, 6, 'Pago de Horas(' . $row["cant_horas"] . ') del: ' . $row["fecha_clase"], 1, 0, 'C');
    }
}
$pdf->Cell(40, 6, $row['monto'], 1, 0, 'R', 0);
$pdf->Cell(40, 6, $row['monto'], 1, 0, 'R', 0);
$pdf->ln(10);
$pdf->Cell(30, 6, '', 0, 0, 'L', 0);
$pdf->Cell(70, 6, '', 0, 0, 'L', 0);
$pdf->Cell(40, 6, 'TOTAL', 1, 0, 'L', 1);
$pdf->Cell(40, 6, $row['monto'], 1, 0, 'R', 0);
$pdf->ln(90);
$pdf->Image('imagenes/firma.jpg',127,178,-300);
$pdf->Cell(165, 6, '_____________________', 0, 0, 'R', 0);
$pdf->Ln(7);
$pdf->Cell(150, 6, 'Firma: ', 0, 0, 'R', 0);
$pdf->ln(10);
$pdf->Image('imagenes/qr_img.png',150,220,-300);
$pdf->ln(20);
$pdf->Cell(40, 6, 'Los pagos deben realizarse del dia 1 al 10 de cada mes', 0, 0, 'L', 0);
$pdf->ln(7);
$pdf->Cell(40, 6, '*Documento no valido como factura', 0, 0, 'L', 0);

$pdf->Ln(10);

$pdf->setFont('Arial', '', 10);

$pdf->Output('I', 'Recibo de pago de ' . utf8_decode($row["apYnom"]) . '.pdf');
?>