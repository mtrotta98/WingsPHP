<?php
session_start();
if ($_SESSION["aprobado"] != "SI") {
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
    <!--<link rel="stylesheet" href="desarrollo/bootstrap/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="desarrollo/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <!--        <link rel="stylesheet" href="desarrollo/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">-->
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
    <link rel="stylesheet" href="desarrollo/bower_components/bootstrap-daterangepicker/daterangepicker.css">
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
                            <h1 class="m-0 text-dark">Listados</h1>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Listado de Alumnos</h3>
                            </div>
                            <div class="card-body" style="display: block;">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Alumnos:</label>
                                            <br>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>Activos
                                            <br>
                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Inactivos
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <input type="button" class="btn btn-block btn-success" name="imp" id="imp" value="Imprimir" onclick="alumnos('optionsRadios1')"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Listado de Pagos</h3>
                            </div>
                            <div class="card-body" style="display: block;">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Rango de Fechas:</label>

                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" id="date_range">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <input type="button" class="btn btn-block btn-success" name="pag" id="pag" value="Imprimir" onclick="rango()">
                                                </div>
                                                <div class="col-3">
                                                    <input type="reset" class="btn btn-block btn-default" value="Cancelar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Listado de Alumnos</h3>
                            </div>
                            <div class="card-body" style="display: block;">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Alumnos por Curso:</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Select</label>
                                                <select class="form-control" id="curso" name="curso">
                                                    <option selected="selected" value="">-- SELECCIONE EL CURSO --</option>
                                                    <?php 
                                                        $sql2 = "SELECT * FROM cursos WHERE activo = 1";
                                                        $existe = $mysqli->query($sql2);
                                                        while ($row = $existe->fetch_array(MYSQLI_ASSOC)){
                                                            ?>
                                                            <option value=<?php echo $row['id_curso'] ?>><?php echo $row['nombre_curso'] ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <input type="button" class="btn btn-block btn-success" name="imp" id="imp" value="Imprimir" onclick="cursos()"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Listado de pagos de alumno</h3>
                            </div>
                            <div class="card-body" style="display: block;">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="form-group">
                                              <label for="">Cuota/Matricula</label>
                                              <select class="form-control" name="tipoP" id="tipoP" onchange="mostCuota()">
                                                <option selected="selected" value="">-- SELECCIONE UN TIPO --</option>
                                                <option value="1">Cuota</option>
                                                <option value="2">Matricula</option>
                                              </select>
                                            </div>
                                            <div class="form-group" id="NumCuota" hidden>
                                              <label for="">Numero cuota</label>
                                              <select class="form-control" name="Ncuota" id="Ncuota">
                                                <option selected="selected" value="">-- SELECCIONE LA CUOTA --</option>
                                                <option value="2">Cuota 2</option>
                                                <option value="3">Cuota 3</option>
                                                <option value="4">Cuota 4</option>
                                                <option value="5">Cuota 5</option>
                                                <option value="6">Cuota 6</option>
                                                <option value="7">Cuota 7</option>
                                                <option value="8">Cuota 8</option>
                                                <option value="9">Cuota 9</option>
                                                <option value="10">Cuota 10</option>
                                                <option value="11">Cuota 11</option>
                                                <option value="12">Cuota 12</option>
                                              </select>
                                            </div>
                                            <input type="radio" name="optionsRadios2" id="optionsRadiosPagos" value="option1" checked>Pago
                                            <br>
                                            <input type="radio" name="optionsRadios2" id="optionsRadiosImpagos" value="option2">Impago
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <input type="button" class="btn btn-block btn-success" name="imp" id="imp" value="Imprimir" onclick="pagos('optionsRadiosPagos')"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="desarrollo/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
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
    <script src="desarrollo/dist/js/app.min.js" type="text/javascript"></script>
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

        $(function() {
            $('#date_range').daterangepicker({
                "locale": {
                    "format": "DD-MM-YYYY",
                    "separator": " - ",
                    "applyLabel": "Aplicar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "Desde",
                    "toLabel": "Hasta",
                    "customRangeLabel": "Personalizar",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Setiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                },
                "startDate": "2021-01-01",
                "endDate": "2021-01-01",
                "opens": "center"
            });
        });

        function rango() {
            rango = document.getElementById('date_range');
            window.location = 'imp_cobros.php?rango=' + rango.value;
        }

        function mostCuota(){
            tipo = document.getElementById("tipoP").value;
            if(tipo == 1){
                document.getElementById("NumCuota").removeAttribute("hidden");
                document.getElementById("NumCuota").setAttribute("required", true);
            }else{
                document.getElementById("NumCuota").removeAttribute("required");
                document.getElementById("NumCuota").setAttribute("hidden", true);
            }
        }

        function alumnos(check) {
            check = check;
            element = document.getElementById(check);
            if (element.checked) {
                window.location = 'imp_alumnos.php?tipo=activo';
            } else {
                window.location = 'imp_alumnos.php?tipo=inactivo';
            }
        }

        function cursos(){
            curso = document.getElementById('curso');
            if(curso.value == ""){
                alert("no selecciono una opcion");
            }else{
                window.location = 'imp_cursos.php?curso=' + curso.value;
            }
        }

        function pagos(check){
            check = check;
            element = document.getElementById(check);
            sel = document.getElementById('tipoP').value;
            if(sel == 1){
                cuota = document.getElementById("Ncuota").value;
            }else{
                cuota = 0;
            }
            if (element.checked) {
                window.location = 'imp_pagos_impagos.php?tipo=pago&tipoP=' + sel + "&cuota=" + cuota;
            } else {
                window.location = 'imp_pagos_impagos.php?tipo=impago&tipoP=' + sel + "&cuota=" + cuota;
            }
        }
    </script>
</body>

</html>