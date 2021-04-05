<?php
$id_curso = $_REQUEST['curso'];
require 'fpdf.php';

include 'conecta.php';

$sql = "SELECT c.nombre_curso, l.nombre AS libro, CONCAT(d.nombre, ' ', d.apellido) AS docente FROM cursos c INNER JOIN curso_docente_alumnos cda ON (c.id_curso = cda.id_curso) INNER JOIN docentes d ON (cda.id_docente = d.id_docente) INNER JOIN libros l ON (cda.id_libro = l.id_libro) WHERE c.id_curso = $id_curso";
$existe = $mysqli->query($sql);
if (!$existe) {
    echo $mysqli->error;
}

$row = $existe->fetch_array(MYSQLI_ASSOC);

$pdf = new fpdf();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->setFillColor(232, 232, 232);
$pdf->setFont('Arial', 'B', 12);
$pdf->SetXY(100, 20);
$pdf->setFillColor(232, 232, 232);
$pdf->setFont('Arial','' ,15);
$pdf->Cell(30, 6, 'Listado de alumnos por curso', 0, 0, 'C', 0);
$pdf->setFont('Arial','' ,10);
$pdf->Ln(30);
$pdf->Cell(30, 6, 'Curso: ' . $row['nombre_curso'], 0, 0, 'L', 0);
$pdf->Ln(10);
$pdf->Cell(30, 6, 'Material: ' . $row['libro'], 0, 0, 'L', 0);
$pdf->Ln(10);
$pdf->Cell(30, 6, 'Docente: ' . $row['docente'], 0, 0, 'L', 0);
$pdf->Ln(20);
$pdf->Cell(62, 6, 'NOMBRE', 1, 0, 'C', 1);
$pdf->Cell(62, 6, 'APELLIDO', 1, 0, 'C', 1);
$pdf->Cell(62, 6, 'EDAD', 1, 0, 'C', 1);
$pdf->Ln(5);

$pdf->setFont('Arial', '', 10);

$sql2 = "SELECT a.nombre, a.apellido, a.fecha_nacimiento FROM cursos c INNER JOIN curso_docente_alumnos cda ON (c.id_curso = cda.id_curso) INNER JOIN alumnos a ON (cda.id_alumno = a.id_personas) WHERE c.id_curso = $id_curso";
$existe2 = $mysqli->query($sql2);
if (!$existe2) {
    echo $mysqli->error;
}

while ($row2 = $existe2->fetch_array(MYSQLI_ASSOC)) {
    $date_nacimiento = $row2['fecha_nacimiento'];
    $date = new DateTime($date_nacimiento);
    $now = new DateTime();
    $edad = $now->diff($date)->format('%Y');

    $pdf->Cell(62, 6, utf8_decode($row2['nombre']), 1, 0, 'L');
    $pdf->Cell(62, 6, utf8_decode($row2['apellido']), 1, 0, 'L');
    $pdf->Cell(62, 6, $edad, 1, 0, 'C');
    $pdf->Ln(6);
}


$pdf->Output();

?>

SELECT c.nombre_curso, a.nombre AS nomAL, a.apellido AS apAL, CONCAT(d.nombre, ' ', d.apellido) AS docente, l.nombre AS libro, a.fecha_nacimiento FROM cursos c INNER JOIN curso_docente_alumnos cda ON (c.id_curso = cda.id_curso) INNER JOIN alumnos a ON (cda.id_alumno = a.id_personas) INNER JOIN docentes d ON (cda.id_docente = d.id_docente) INNER JOIN libros l ON (cda.id_libro = l.id_libro) WHERE c.id_curso = $id_curso