<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    include 'conecta.php';
    $valor = $_REQUEST["valor"];
    $accion = $_REQUEST["accion"];

    
    switch ($valor) {
        /* ---------------------- Carga de alumnos ---------------------- */
        case 0:
   
            $apellido = strtoupper($_REQUEST["ape"]);
            $nombre = strtoupper($_REQUEST["nom"]);
            $dni = $_REQUEST["doc"];
            $email = $_REQUEST["email"];
            $domicilio = strtoupper($_REQUEST["dom"]);
            $fijo = $_REQUEST["fijo"];
            $cel = $_REQUEST["cel"];
            $fechaNacimiento = $_REQUEST["fecha"];
            $ingreso = $_REQUEST["ingreso"];
            $obs = strtoupper($_REQUEST["observaciones"]);

          
            //$fechaNacimiento = date('Y-m-d', strtotime($date));
            //$ingreso = date('Y-m-d', strtotime($_REQUEST['datemask1']));
            $activo = 1;
            $autorizacion = 1;

            /* ---------------------- Agregar alumnos ---------------------- */
            if ($accion == "cargar") {

                $sql = "SELECT EXISTS (SELECT * FROM alumnos WHERE dni=$dni)";
                $existe = $mysqli->query($sql);
                $row = $existe->fetch_array(MYSQLI_NUM);
                /* ---------------------- Alumno existente ---------------------- */
                if($row[0] == "1"){
                    die("Alumno ya ingresado");
                }else{
                    /* ---------------------- Alumno no existente ---------------------- */
                    $stmt = $mysqli->prepare('INSERT INTO alumnos (nombre, apellido, dni, email, domicilio, activo, fecha_nacimiento, ingreso, autorizacion_redes, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                    $stmt->bind_param('ssississis', $nombre, $apellido, $dni, $email, $domicilio, $activo, $fechaNacimiento, $ingreso, $autorizacion, $obs);
                    
                    if($stmt->execute()){
                        $id_alum = $mysqli->insert_id;

                        $stmt2 = $mysqli->prepare('INSERT INTO telefonos (numero_fijo, numero_celular, id_alumno) VALUES (?, ?, ?)');
                        $stmt2->bind_param('iii', $fijo, $cel, $id_alum);
                        $stmt2->execute();

                        $stmt3 = $mysqli->prepare('INSERT INTO tutor_alumnos (id_alumno, id_tutor) VALUES (?, ?)');
                        $stmt3->bind_param('ii', $id_alum, $id_tutor);
                        $stmt3->execute();

                        
                        $date = new DateTime($ingreso);
                        $now = new DateTime(date("Y") . "-12-30");
                        $cuotas = $now->diff($date)->format('%m');
                        $anio = (int)date("Y");
                        $monto = 0;
                        $pago = 0;
                        $desde = 12 - (int)$cuotas;

                        $cuota0 = 0;
                        $stmt5 = $mysqli->prepare('INSERT INTO cuenta_corriente (id_persona, anio, cuota, monto, pago, activo) VALUES (?, ?, ?, ?, ?, ?)');
                        $stmt5->bind_param('iiidii', $id_alum, $anio, $cuota0, $monto, $pago, $activo);
                        $stmt5->execute();

                        for ($i = $desde; $i <= 12; $i++) {
                            $stmt4 = $mysqli->prepare('INSERT INTO cuenta_corriente (id_persona, anio, cuota, monto, pago, activo) VALUES (?, ?, ?, ?, ?, ?)');
                            $stmt4->bind_param('iiidii', $id_alum, $anio, $i, $monto, $pago, $activo);
                            $stmt4->execute();
                        }
                    }
                }
            
            /* ---------------------- Actualizar alumnos ---------------------- */
            }elseif ($accion == "actualiza") {

                 $id = $_REQUEST["id"];
                 $sql = "UPDATE alumnos SET nombre = '$nombre', apellido = '$apellido', dni = $dni, email = '$email', domicilio = '$domicilio', fecha_nacimiento = '$fechaNacimiento', ingreso= '$ingreso', autorizacion_redes = $autorizacion, observaciones = '$obs' WHERE id_personas = $id";
                 if($mysqli->query($sql)){
                     $sql2 = "UPDATE telefonos SET numero_fijo = $fijo, numero_celular= $cel WHERE id_alumno = $id";
                     $mysqli->query($sql2);
                 }
            }    
            break;
        /* ---------------------- Carga de tutores ---------------------- */
        case 1:
            $activo = 1;
            $apellido = strtoupper($_REQUEST["ape"]);
            $nombre = strtoupper($_REQUEST["nom"]);
            $dni = $_REQUEST["doc"];
            $email = $_REQUEST["email"];
            $domicilio = strtoupper($_REQUEST["dom"]);
            $fijo = $_REQUEST["fijo"];
            $cel = $_REQUEST["cel"];
            /* ---------------------- Agregado de tutores ---------------------- */
            if ($accion == "cargar") {
                $docAl = $_REQUEST["docAl"];
                if($docAl){
                    $sql = "SELECT id_personas FROM alumnos WHERE dni=$docAl";
                    $existe = $mysqli->query($sql);
                    if($row = $existe->fetch_array(MYSQLI_ASSOC)){

                        $id = $row['id_personas'];
                        $sql3 = "SELECT EXISTS (SELECT * FROM tutor_alumnos WHERE id_alumno=$id)";
                        $existe2 = $mysqli->query($sql3);
                        $row3 = $existe2->fetch_array(MYSQLI_NUM);

                        if($row3[0] == '1'){
                            $sql4 = "SELECT * FROM tutor_alumnos WHERE id_alumno=$id";
                            $existe4 = $mysqli->query($sql4);
                            $row4 = $existe4->fetch_array(MYSQLI_ASSOC);
                            if ($row4['id_tutor'] == NULL){

                                $sql5 = "SELECT EXISTS (SELECT * FROM tutores WHERE dni=$dni)";
                                $existe5 = $mysqli->query($sql5);
                                $row5 = $existe5->fetch_array(MYSQLI_NUM);
                                if($row5[0] == '1'){

                                    $sql6 = "SELECT id_tutor FROM tutores WHERE dni=$dni";
                                    $existe6 = $mysqli->query($sql6);
                                    $row6 = $existe6->fetch_array(MYSQLI_ASSOC);

                                    $id_tutor = $row6['id_tutor'];

                                    $sql2 = "UPDATE tutor_alumnos SET id_tutor=$id_tutor WHERE id_alumno = $id";
                                    $mysqli->query($sql2);
                                    die("Datos guardados!!!!");
                                }else{
                                    $stmt = $mysqli->prepare('INSERT INTO tutores (dni, apellido, nombre, mail, domicilio, activo) VALUES (?, ?, ?, ?, ?, ?)');
                                    $stmt->bind_param('issssi', $dni, $apellido, $nombre, $email, $domicilio, $activo);

                                    if($stmt->execute()){
                                        $id_tutor = $mysqli->insert_id;
                
                                        $stmt2 = $mysqli->prepare('INSERT INTO telefonos (numero_fijo, numero_celular, id_tutor) VALUES (?, ?, ?)');
                                        $stmt2->bind_param('iii', $fijo, $cel, $id_tutor);
                                        $stmt2->execute();
                
                                        $sql2 = "UPDATE tutor_alumnos SET id_tutor=$id_tutor WHERE id_alumno = $id";
                                        $mysqli->query($sql2);
                                        die("Datos guardados!!!!");
                                    }
                                }

                            }else{
                                /* ---------------------- El alumno ya tiene tutor cargado ---------------------- */
                                die("el alumno ya tiene tutor");    
                            }
                        }
                    }else{
                        /* ---------------------- Alumno inexistente ---------------------- */
                        die("el alumno no existe");
                    }
                } else {
                    /* ---------------------- No se cargo el dni de alumno ---------------------- */
                    die("No ingreso datos");
                }
      
            /* ---------------------- Actualizar tutores ---------------------- */
            } elseif ($accion == "actualiza"){
                $id = $_REQUEST["id"];

                $sql = "UPDATE tutores SET dni = $dni, apellido='$apellido', nombre='$nombre', mail='$email', domicilio='$domicilio' WHERE id_tutor=$id";
                if($mysqli->query($sql)){
                    $sql3 = "UPDATE telefonos SET numero_fijo=$fijo, numero_celular=$cel WHERE id_tutor=$id";
                    $mysqli->query($sql3);
                }
                
            }
            break;
        /* ---------------------- Eliminar alumnos de forma logica ---------------------- */
        case 2:
            $id = $_REQUEST['id'];
            $anio = date("Y");
            /* ---------------------- Consulta sobre eliminacion ---------------------- */
            if($accion == "consulta"){
                
                $sql = "SELECT nombre,apellido FROM alumnos WHERE id_personas=$id";
                $res_existe = $mysqli->query($sql);
                $row = $res_existe->fetch_array(MYSQLI_ASSOC);
                die("Seguro que desea eliminar al alumno ".$row['nombre']. " ".$row['apellido']);
            /* ---------------------- Eliminacion de alumno ---------------------- */
            }elseif($accion == "eliminar"){
                
                $sql = "UPDATE alumnos SET activo = 0 WHERE id_personas = $id";
                $mysqli->query($sql);  

                $sql2 = "UPDATE cuenta_corriente SET activo=0 WHERE id_persona=$id and pago=0 and anio=$anio";
                $mysqli->query($sql2);
            }
            break;
        /* ---------------------- Eliminar tutor de forma logica ---------------------- */
        case 3:
            $id = $_REQUEST['id'];
            /* ---------------------- Consulta sobre eliminacion ---------------------- */
            if($accion == "consulta"){
                
                $sql = "SELECT nombre,apellido FROM tutores WHERE id_tutor=$id";
                $res_existe = $mysqli->query($sql);
                $row = $res_existe->fetch_array(MYSQLI_ASSOC);
                die("Seguro que desea eliminar al tutor ".$row['nombre']. " ".$row['apellido']);
            /* ---------------------- Eliminacion de tutor ---------------------- */
            }elseif($accion == "eliminar"){
                
                $sql = "UPDATE tutores SET activo = 0 WHERE id_tutor = $id";
                $mysqli->query($sql);  
            }
            break;
        /* ---------------------- Carga de docentes ---------------------- */
        case 4:
            $apellido = strtoupper($_REQUEST["ape"]);
            $nombre = strtoupper($_REQUEST["nom"]);
            $dni = $_REQUEST["doc"];
            $email = $_REQUEST["email"];
            $fijo = $_REQUEST["fijo"];
            $cel = $_REQUEST["cel"];
            $activo = 1;
            /* ---------------------- Agregado de docentes ---------------------- */
            if ($accion == "cargar"){
                $stmt = $mysqli->prepare('INSERT INTO docentes (dni, apellido, nombre, email, activo) VALUES (?, ?, ?, ?, ?)');
                $stmt->bind_param('isssi', $dni, $apellido, $nombre, $email, $activo);
                if ($stmt->execute()){
                    $id_docente = $mysqli->insert_id;

                    $stmt2 = $mysqli->prepare('INSERT INTO telefonos (numero_fijo, numero_celular, id_docente) VALUES (?, ?, ?)');
                    $stmt2->bind_param('iii', $fijo, $cel, $id_docente);
                    $stmt2->execute();
                }
            /* ---------------------- Actualizar docente ---------------------- */
            }elseif($accion == "actualiza"){
                $id = $_REQUEST["id"];
                $sql = "UPDATE docentes SET dni = $dni, apellido='$apellido', nombre='$nombre', email='$email' WHERE id_docente=$id";

                if($mysqli->query($sql)){
                    $sql2 = "UPDATE telefonos SET numero_fijo = $fijo, numero_celular = $cel WHERE id_docente=$id";
                    $mysqli->query($sql2);
                }
            }
            break;
        /* ---------------------- Eliminacion de docentes de forma logica ---------------------- */
        case 5:
            $id = $_REQUEST['id'];
            /* ---------------------- Consulta de eliminacion ---------------------- */
            if($accion == "consulta"){

                $sql = "SELECT nombre,apellido FROM docentes WHERE id_docente=$id";
                $res_existe = $mysqli->query($sql);
                $row = $res_existe->fetch_array(MYSQLI_ASSOC);
                die("Seguro que desea eliminar al docente ".$row['nombre']. " ".$row['apellido']);
            /* ---------------------- Eliminacion de docente ---------------------- */
            }elseif($accion == "eliminar"){
        
                $sql = "UPDATE docentes SET activo = 0 WHERE id_docente = $id";
                $mysqli->query($sql);  
            }
            break;
        /* ---------------------- Carga de cursos ---------------------- */
        case 6:
            $nombre = strtoupper($_REQUEST['nom']);
            $dia_inicio = $_REQUEST['diaIn'];
            $dia_fin = $_REQUEST['diaF'];
            $hora_In = $_REQUEST['horaIn'];
            $hora_fin = $_REQUEST['horaFin'];
            $desc = $_REQUEST['descripcion'];
            $activo = 1;
            /* ---------------------- Agregado de cursos ---------------------- */
            if ($accion == "cargar"){
                $stmt = $mysqli->prepare('INSERT INTO cursos (nombre_curso, descripcion, diaD, diaH, activo, horaIn, horaFin) VALUES (?, ?, ?, ?, ?, ?, ?)');
                $stmt->bind_param('ssssiss', $nombre, $desc, $dia_inicio, $dia_fin, $activo, $hora_In, $hora_fin);
                $stmt->execute();
            /* ---------------------- Actualizar cursos ---------------------- */
            }elseif ($accion == "actualiza"){
                $id = $_REQUEST["id"];
                $sql = "UPDATE cursos SET nombre_curso='$nombre', descripcion='$desc', diaD='$dia_inicio', diaH='$dia_fin', horaIn='$hora_In', horaFin='$hora_fin' WHERE id_curso=$id";
                if($mysqli->query($sql)){
                    die("datos actualizados");
                }else{
                    die($mysqli->error);
                }
            }
            
            break;
        /* ---------------------- Borrado de cursos de forma logica ---------------------- */
        case 7:
            $id = $_REQUEST['id'];
            /* ---------------------- Consulta sobre eliminacion ---------------------- */
            if($accion == "consulta"){

                $sql = "SELECT nombre_curso FROM cursos WHERE id_curso=$id";
                $res_existe = $mysqli->query($sql);
                $row = $res_existe->fetch_array(MYSQLI_ASSOC);
                die("Seguro que desea eliminar el curso ".$row['nombre_curso']);
            /* ---------------------- Eliminacion de curso ---------------------- */
            }elseif($accion == "eliminar"){
        
                $sql = "UPDATE cursos SET activo = 0 WHERE id_curso = $id";
                $mysqli->query($sql);  
            }
            break;
        /* ---------------------- Carga de libros ---------------------- */
        case 8:
            $nombre = strtoupper($_REQUEST["nom"]);
            $autor = strtoupper($_REQUEST["autor"]);
            $editor = strtoupper($_REQUEST["editor"]);
            $acivo = 1;
            /* ---------------------- Agregado de libros ---------------------- */
            if ($accion == "cargar"){
                $stmt = $mysqli->prepare('INSERT INTO libros (nombre, autor, editora, activo) VALUES (?, ?, ?, ?)');
                $stmt->bind_param('sssi', $nombre, $autor, $editor, $acivo);
                $stmt->execute();
            /* ---------------------- Actualizar libros ---------------------- */
            }elseif($accion == "actualiza"){
                $id = $_REQUEST["id"];
                $sql = "UPDATE libros SET nombre='$nombre', autor='$autor', editora='$editor' WHERE id_libro=$id";
                $mysqli->query($sql);
            }
            break;
        /* ---------------------- Borrado de libros de forma logica ---------------------- */
        case 9:
            $id = $_REQUEST['id'];
            /* ---------------------- Consulta sobre eliminacion ---------------------- */
            if($accion == "consulta"){

                $sql = "SELECT nombre FROM libros WHERE id_libro=$id";
                $res_existe = $mysqli->query($sql);
                $row = $res_existe->fetch_array(MYSQLI_ASSOC);
                die("Seguro que desea eliminar el libro ".$row['nombre']);
            /* ---------------------- Borrado de libro ---------------------- */
            }elseif($accion == "eliminar"){
        
                $sql = "UPDATE libros SET activo = 0 WHERE id_libro = $id";
                $mysqli->query($sql);  
            }
            break;
        /* ---------------------- Agregado de alumnos a cursos ---------------------- */
        case 10:
            $curso = strtoupper($_REQUEST['curso']);
            $prof = $_REQUEST['prof'];
            $libro = $_REQUEST['libro'];
            $id = $_REQUEST["id"];

            if($accion == 'asignar'){

                $sql = "SELECT EXISTS (SELECT * FROM curso_docente_alumnos WHERE id_alumno=$id and id_curso=$curso)";
                $existe = $mysqli->query($sql);
                $row = $existe->fetch_array(MYSQLI_NUM);
                if($row[0] == "1"){
                    die("Alumno existente en el curso"); 
                }else{
                    $stmt = $mysqli->prepare('INSERT INTO curso_docente_alumnos (id_docente, id_libro, id_alumno, id_curso) VALUES (?, ?, ?, ?)');
                    $stmt->bind_param('iiii', $prof, $libro, $id, $curso);
                    $stmt->execute();
                }
            }
            break;
        /* ---------------------- Carga de fichas de salud ---------------------- */
        case 11:

            $docAl = $_REQUEST['docAl'];
            $nomEm = $_REQUEST['nomEm'];
            $numEm = $_REQUEST['numEm'];
            $traslado = $_REQUEST['traslado'];
            $enfermedad = $_REQUEST['r1'];
            $tratamiento = $_REQUEST['r2'];
            $inter = $_REQUEST['r3'];
            $medicacion = $_REQUEST['r4'];
            $desc_enf = $enfermedad==1?$_REQUEST['desc_enf']:NULL;
            $desc_trat = $tratamiento==1?$_REQUEST['desc_trat']:NULL;
            $desc_inter = $inter==1?$_REQUEST['desc_inter']:NULL;
            $desc_medi = $medicacion==1?$_REQUEST['desc_medi']:NULL;
            $fecha = $_REQUEST['fecha'];
            $activo = 1;
            /* ---------------------- Agregado de fichas de salud ---------------------- */
            if($accion == "cargar"){
                
                if($docAl){
                    $sql = "SELECT id_personas FROM alumnos WHERE dni=$docAl";
                    $existe = $mysqli->query($sql);

                    if($row = $existe->fetch_array(MYSQLI_ASSOC)){
                        $id_al = $row['id_personas'];

                        $sql2 = "SELECT EXISTS (SELECT * FROM fichas_salud WHERE id_alumno=$id_al)";
                        $existe2 = $mysqli->query($sql2);
                        $row2 = $existe2->fetch_array(MYSQLI_NUM);

                        if($row2[0] == '1'){
                            $sql3 = "SELECT YEAR(fecha_carga) AS fechaCarga FROM fichas_salud WHERE id_alumno=$id_al";
                            $existe3 = $mysqli->query($sql3);
                            $row3 = $existe3->fetch_array(MYSQLI_ASSOC);
                            $fec = new DateTime($fecha);
                            $anio = $fec->format('Y');
                            if($row3['fechaCarga'] < $anio){
                                $stmt = $mysqli->prepare('INSERT INTO fichas_salud (traslado, nombre_emergencia, telefono_emergencia, medicacion, tratamiento, enfermedad, intervencion, id_alumno, descripcion_medicacion, descripcion_tratamiento, descripcion_enfermedad, descripcion_intervencion, fecha_carga, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                                $stmt->bind_param('ssiiiiiisssssi', $traslado, $nomEm, $numEm, $medicacion, $tratamiento, $enfermedad, $inter, $id_al, $desc_medi, $desc_trat, $desc_enf, $desc_inter, $fecha, $activo);
                                $stmt->execute();
                            } else{
                                die("El alumno ya tiene cargada una fecha del año actual");
                            }   
                        }else{
                            $stmt = $mysqli->prepare('INSERT INTO fichas_salud (traslado, nombre_emergencia, telefono_emergencia, medicacion, tratamiento, enfermedad, intervencion, id_alumno, descripcion_medicacion, descripcion_tratamiento, descripcion_enfermedad, descripcion_intervencion, fecha_carga, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                            $stmt->bind_param('ssiiiiiisssssi', $traslado, $nomEm, $numEm, $medicacion, $tratamiento, $enfermedad, $inter, $id_al, $desc_medi, $desc_trat, $desc_enf, $desc_inter, $fecha, $activo);
                            $stmt->execute();
                        }
                    }else{
                        die("El alumno ingresado no existe");
                    }
                }else{
                    die("No ingreso dni del alumnos");
                }
            /* ---------------------- Acutalizacion de fichas de salud ---------------------- */
            }elseif ($accion == "actualiza"){
                $sql = "SELECT id_personas FROM alumnos WHERE dni=$docAl";
                $existe = $mysqli->query($sql);
                $row = $existe->fetch_array(MYSQLI_ASSOC);
                $id_al = $row['id_personas'];

                $sql2 = "UPDATE fichas_salud SET traslado='$traslado', nombre_emergencia='$nomEm', telefono_emergencia='$numEm', medicacion=$medicacion, tratamiento=$tratamiento, enfermedad=$enfermedad, intervencion=$inter, descripcion_medicacion='$desc_medi', descripcion_tratamiento='$desc_trat', descripcion_enfermedad='$desc_enf', descripcion_intervencion='$desc_inter', fecha_carga='$fecha' WHERE id_alumno=$id_al";
                $mysqli->query($sql2);
            }    
            break;
        /* -------------------- Cargar pago de alumno -------------------- */
        case 12:
            $fecha_pago = $_REQUEST['fechaPago'];
            $id = $_REQUEST['id'];
            $monto = $_REQUEST['monto'];
            $tipo = $_REQUEST['tipo'];
            $medio = $_REQUEST['medio'];
            $anio = date("Y");

            if($accion == "cargar"){
                /* -------------------- Cargar pago de matricula -------------------- */
                if($tipo == 1){
                    $sql2 = "UPDATE cuenta_corriente SET monto=$monto, pago=1 WHERE cuota=0 and id_persona=$id and anio=$anio";
                    if($mysqli->query($sql2)){
                        $sql3 = "SELECT id_cc FROM cuenta_corriente WHERE cuota=0 and id_persona=$id and anio=$anio";
                        $existe2 = $mysqli->query($sql3);
                        $row2 = $existe2->fetch_array(MYSQLI_ASSOC);
                        $id_cuenta = $row2['id_cc'];

                        $stmt2 = $mysqli->prepare('INSERT INTO pagos (fecha, medio, id_alumno, id_cc) VALUES (?, ?, ?, ?)');
                        $stmt2->bind_param('siii', $fecha_pago, $medio, $id, $id_cuenta);
                        $stmt2->execute();
                        $activo = 1;
                        $pago = $mysqli->insert_id;

                        $sql4 = "SELECT (nro_recibo + 1) AS nro_recibo FROM recibos ORDER BY nro_recibo DESC LIMIT 1";
                        $existe3 = $mysqli->query($sql4);
                        $row3 = $existe3->fetch_array(MYSQLI_ASSOC);
                        $nro = $row3['nro_recibo'];

                
                        $stmt3 = $mysqli->prepare('INSERT INTO recibos (id_cc, id_alumno, nro_recibo, activo, id_pago) VALUES (?, ?, ?, ?, ?)');
                        $stmt3->bind_param('iiiii', $id_cuenta, $id, $nro, $activo, $pago);
                        $stmt3->execute();
                    }

                /* -------------------- Cargar pago de cuota -------------------- */
                }elseif($tipo == 2){    
                    $cuota = $_REQUEST['cuota'];
                    $sql2 = "UPDATE cuenta_corriente SET monto=$monto, pago=1 WHERE cuota=$cuota and id_persona=$id and anio=$anio";
                    if($mysqli->query($sql2)){

                        $sql3 = "SELECT id_cc FROM cuenta_corriente WHERE cuota=$cuota and id_persona=$id and anio=$anio";
                        $existe2 = $mysqli->query($sql3);
                        $row2 = $existe2->fetch_array(MYSQLI_ASSOC);
                        $id_cuenta = $row2['id_cc'];

                        $stmt2 = $mysqli->prepare('INSERT INTO pagos (fecha, medio, id_alumno, id_cc) VALUES (?, ?, ?, ?)');
                        $stmt2->bind_param('siii', $fecha_pago, $medio, $id, $id_cuenta);
                        $stmt2->execute();

                        $activo = 1;
                        $pago = $mysqli->insert_id;

                        $sql4 = "SELECT (nro_recibo + 1) AS nro_recibo FROM recibos ORDER BY nro_recibo DESC LIMIT 1";
                        $existe3 = $mysqli->query($sql4);
                        $row3 = $existe3->fetch_array(MYSQLI_ASSOC);
                        $nro = $row3['nro_recibo'];

                
                        $stmt3 = $mysqli->prepare('INSERT INTO recibos (id_cc, id_alumno, nro_recibo, activo, id_pago) VALUES (?, ?, ?, ?, ?)');
                        $stmt3->bind_param('iiiii', $id_cuenta, $id, $nro, $activo, $pago);
                        $stmt3->execute();
                    }
                /* -------------------- Cargar pago de horas -------------------- */
                }elseif($tipo == 3){
                    $fecha_clase = $_REQUEST['clase'];
                    $hora = $_REQUEST['hora'];
                    $val1 = 1;
                    $valMax = 999;

                    $stmt5 = $mysqli->prepare('INSERT INTO cuenta_corriente (id_persona, anio, cuota, monto, pago, activo) VALUES (?, ?, ?, ?, ?, ?)');
                    $stmt5->bind_param('iiidii', $id, $anio, $valMax, $monto, $val1, $val1);

                    if($stmt5->execute()){

                        $sql3 = "SELECT id_cc FROM cuenta_corriente ORDER BY id_cc DESC LIMIT 1";
                        $existe2 = $mysqli->query($sql3);
                        $row2 = $existe2->fetch_array(MYSQLI_ASSOC);
                        $id_cuenta = $row2['id_cc'];

                        $stmt2 = $mysqli->prepare('INSERT INTO pagos (fecha, medio, id_alumno, id_cc, fecha_clase, cant_horas) VALUES (?, ?, ?, ?, ?, ?)');
                        $stmt2->bind_param('siiisi', $fecha_pago, $medio, $id, $id_cuenta, $fecha_clase, $hora);
                        $stmt2->execute();

                        $activo = 1;
                        $pago = $mysqli->insert_id;

                        $sql4 = "SELECT (nro_recibo + 1) AS nro_recibo FROM recibos ORDER BY nro_recibo DESC LIMIT 1";
                        $existe3 = $mysqli->query($sql4);
                        $row3 = $existe3->fetch_array(MYSQLI_ASSOC);
                        $nro = $row3['nro_recibo'];

                
                        $stmt3 = $mysqli->prepare('INSERT INTO recibos (id_cc, id_alumno, nro_recibo, activo, id_pago) VALUES (?, ?, ?, ?, ?)');
                        $stmt3->bind_param('iiiii', $id_cuenta, $id, $nro, $activo, $pago);
                        $stmt3->execute();
                    }              
                }
            /* ---------------------- Actualizacion de pagos de alumnos ---------------------- */
            }elseif($accion == "actualiza"){
                /* ---------------------- Actualizacion de cuotas y matriculas ---------------------- */
                if($tipo != 3){
                    $id_pago = $_REQUEST['id3'];
                    $id_cc = $_REQUEST['id2'];

                    $sql2 = "UPDATE cuenta_corriente SET monto = $monto WHERE id_cc=$id_cc and id_persona=$id and anio=$anio";
                    $mysqli->query($sql2);

                    $sql3 = "UPDATE pagos SET medio=$medio, fecha='$fecha_pago' WHERE id_alumno=$id and id_pago=$id_pago and id_cc=$id_cc";
                    $mysqli->query($sql3);
                /* ---------------------- Actualizacion de pago de horas ---------------------- */
                }else{
                    $id_pago = $_REQUEST['id3'];
                    $id_cc = $_REQUEST['id2'];
                    $horas = $_REQUEST['cant_horas'];
                    $fecha_clase = $_REQUEST['fechaClase'];

                    $sql2 = "UPDATE cuenta_corriente SET monto = $monto WHERE id_cc=$id_cc and id_persona=$id and anio=$anio";
                    $mysqli->query($sql2);

                    $sql3 = "UPDATE pagos SET medio=$medio, fecha='$fecha_pago', fecha_clase='$fecha_clase', cant_horas=$horas WHERE id_alumno=$id and id_pago=$id_pago and id_cc=$id_cc";
                    $mysqli->query($sql3);
                }
            }
            break;
        /* ---------------------- Borrado de fichas de salud de forma logica ---------------------- */
        case 13:
            $id = $_REQUEST['id'];
            /* ---------------------- Consulta de eliminacion ---------------------- */
            if($accion == "consulta"){
                $sql = "SELECT nombre, apellido FROM alumnos a INNER JOIN fichas_salud fs ON (a.id_personas = fs.id_alumno) WHERE a.id_personas=$id";
                $res_existe = $mysqli->query($sql);
                $row = $res_existe->fetch_array(MYSQLI_ASSOC);
                die("Seguro que desea eliminar la ficha del alumno ".$row['nombre'] . " " . $row['apellido']);
            /* ---------------------- Eliminacion de ficha de salud ---------------------- */   
            }elseif($accion == "eliminar"){
        
                $sql = "UPDATE fichas_salud SET activo = 0 WHERE id_alumno = $id";
                $mysqli->query($sql);  
            }
            break;
        /* ---------------------- Carga de gastos ---------------------- */
        case 14:
            $fecha = $_REQUEST['fechaPago'];
            $medio = $_REQUEST['medio'];
            $concepto = $_REQUEST['concepto'];
            $monto = $_REQUEST['monto'];
            $activo = 1;
            /* ---------------------- Agregado de gastos ---------------------- */
            if($accion == "cargar"){
                $stmt = $mysqli->prepare('INSERT INTO gastos (fecha, medio, concepto, monto, activo) VALUES (?, ?, ?, ?, ?)');
                $stmt->bind_param('sisii', $fecha, $medio, $concepto, $monto, $activo);
                $stmt->execute();
            /* ---------------------- Actualizacion de gastos ---------------------- */
            } elseif($accion == "actualiza"){
                $id = $_REQUEST['id'];
                $sql = "UPDATE gastos SET fecha='$fecha', medio=$medio, concepto='$concepto', monto=$monto WHERE id_pago=$id";
                $mysqli->query($sql);
            }
            break;
        /* ---------------------- Borrado de pago de alumnos de forma fisica ---------------------- */
        case 15: 
            $id_al = $_REQUEST['id'];
            $id_cc = $_REQUEST['id2'];
            $id_pago = $_REQUEST['id3'];
            $anio = date("Y");
            /* ---------------------- Consulta sobre borrado ---------------------- */
            if($accion == "consulta"){
                $sql = "SELECT a.nombre, a.apellido, cc.cuota FROM alumnos a INNER JOIN cuenta_corriente cc ON (a.id_personas = cc.id_persona)
                        WHERE a.id_personas = $id_al and cc.id_cc=$id_cc and cc.anio=$anio";
                $res_existe = $mysqli->query($sql);
                $row = $res_existe->fetch_array(MYSQLI_ASSOC);
                die("Seguro que desea eliminar la cuota ".$row['cuota'] . " del alumno " . $row['apellido'] . " " . $row['nombre']);
            /* ---------------------- Eliminacion de pago ---------------------- */
            }elseif($accion == "eliminar"){
        
                $sql = "UPDATE cuenta_corriente SET monto=0, pago=0 WHERE id_cc=$id_cc and id_persona=$id_al and anio=$anio";
                $mysqli->query($sql);  

                $sql2 = "DELETE FROM pagos WHERE id_pago=$id_pago and id_alumno=$id_al and id_cc=$id_cc";
                $mysqli->query($sql2);
            }
            break;
        /* ---------------------- Borrado de gastos de forma logica ---------------------- */
        case 16: 
            $id = $_REQUEST['id'];
            /* ---------------------- Consulta de borrado ---------------------- */
            if($accion == "consulta"){
                $sql = "SELECT concepto FROM gastos WHERE id_pago=$id";
                $existe = $mysqli->query($sql);
                $row = $existe->fetch_array(MYSQLI_ASSOC);
                die("Seguro que desea gasta el gasto de " . $row['concepto']);
            /* ---------------------- Borrado de gasto ---------------------- */
            }elseif($accion == "eliminar"){
                $sql = "UPDATE gastos SET activo=0 WHERE id_pago=$id";
                $mysqli->query($sql);
            }
            break;
        /* ---------------------- Carga de usuarios ---------------------- */
        case 17: 
            $usuario = $_REQUEST['usuario'];
            $password = $_REQUEST['clave'];
            $Rpassword = $_REQUEST['Rclave'];
            $nivel = 1;
            
            if($accion == "cargar"){
                if($password == $Rpassword){
                    $sql = "SELECT EXISTS (SELECT * FROM usuarios WHERE usuario='$usuario')";
                    $existe = $mysqli->query($sql);
                    $row = $existe->fetch_array(MYSQLI_NUM);
                    if($row[0] == '0'){
                        $stmt = $mysqli->prepare('INSERT INTO usuarios (usuario, clave, nivel) VALUES (?, ?, ?)');
                        $hash = SHA1($password);
                        $stmt->bind_param('ssi', $usuario, $hash, $nivel);
                        $stmt->execute();
                    }
                }
            }
            break;
        /* ---------------------- Altas de alumnos/tutores/docentes/cursos/libros/fichas ---------------------- */
        case 18: 
            $id = $_REQUEST['id'];
            $anio = date("Y");
            if($accion == "cambiarAlumno"){
                $sql = "UPDATE alumnos SET activo = 1 WHERE id_personas=$id";
                $mysqli->query($sql);

                $date = new DateTime(date("Y") . "-" .  date("m") . "-" . date("d"));
                $now = new DateTime(date("Y") . "-12-30");
                $cuotas = $now->diff($date)->format('%m');
                $desde = 12 - (int)$cuotas;

                for ($i = $desde; $i <= 12; $i++) {
                    $sql2 = "UPDATE cuenta_corriente SET activo = 1 WHERE cuota=$i and id_persona=$id and anio=$anio";
                    $mysqli->query($sql2);
                }

            }elseif($accion == "cambiarTutor"){
                $sql = "UPDATE tutores SET activo = 1 WHERE id_tutor=$id";
                $mysqli->query($sql);
            }elseif($accion == "cambiarDocente"){
                $sql = "UPDATE docentes SET activo = 1 WHERE id_docente=$id";
                $mysqli->query($sql);
            }elseif($accion == "cambiarCurso"){
                $sql = "UPDATE cursos SET activo = 1 WHERE id_curso=$id";
                $mysqli->query($sql);
            }elseif($accion == "cambiarLibro"){
                $sql = "UPDATE libros SET activo = 1 WHERE id_libro=$id";
                $mysqli->query($sql);
            }elseif($accion == "cambiarFicha"){
                $sql = "UPDATE fichas_salud SET activo = 1 WHERE id_ficha=$id";
                $mysqli->query($sql);
            }
            break;

        /* --------------------Backup base de datos-------------------- */
        case 19:
            if($accion == 'backup'){
                exec('c:\WINDOWS\system32\cmd.exe /c START C:\xampp\htdocs\wings\backup.bat');
                header('index.php');
            }
            break;

        /* --------------------Carga de nuevas cuotas a los alumnos-------------------- */
        /*case 20:
            if($accion == 'cuotas'){
                $activo = 1;
                $sql3 = "SELECT * FROM alumnos";
                $existe2 = $mysqli->query($sql3);
                while ($row3 = $existe2->fetch_array(MYSQLI_ASSOC)){
                    $date = new DateTime("2022-02-01");
                    $now = new DateTime(date("Y") . "-12-30");
                    $cuotas = $now->diff($date)->format('%m');
                    $anio = (int)date("Y");
                    $monto = 0;
                    $pago = 0;
                    $desde = 12 - (int)$cuotas;
                    
                    $cuota0 = 0;
                    $stmt5 = $mysqli->prepare('INSERT INTO cuenta_corriente (id_persona, anio, cuota, monto, pago, activo) VALUES (?, ?, ?, ?, ?, ?)');
                    $stmt5->bind_param('iiidii', $row3['id_personas'], $anio, $cuota0, $monto, $pago, $activo);
                    $stmt5->execute();
        
                    for ($i = $desde; $i <= 12; $i++) {
                        $stmt4 = $mysqli->prepare('INSERT INTO cuenta_corriente (id_persona, anio, cuota, monto, pago, activo) VALUES (?, ?, ?, ?, ?, ?)');
                        $stmt4->bind_param('iiidii', $row3['id_personas'], $anio, $i, $monto, $pago, $activo);
                        $stmt4->execute();
                    }
                }
            }*/
    }
