<?php

require 'fpdf.php';

include 'conecta.php';

$id = $_REQUEST["id"];
// Consulta
$sql = "SELECT dni,CONCAT(apellido, ' ', nombre) as apy,email,domicilio, fecha_nacimiento,traslado,nombre_emergencia,telefono_emergencia,descripcion_medicacion,descripcion_tratamiento,descripcion_enfermedad,descripcion_intervencion,fecha_carga,
	if(medicacion=1,'SI','NO') as medicacion,
	if(tratamiento=1,'SI','NO') as tratamiento,
	if(enfermedad=1,'SI','NO') as enfermedad,
	if(intervencion=1,'SI','NO') as intervencion,
	if(autorizacion_redes=1,'SI','NO') as autorizacion_redes
FROM
	alumnos a
	INNER JOIN fichas_salud fs ON ( a.id_personas = fs.id_alumno ) 
WHERE
	a.id_personas =$id";
$res_existe = $mysqli->query($sql);

if (!$res_existe) {
    echo $mysqli->error;
}
$row = $res_existe->fetch_array(MYSQLI_ASSOC);

$fecha_carga = date("d-m-Y",strtotime($row['fecha_carga']));
$nacimiento = date("d-m-Y",strtotime($row['fecha_nacimiento']));

$pdf = new fpdf();
$pdf->AliasNbPages();
$pdf->AddPage();


$pdf->setFillColor(232, 232, 232);
$pdf->setFont('Arial', 'B', 12);
$pdf->Ln(7);
$pdf->Cell(70, 6, 'FICHA DE SALUD DE: ' . utf8_decode($row['apy']), 0, 0, 'L');
$pdf->Ln(7);
$pdf->Cell(70, 6, 'FECHA DE CARGA: ' . utf8_decode($fecha_carga), 0, 0, 'L');
$pdf->Ln(10);
$pdf->setFillColor(232, 232, 232);
$pdf->setFont('Arial','' ,10);
$pdf->Cell(70, 6, 'DNI', 1, 0, 'L', 1);
$pdf->Cell(70, 6, 'EMAIL', 1, 0, 'L', 1);
$pdf->Ln(7);
$pdf->Cell(70, 6, utf8_decode($row['dni']), 1, 0, 'L');
$pdf->Cell(70, 6, utf8_decode($row['email']), 1, 0, 'L');
$pdf->Ln(10);
$pdf->Cell(70, 6, 'DOMICILIO', 1, 0, 'L', 1);
$pdf->Cell(70, 6, 'FECHA DE NACIMIENTO', 1, 0, 'L', 1);
$pdf->Ln(7);
$pdf->Cell(70, 6, utf8_decode($row['domicilio']), 1, 0, 'L');
$pdf->Cell(70, 6, utf8_decode($nacimiento), 1, 0, 'L');
$pdf->Ln(10);
$pdf->Cell(70, 6, 'NOMBRE DE EMERGENCIA', 1, 0, 'L', 1);
$pdf->Cell(70, 6, 'TELEFONO DE EMERGENCIA', 1, 0, 'L', 1);
$pdf->Ln(7);
$pdf->Cell(70, 6, utf8_decode($row['nombre_emergencia']), 1, 0, 'L');
$pdf->Cell(70, 6, utf8_decode($row['telefono_emergencia']), 1, 0, 'C');
$pdf->Ln(10);
$pdf->Cell(70, 6, 'TRASLADO', 1, 0, 'L', 1);
$pdf->Cell(70, 6, utf8_decode($row['traslado']), 1, 0, 'L');

$pdf->Ln(10);

if ($row['medicacion'] == 'SI'){
	$pdf->Cell(70, 6, 'MEDICACION', 1, 0, 'L', 1);
	$pdf->Cell(70, 6, utf8_decode($row['descripcion_medicacion']), 1, 0, 'L');
	$pdf->Ln(10);
}

if ($row['tratamiento'] == 'SI'){
	$pdf->Cell(70, 6, 'TRATAMIENTO', 1, 0, 'L', 1);
	$pdf->Cell(70, 6, utf8_decode($row['descripcion_tratamiento']), 1, 0, 'L');
	$pdf->Ln(10);
}

if ($row['enfermedad'] == 'SI'){
	$pdf->Cell(70, 6, 'ENFERMEDAD', 1, 0, 'L', 1);
	$pdf->Cell(70, 6, utf8_decode($row['descripcion_enfermedad']), 1, 0, 'L');
	$pdf->Ln(10);
}

if ($row['intervencion'] == 'SI'){
	$pdf->Cell(70, 6, 'INTERVENCION', 1, 0, 'L', 1);
	$pdf->Cell(70, 6, utf8_decode($row['descripcion_intervencion']), 1, 0, 'L');
	$pdf->Ln(10);
}
$pdf->setFont('Arial', '', 10);

$pdf->Output('I', 'ficha de ' . utf8_decode($row["apy"]) . '.pdf');
?>