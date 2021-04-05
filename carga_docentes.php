<?php
session_start();
if ($_SESSION["aprobado"]!="SI"){
    ?>
    <script>
        location.href = "index.php";
    </script>
            <?php
}
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
                            <h1 class="m-0 text-dark">Alta de docentes</h1>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <form action="#" method="post" name="formulario_carga_docente" id="formulario_carga_docente" onsubmit="enviar_ajax(); return false">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Datos del Docente</h3>
                            </div>
                            <div class="card-body" style="display: block;">
                                <div class="row">
                                    <div class="col-6">
                                        <label>Apellido/s</label>
                                        <input type="text" id="ape" class="form-control" placeholder="Apellidos" name="ape" required>
                                    </div>
                                    <div class="col-6">
                                        <label>Nombre/s</label>
                                        <input type="text" id="nom" class="form-control" placeholder="Nombres" name="nom" required>
                                    </div>
                                    <div class="col-6">
                                        <label>Documento</label>
                                        <input type="number" id="doc" class="form-control" maxlength="8" placeholder="DNI" name="doc" required>
                                    </div>
                                    <div class="col-6">
                                        <label>Email</label>
                                        <input type="text" id="email" class="form-control" placeholder="Email" name="email">
                                    </div>
                                    <div class="col-6">
                                        <label>Telefono de Linea</label>
                                        <input type="number" id="fijo" class="form-control" placeholder="Numero" name="fijo">
                                    </div>
                                    <div class="col-6">
                                        <label>Telefono Celular</label>
                                        <input type="number" id="cel" class="form-control" placeholder="Numero" name="cel">
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
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            $('#datemask1').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            $('[data-mask]').inputmask()
            $('#reservation').daterangepicker()
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
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
                    url: "acciones.php?valor=4&accion=cargar",
                    data: $("#formulario_carga_docente").serialize(),
                    success: function(data) {
                        alert("Datos Guardados!!!");
                        alert(data);
                        window.location = "docentes.php";
                    }
                });  
        }
    </script>

</body>

</html>