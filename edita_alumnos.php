<?php
session_start();

$id = $_REQUEST["id"];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Wings</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="desarrollo/plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bbootstrap 4 -->
        <link rel="stylesheet" href="desarrollo/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="desarrollo/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- JQVMap -->
        <link rel="stylesheet" href="desarrollo/plugins/jqvmap/jqvmap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="desarrollo/dist/css/adminlte.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="desarrollo/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="desarrollo/plugins/daterangepicker/daterangepicker.css">
        <!-- summernote -->
        <link rel="stylesheet" href="desarrollo/plugins/summernote/summernote-bs4.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <link rel="stylesheet" href="desarrollo/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            <!-- Navbar -->
            <?php
            include 'conecta.php';
            //include 'header.php';
            include 'menu.php';
            ?>

            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">Actualizar Alumno</h1>
                            </div>  
                        </div>
                    </div>
                </div>
                <section class="content">
                    <form action= "#" method= "post" name= "formulario_actualiza_alumno" id="formulario_actualiza_alumno" onsubmit="enviar_ajax(); return false">
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Datos del Alumno</h3>
                                </div>
                                <div class="card-body" style="display: block;">
                                    <?php
                                    $sql = "SELECT * FROM alumnos WHERE id_personas = $id order by apellido,nombre";
                                    $celu = null;
                                    $fijo = null;
                                    if ($res_existe = $mysqli->query($sql)) {
                                        $row = $res_existe->fetch_array(MYSQLI_ASSOC);
                                        //$date = str_replace('-', '/', $row['fechaNacimiento']);
                                        //$nacimiento = date('d-m-Y', strtotime($date));
                                        //$ing = date('m-d-Y', strtotime($row['ingreso']));
                                        
                                        if (!$row['fecha_nacimiento']){
                                            $fecha_nac="null";
                                        }else{
                                            $fecha_nac=$row['fecha_nacimiento'];
                                            $sql2 = "SELECT t.id_telefono 
                                            FROM alumnos a
                                            LEFT JOIN telefonos t ON (a.id_personas = t.id_alumno)
                                            WHERE a.id_personas = $id";
                                            if($existe = $mysqli->query($sql2)){
                                                $row2 = $existe->fetch_array(MYSQLI_ASSOC);

                                                if ($row2) {
                                                    $id_tel = $row2['id_telefono'];
        
                                                    $sql3 = "SELECT * FROM telefonos WHERE id_telefono = $id_tel";
                                                    if($existe2 = $mysqli->query($sql3)){
                                                        $row3 = $existe2->fetch_array(MYSQLI_ASSOC);
                                                        if ($row3) {
                                                            $fijo = $row3['numero_fijo'];
                                                            $celu = $row3['numero_celular'];
                                                        } 
                                                    }
                                                    
                                                } else {
                                                    $id_tel = 'null';
                                                }

                                            }
                                            
                                        }
                                        //$id_alum = $row['Id_personas'];
                                        
                                    
                                    } else {
                                        echo $mysqli->error;
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-2">
                                            <label>Nro Alumno</label>
                                            <input type="text" id="id" class="form-control" placeholder="Ids" name="id" readonly="readonly" value=<?php echo $id ?>>
                                        </div>
                                        <div class="col-10">

                                        </div>
                                        <div class="col-6">
                                            <label>Apellido/s</label>
                                            <input type="text" id="ape" class="form-control" placeholder="Apellidos" name="ape" value=<?php echo $row['apellido'] ?> required>
                                        </div>
                                        <div class="col-6">
                                            <label>Nombre/s</label>
                                            <input type="text" id="nom" class="form-control" placeholder="Nombres" name="nom" value=<?php echo $row['nombre'] ?> required>
                                        </div>
                                        <div class="col-6">
                                            <label>Documento</label>
                                            <input type="number" id="doc" class="form-control"  maxlength="8" placeholder="DNI" name="doc" value=<?php echo $row['dni'] ?> required>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Fecha de nacimiento:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" data-inputmask-alias="date" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" id="datemask" name="fecha" value=<?php echo $fecha_nac ?>>
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label>Domicilio</label>
                                            <input type="text" id="dom" class="form-control" placeholder="Domicilio" name="dom" value="<?php echo $row['domicilio'] ?>">
                                        </div>
                                        <div class="col-6">
                                            <label>Telefono de Linea</label>
                                            <input type="number" id="fijo" class="form-control" placeholder="Numero" name="fijo" value=<?php echo $fijo ?>>
                                        </div>
                                        <div class="col-6">
                                            <label>Telefono Celular</label>
                                            <input type="number" id="cel" class="form-control" placeholder="Numero" name="cel" value=<?php echo $celu ?>>
                                        </div>
                                        <div class="col-6">
                                            <label>Email</label>
                                            <input type="text" id="email" class="form-control" placeholder="Email" name="email" value=<?php echo $row['email'] ?>>
                                        </div>
                                        <div class="col-6">
                                            <label>Fecha de Ingreso</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control" data-inputmask-alias="date" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" id="datemask1" name="ingreso" value=<?php echo $row['ingreso'] ?>>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                                <label>Observaciones</label>
                                                <textarea id="observaciones" class="form-control" placeholder="Observaciones" name="observaciones" maxlength="255"><?php echo $row['observaciones'] ?></textarea>
                                        </div>
                                        <div class="col-12">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <input type="submit" class="btn btn-block btn-success" name="guardar" id="guarda" value="Guardar">
                                                    </div>
                                                    <div class="col-2">
                                                        <input type="button" class="btn btn-block btn-default" value="Cancelar" onclick="location.href = 'alumnos.php'">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                           
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
            <footer class="main-footer">
                <strong>Copyright &copy; 2021 <a href="https://localhost/facturacion">Instituto Wings</a>.</strong>

                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 1.0.0
                </div>
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- jQuery 3 -->
        <script src="desarrollo/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="desarrollo/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- Select2 -->
        <script src="desarrollo/bower_components/select2/dist/js/select2.full.min.js"></script>
        <!-- InputMask -->
        <script src="desarrollo/plugins/input-mask/jquery.inputmask.js"></script>
        <script src="desarrollo/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="desarrollo/plugins/input-mask/jquery.inputmask.extensions.js"></script>
        <!-- date-range-picker -->
        <script src="desarrollo/bower_components/moment/min/moment.min.js"></script>
        <script src="desarrollo/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script src="desarrollo/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <!-- bootstrap color picker -->
        <script src="desarrollo/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
        <!-- bootstrap time picker -->
        <script src="desarrollo/plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <!-- SlimScroll -->
        <script src="desarrollo/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- iCheck 1.0.1 -->
        <script src="desarrollo/plugins/iCheck/icheck.min.js"></script>
        <!-- FastClick -->
        <script src="desarrollo/bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="desarrollo/dist/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="desarrollo/dist/js/demo.js"></script>
        <script>
                                                            $(function () {
                                                                $('#datemask').inputmask('yyyy-mm-dd', {'placeholder': 'yyyy-mm-dd'})
                                                                $('#datemask1').inputmask('yyyy-mm-dd', {'placeholder': 'yyyy-mm-dd'})
                                                                $('[data-mask]').inputmask()
                                                                $('#reservation').daterangepicker()
                                                                $('#reservationtime').daterangepicker({
                                                                    timePicker: true,
                                                                    timePickerIncrement: 30,
                                                                    locale: {
                                                                        format: 'YYYY-MM-DD hh:mm A'
                                                                    }
                                                                })

                                                                //Colorpicker
                                                                $('.my-colorpicker1').colorpicker()
                                                                //color picker with addon
                                                                $('.my-colorpicker2').colorpicker()

                                                                $('.my-colorpicker2').on('colorpickerChange', function (event) {
                                                                    $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
                                                                });

                                                                $("input[data-bootstrap-switch]").each(function () {
                                                                    $(this).bootstrapSwitch('state', $(this).prop('checked'));
                                                                });

                                                            })
        </script>
        <script>

            function enviar_ajax() {
                $.ajax({
                    type: "POST",
                    url: "acciones.php?valor=0&accion=actualiza",
                    data: $("#formulario_actualiza_alumno").serialize(),
                    success: function(data) {
                        alert("Datos Guardados!!!");
                        alert(data);
                        window.location = "alumnos.php";
                    }
                });  
        }
        </script>
    </body>
</html>
