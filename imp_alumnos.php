<?php
require 'fpdf.php';

include 'conecta.php';
// Consulta
$tipo = $_REQUEST['tipo'];

if($tipo == 'activo'){

	$sql = "SELECT
		a.apellido,
		a.nombre,
		a.id_personas,
		cu.nombre_curso
	FROM
		alumnos a
	LEFT JOIN curso_docente_alumnos c	on a.id_personas=c.id_alumno
	LEFT JOIN cursos cu on c.id_curso=cu.id_curso
	WHERE
		a.activo = 1  
	ORDER BY
		id_personas";
}else{
	$sql = "SELECT
		a.apellido,
		a.nombre,
		a.id_personas,
		cu.nombre_curso
	FROM
		alumnos a
	LEFT JOIN curso_docente_alumnos c	on a.id_personas=c.id_alumno
	LEFT JOIN cursos cu on c.id_curso=cu.id_curso
	WHERE
		a.activo = 0  
	ORDER BY
		id_personas";
}
//$res_existe = mysqli_query($conexion, $sql);
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
$pdf->Cell(50, 6, 'APELLIDO', 1, 0, 'C', 1);
$pdf->Cell(50, 6, 'CURSO', 1, 0, 'C', 1);
$pdf->Ln(5);

$pdf->setFont('Arial', '', 10);

while ($row = $res_existe->fetch_array(MYSQLI_ASSOC)) {
    $pdf->Cell(20, 6, $row['id_personas'], 1, 0, 'C');
    $pdf->Cell(50, 6, utf8_decode($row['apellido']), 1, 0, 'L');
    $pdf->Cell(50, 6, utf8_decode($row['nombre']), 1, 0, 'L');
    $pdf->Cell(50, 6, utf8_decode($row['nombre_curso']), 1, 0, 'L');
    $pdf->Ln(6);
}

$pdf->Output();
?>