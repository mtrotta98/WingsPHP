<?php
session_start();
include 'conecta.php';
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
        <link rel="stylesheet" href="desarrollo/dist/css/AdminLTE.min.css">
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
            //include 'conecta.php';
            //include 'header.php';
            include 'menu.php';
            ?>

            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">Carga de Pagos</h1>
                            </div>  
                        </div>
                    </div>
                </div>
                <section class="content">
                    <form action= "#" method= "post" name= "formulario_carga_pago" id="formulario_carga_pago" onsubmit="enviar_ajax(); return false">
                        <div class="col-md-12">
                            <div class="card card-info">
                                <?php 
                                    $sql = "SELECT nombre, apellido, dni FROM alumnos WHERE id_personas=$id";
                                    $existe = $mysqli->query($sql);
                                    $row = $existe->fetch_array(MYSQLI_ASSOC);
                                ?>
                                <div class="card-header">
                                    <h3 class="card-title">Datos del Alumno - Id: <?php echo $id ?></h3>
                                </div>
                                <div class="card-body" style="display: block;">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Nro alumno</label>
                                            <input type="text" id="id" name="id" class="form-control" placeholder="Id" readonly="readonly" value='<?php echo $id ?>'>
                                        </div>
                                        <div class="col-6">

                                        </div>
                                        <div class="col-6">
                                            <label>Apellido/s</label>
                                            <input type="text" id="ape" class="form-control" placeholder="Apellidos" readonly="readonly" value='<?php echo $row['apellido'] ?>'>
                                        </div>
                                        <div class="col-6">
                                            <label>Nombre/s</label>
                                            <input type="text" id="nom" class="form-control" placeholder="Nombres" readonly="readonly" value='<?php echo $row['nombre'] ?>'>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Fecha de Pago:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" id="datemask" name="fechaPago" required>
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <label>Tipo</label>
                                            <select name="tipo" id="tipo" name="tipo" class="form-control" required onchange="mostrar()">
                                                <?php
                                                /* $firma = $conexion_resol->prepare("SELECT * FROM RESOLUCIONES.dbo.firmante ORDER BY FIRMANTE_DESC");
                                                $firma->execute();
                                                while ($res_firma = $firma->fetch()) { */
                                                ?>
                                                <option selected="selected" value="">-- SELECCIONE UNA OPCION --</option>
                                                <option value="1" style="text-transform:uppercase;">MATRICULA</option>
                                                <option value="2" style="text-transform:uppercase;">CUOTA</option>
                                                <option value="3" style="text-transform:uppercase;">HORA</option>
                                                <?php // } ?>
                                            </select>   
                                        </div>
                                        <div class="col-4">
                                            <label>Monto</label>
                                            <input type="number" id="monto" name="monto" class="form-control"   placeholder="Monto" required>
                                        </div>  
                                        <div class="col-4">
                                            <label>Forma de Pago</label>
                                            <select name="medio" id="medio" name="medio" class="form-control" required>
                                                <option selected="selected" value="">-- SELECCIONE UNA OPCION --</option>
                                                <?php
                                                    $sql3 = "SELECT * FROM medios_pago";
                                                    $existe3 = $mysqli->query($sql3);
                                                    while ($row3 = $existe3->fetch_array(MYSQLI_ASSOC)){
                                                        ?>
                                                        <option value=<?php echo $row3['id_medio'] ?> ><?php echo $row3['medio_pago'] ?></option>
                                                        <?php 
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-6" id="cuotas" hidden>
                                            <label>Cuota a pagar</label>
                                            <select name="cuota" id="cuota" class="form-control" required>                                                
                                                <option selected="selected" value="">-- SELECCIONE UNA OPCION --</option>
                                                <?php
                                                    $fecha = (int)date("Y");
                                                    $sql2 = "SELECT cuota, pago FROM cuenta_corriente WHERE pago=0 and activo=1 and id_persona=$id and anio=$fecha and cuota!=0";
                                                    $existe2 = $mysqli->query($sql2);
                                                    while ($row2 = $existe2->fetch_array(MYSQLI_ASSOC)){
                                                        ?>
                                                        <option value=<?php echo $row2['cuota'] ?>>CUOTA <?php echo $row2['cuota'] ?> IMPAGA</option>
                                                        <?php 
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-6" id="matriculas" hidden>
                                            <label>Matricula a pagar</label>
                                            <select name="matricula" id="matricula" class="form-control" required>                                                
                                                <option selected="selected" value="">-- SELECCIONE UNA OPCION --</option>
                                                <?php
                                                    $fecha = (int)date("Y");
                                                    $sql2 = "SELECT cuota, pago FROM cuenta_corriente WHERE pago=0 and activo=1 and id_persona=$id and anio=$fecha and cuota=0";
                                                    $existe2 = $mysqli->query($sql2);
                                                    while ($row2 = $existe2->fetch_array(MYSQLI_ASSOC)){
                                                        ?>
                                                        <option value=<?php echo $row2['cuota'] ?>>CUOTA <?php echo $row2['cuota'] ?> IMPAGA</option>
                                                        <?php 
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-6" id="clases" hidden>
                                            <div class="form-group">
                                                <label>Fecha de Clase:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" id="datemask1" name="clase" required>
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                        <div class="col-4" id="horas" hidden>
                                            <label>Cantidad horas</label>
                                            <input type="number" id="hora" name="hora" class="form-control"   placeholder="Horas" required>
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
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-block btn-warning" name="historial" id="historial"><a onclick="historial(<?php echo $id; ?>)">Historial de pagos</a></button>
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

            function mostrar(){
                valor = document.getElementById("tipo").value;
                if(valor == 1){
                    document.getElementById("matriculas").removeAttribute("hidden");
                    document.getElementById("matricula").setAttribute("required", true);
                    document.getElementById("cuotas").setAttribute("hidden", true);
                    document.getElementById("cuota").removeAttribute("required");
                    document.getElementById("clases").setAttribute("hidden", true);
                    document.getElementById("datemask1").removeAttribute("required");
                    document.getElementById("horas").setAttribute("hidden", true);
                    document.getElementById("hora").removeAttribute("required");
                }else if(valor == 2){
                    document.getElementById("cuotas").removeAttribute("hidden");
                    document.getElementById("cuota").setAttribute("required", true);
                    document.getElementById("matriculas").setAttribute("hidden", true);
                    document.getElementById("matricula").removeAttribute("required");
                    document.getElementById("clases").setAttribute("hidden", true);
                    document.getElementById("datemask1").removeAttribute("required");
                    document.getElementById("horas").setAttribute("hidden", true);
                    document.getElementById("hora").removeAttribute("required");
                }else if(valor == 3){
                    document.getElementById("clases").removeAttribute("hidden");
                    document.getElementById("datemask1").setAttribute("required", true);
                    document.getElementById("horas").removeAttribute("hidden");
                    document.getElementById("hora").setAttribute("required", true);
                    document.getElementById("matriculas").setAttribute("hidden", true);
                    document.getElementById("matricula").removeAttribute("required");
                    document.getElementById("cuotas").setAttribute("hidden", true);
                    document.getElementById("cuota").removeAttribute("required");
                }
            }

            function enviar_ajax() {
                $.ajax({
                    type: "POST",
                    url: "acciones.php?valor=12&accion=cargar",
                    data: $("#formulario_carga_pago").serialize(),
                    success: function(data) {
                        alert("Datos Guardados!!!");
                        alert(data);
                        //window.location = "alumnos.php";
                        location.reload();
                    }
                });  
        }

            function historial(id){
                var id = id;
                window.location = "historial_pagos_por_alumno.php?id=" + id
            }

        </script>
    </body>
</html>
