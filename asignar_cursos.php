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
                            <h1 class="m-0 text-dark">Asignar Curso</h1>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <form action="#" method="post" name="formulario_asigna_curso" id="formulario_asigna_curso" onsubmit="enviar_ajax(); return false">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Datos del Curso</h3>
                            </div>
                            <?php 
                                $sql = "SELECT id_personas, CONCAT(nombre, ' ', apellido) as nombreYapellido FROM alumnos WHERE id_personas = $id";
                                $existe = $mysqli->query($sql);
                                $row = $existe->fetch_array(MYSQLI_ASSOC);

                            ?>
                            <div class="card-body" style="display: block;">
                                <div class="row">
                                    <div class="col-3">
                                        <label>Nro Alumno</label>
                                        <input type="text" id="id" class="form-control" placeholder="id" name="id" readonly="readonly" value= '<?php echo $row["id_personas"] ?>'>
                                    </div>
                                    <div class="col-3">
                                        <label>Nombre/s del Alumno</label>
                                        <input type="text" id="nom" class="form-control" placeholder="Nombres" name="nom" readonly="readonly" value= '<?php echo $row["nombreYapellido"] ?>'>
                                    </div>
                                    <div class="col-6">

                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Elejir Curso</label>
                                            <select class="form-control" id="curso" name="curso" required>
                                            <option selected="selected" value="">-- SELECCIONE UN CURSO --</option>
                                                <?php
                                                    $sql2 = "SELECT nombre_curso, id_curso FROM cursos WHERE activo=1 ORDER BY nombre_curso";
                                                    $existe2 = $mysqli->query($sql2);
                                                    var_dump($existe2);
                                                    while ($row2 = $existe2->fetch_array(MYSQLI_ASSOC)){
                                                        ?>
                                                        <option value=<?php echo $row2['id_curso'] ?>><?php echo $row2['nombre_curso'] ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Elejir Profesor</label>
                                            <select class="form-control" id="prof" name="prof" required>
                                            <option selected="selected" value="">-- SELECCIONE UN DOCENTE --</option>
                                                <?php
                                                    $sql3 = "SELECT id_docente, CONCAT(nombre, ' ', apellido) as nomYap FROM docentes ORDER BY nombre, apellido";
                                                    $existe3 = $mysqli->query($sql3);
                                                    while ($row3 = $existe3->fetch_array(MYSQLI_ASSOC)){
                                                        ?>
                                                        <option value=<?php echo $row3['id_docente'] ?>><?php echo $row3['nomYap'] ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Elejir Libro</label>
                                            <select class="form-control" id="libro" name="libro" required>
                                            <option selected="selected" value="">-- SELECCIONE EL MATERIAL --</option>
                                                <?php
                                                    $sql4 = "SELECT nombre,id_libro FROM libros WHERE activo=1 ORDER BY nombre";
                                                    $existe4 = $mysqli->query($sql4);
                                                    while ($row4 = $existe4->fetch_array(MYSQLI_ASSOC)){
                                                        ?>
                                                        <option value=<?php echo $row4['id_libro'] ?>><?php echo $row4['nombre'] ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">

                                    </div>
                                    <div class="col-12">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-2">
                                                    <input type="submit" class="btn btn-block btn-success" name="guardar" id="guarda" value="Guardar">
                                                </div>
                                                <div class="col-2">
                                                    <input type="button" class="btn btn-block btn-default" value="Cancelar" onclick="location.href='alumnos.php'">
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
        $(function() {
            $('#datemask').inputmask('yyyy-mm-dd', {
                'placeholder': 'yyyy-mm-dd'
            })
            $('#datemask1').inputmask('yyyy-mm-dd', {
                'placeholder': 'yyyy-mm-dd'
            })
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

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            });

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });

        })
    </script>
    <script>

        function enviar_ajax() {
                $.ajax({
                    type: "POST",
                    url: "acciones.php?valor=10&accion=asignar",
                    data: $("#formulario_asigna_curso").serialize(),
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