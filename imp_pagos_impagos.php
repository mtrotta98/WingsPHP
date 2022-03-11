<?php

    require 'fpdf.php';

    include 'conecta.php';

    $tipo = $_REQUEST['tipo'];
    $tipoP = $_REQUEST['tipoP'];
    $cuota = $_REQUEST['cuota'];

    if($tipoP == 1){
        if($tipo == 'pago'){
            $anio = (int)date('Y');
            $sql = "SELECT a.nombre, a.apellido, a.dni FROM alumnos a LEFT JOIN cuenta_corriente cc ON(a.id_personas = cc.id_persona) WHERE cc.pago=1 and cc.cuota=$cuota and cc.anio=$anio ORDER BY a.id_personas";
        }else{
            $mes = (int)date('n');
            $anio = (int)date('Y');
            $sql = "SELECT a.nombre, a.apellido, a.dni FROM alumnos a LEFT JOIN cuenta_corriente cc ON(a.id_personas = cc.id_persona) WHERE cc.pago=0 and cc.cuota=$cuota and cc.anio=$anio ORDER BY a.id_personas";
        }
    }else{
        if($tipo == 'pago'){
            $anio = (int)date('Y');
            $sql = "SELECT a.nombre, a.apellido, a.dni FROM alumnos a LEFT JOIN cuenta_corriente cc ON(a.id_personas = cc.id_persona) WHERE cc.pago=1 and cc.cuota=$cuota and cc.anio=$anio ORDER BY a.id_personas";
        }else{
            $anio = (int)date('Y');
            $sql = "SELECT a.nombre, a.apellido, a.dni FROM alumnos a LEFT JOIN cuenta_corriente cc ON(a.id_personas = cc.id_persona) WHERE cc.pago=0 and cc.cuota=$cuota and cc.anio=$anio ORDER BY a.id_personas";
        }
    }


    $res_existe = $mysqli->query($sql);

    if (!$res_existe) {
        echo $mysqli->error;
    }

    $pdf = new fpdf();
    $pdf->AliasNbPages();
    $pdf->AddPage();

    $pdf->setFillColor(232, 232, 232);
    $pdf->setFont('Arial', 'B', 12);
    $pdf->Cell(200, 6, 'LISTADO DE PAGOS DE ALUMNOS', 0, 0, 'C');
    $pdf->Ln(10);
    $pdf->Cell(64, 6, 'NOMBRE', 1, 0, 'C', 1);
    $pdf->Cell(64, 6, 'APELLIDO', 1, 0, 'C', 1);
    $pdf->Cell(64, 6, 'DNI', 1, 0, 'C', 1);
    $pdf->Ln(5);

    $pdf->setFont('Arial', '', 10);

    while ($row = $res_existe->fetch_array(MYSQLI_ASSOC)) {
        $pdf->Cell(64, 6, utf8_decode($row['apellido']), 1, 0, 'L');
        $pdf->Cell(64, 6, utf8_decode($row['nombre']), 1, 0, 'L');
        $pdf->Cell(64, 6, utf8_decode($row['dni']), 1, 0, 'L');
        $pdf->Ln(6);
    }

    $pdf->Output();

?>