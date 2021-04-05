<?php
session_start();
$id = $_REQUEST['id'];
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
                            <h1 class="m-0 text-dark">Editar Ficha</h1>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <form action="#" method="post" name="formulario_edita_ficha" id="formulario_edita_ficha" onsubmit="enviar_ajax(); return false">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Datos de la ficha</h3>
                            </div>
                            <div class="card-body" style="display: block;">
                                <?php 
                                    $sql = "SELECT * FROM alumnos a INNER JOIN fichas_salud fs ON (a.id_personas = fs.id_alumno) WHERE a.id_personas = $id";
                                    $existe = $mysqli->query($sql);
                                    $row = $existe->fetch_array(MYSQLI_ASSOC);
                                ?>
                                <div class="row">
                                    <div class="col-3">
                                        <label>Documento del alumno</label>
                                        <input type="text" id="docAl" class="form-control" placeholder="Dni" name="docAl" value='<?php echo $row['dni'] ?>' readonly>
                                    </div>
                                    <div class="col-9">
                                    
                                    </div>
                                    <div class="col-6">
                                        <label>Nombre de Emergencia</label>
                                        <input type="text" id="nomEm" class="form-control" placeholder="Nombre" name="nomEm" value='<?php echo $row['nombre_emergencia'] ?>' required>
                                    </div>
                                    <div class="col-6">
                                        <label>Numero de Emergencia</label>
                                        <input type="number" id="numEm" class="form-control" placeholder="Numero" name="numEm" value='<?php echo $row['telefono_emergencia'] ?>' required>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>El Instituto cuenta con la cobertura médica de SUM. En caso de traslado dirigirse a:</label>
                                            <select class="form-control" id="traslado" name="traslado" required>
                                            <option selected value="">--SELECCIONE UNA OPCION--</option>
                                            <option value="Sanatorio San José de Villa Elisa">Sanatorio San José de Villa Elisa</option>
                                            <option value="Hospital de Gonnet">Hospital de Gonnet</option>
                                            <option value="Hospital de Niños Sor María Ludovica de La Plata">Hospital de Niños Sor María Ludovica de La Plata</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Fecha de Carga:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control" data-inputmask-alias="date" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" id="datemask" name="fecha" value='<?php echo $row['fecha_carga'] ?>'>
                                            </div>
                                                <!-- /.input group -->
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <label>¿Sufre de alguna enfermedad?</label>
                                        <div class="form-group">
                                            <label>
                                                <input value=1 type="radio" name="r1" id="check1" class="minimal" checked onchange="javascript:showContent('check1', 'content')">
                                                Si
                                            </label>
                                            <label>
                                                <input value=0 type="radio" name="r1" id="check2" class="minimal" onchange="javascript:showContent('check1', 'content')">
                                                No
                                            </label>
                                            
                                        </div>
                                        <div id="content" style="display: block;">
                                            <input type="text" id="desc_enf" class="form-control" placeholder="Descripcion" name="desc_enf" value='<?php echo $row['descripcion_enfermedad'] ?>'> 
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label>¿Recibe tratamiento actualmente?</label>
                                        <div class="form-group">
                                            <label>
                                                <input value=1 type="radio" name="r2" id="check3" class="minimal" checked onchange="javascript:showContent('check3', 'content2')">
                                                Si
                                            </label>
                                            <label>
                                                <input value=0 type="radio" name="r2" id="check4" class="minimal" onchange="javascript:showContent('check3', 'content2')">
                                                No
                                            </label>
                                            
                                        </div>
                                        <div id="content2" style="display: block;">
                                            <input type="text" id="desc_trat" class="form-control" placeholder="Descripcion" name="desc_trat" value='<?php echo $row['descripcion_tratamiento'] ?>'>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label>¿Ha sido intervenido quirúrgicamente?</label>
                                        <div class="form-group">
                                            <label>
                                                <input value=1 type="radio" name="r3" id="check5" class="minimal" checked onchange="javascript:showContent('check5', 'content3')">
                                                Si
                                            </label>
                                            <label>
                                                <input value=0 type="radio" name="r3" id="check6" class="minimal" onchange="javascript:showContent('check5', 'content3')">
                                                No
                                            </label>
                                            
                                        </div>
                                        <div id="content3" style="display: block;">
                                            <input type="text" id="desc_inter" class="form-control" placeholder="Descripcion" name="desc_inter" value='<?php echo $row['descripcion_intervencion'] ?>'>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label>¿Toma alguna medicación?</label>
                                        <div class="form-group">
                                            <label>
                                                <input value=1 type="radio" name="r4" id="check7" class="minimal" checked onchange="javascript:showContent('check7', 'content4')"> 
                                                Si
                                            </label>
                                            <label>
                                                <input value=0 type="radio" name="r4" id="check8" class="minimal" onchange="javascript:showContent('check7', 'content4')">
                                                No
                                            </label>
                                            
                                        </div>
                                        <div id="content4" style="display: block;">
                                            <input type="text" id="desc_medi" class="form-control" placeholder="Descripcion" name="desc_medi" value='<?php echo $row['descripcion_medicacion'] ?>'>
                                        </div>
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
                    url: "acciones.php?valor=11&accion=actualiza",
                    data: $("#formulario_edita_ficha").serialize(),
                    success: function(data) {
                        alert("Datos Guardados!!!");
                        alert(data);
                        window.location = "lista_fichas.php";
                    }
                });  
        }
    </script>
    <script type="text/javascript">
        function showContent(check, muestra) {
            check = check
            muestra = muestra
            element = document.getElementById(muestra);
            check = document.getElementById(check);
            if (check.checked) {
                element.style.display='block';
            }
            else {
                element.style.display='none';
        }
    }
</script>
</body>

</html>