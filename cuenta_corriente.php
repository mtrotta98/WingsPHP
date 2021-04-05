<?php
session_start();
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

            $sql = "SELECT CONCAT(alumnos.nombre,' ' ,alumnos.apellido) as nombre FROM alumnos WHERE id_personas = 147";
                                            $res_existe = $mysqli->query($sql);
                                            if (!$res_existe) {
                                                echo $mysqli->error;
                                            }
                                            $persona = $res_existe->fetch_array(MYSQLI_ASSOC);
            ?>

            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        
                            <div class="col-sm-12">
                                <h1 class="m-0 text-dark">Listado de Pagos del Alumnos:<?php echo " ".$persona["nombre"] ?></h1>
                            </div>  
                        
                    </div>
                </div>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!---===============DATOS DEL CLIENTE======================--->
                            <div class="col-md-12">
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped" style="font-size: 12px">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;width: 5%">ORDEN</th> 
                                                <th style="text-align:center;width: 5%">CUOTA</th> 
                                                <th style="text-align:center;width: 5%">MONTO</th>
                                                <th style="text-align:center;width: 8%">MADIO DE PAGO</th>
                                                <th style="width: 15%;text-align:center">FECHA PAGO</th>
                                                <th style="width: 5%;text-align:center">COBRADO</th>
                                                <?php //} ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT CONCAT(alumnos.nombre,' ' ,alumnos.apellido) as nombre,
                                            cuenta_corriente.anio,
                                            cuenta_corriente.cuota,
                                            cuenta_corriente.valor,
                                            pagos.medio,
                                            if (cuenta_corriente.pago=0,'IMPAGA','PAGA') as pagada,
                                            medios_pago.medio_pago,
                                            DATE_FORMAT(pagos.fecha, '%d %m %Y') as fecha 
                                            FROM alumnos 
                                            LEFT JOIN cuenta_corriente ON alumnos.id_personas = cuenta_corriente.id_persona 
                                            LEFT JOIN pagos on cuenta_corriente.id_cc=pagos.id_cc 
                                            LEFT JOIN medios_pago on pagos.medio=medios_pago.id_medio 
                                            WHERE alumnos.id_personas = 147";
                                            //$res_existe = mysqli_query($conexion, $sql);
                                            $res_existe = $mysqli->query($sql);
                                            $i = 0;
                                            if (!$res_existe) {
                                                echo $mysqli->error;
                                            }
                                            while ($row = $res_existe->fetch_array(MYSQLI_ASSOC)) {
                                                $i++;
                                                ?>
                                                <tr>
                                                    <td style="text-align: center;"> <?php echo $i ?></td>
                                                    <td style="text-align: left;"> <?php echo $row["cuota"] ?></td>
                                                    <td style="text-align: center;"> <?php echo $row["valor"] ?></td>
                                                    <td> <?php echo $row["medio_pago"] ?></td>
                                                    <td> <?php echo $row["fecha"] ?></td>
                                                    <td> <?php 
                                                    if ($row["pagada"]=='PAGA') { 
                                                        ?><i class="fa fa-check" style="color: #32E113 !IMPORTANT;"></i>
                                                        <?php echo $row["pagada"] ;
                                                    }else{ 
                                                        ?><i class="fa fa-exclamation" style="color: red !IMPORTANT;"></i>
                                                        <?php echo $row["pagada"] ;
                                                    } ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="desarrollo/plugins/jquery/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="desarrollo/plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
                                                        $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="desarrollo/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- ChartJS -->
        <script src="desarrollo/plugins/chart.js/Chart.min.js"></script>
        <!-- Sparkline -->
        <script src="desarrollo/plugins/sparklines/sparkline.js"></script>
        <!-- JQVMap -->
        <script src="desarrollo/plugins/jqvmap/jquery.vmap.min.js"></script>
        <script src="desarrollo/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="desarrollo/plugins/jquery-knob/jquery.knob.min.js"></script>
        <!-- daterangepicker -->
        <script src="desarrollo/plugins/moment/moment.min.js"></script>
        <script src="desarrollo/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="desarrollo/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <!-- Summernote -->
        <script src="desarrollo/plugins/summernote/summernote-bs4.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="desarrollo/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="desarrollo/dist/js/adminlte.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="desarrollo/dist/js/pages/dashboard.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="desarrollo/dist/js/demo.js"></script>
        <script src="desarrollo/plugins/select2/js/select2.full.min.js"></script>
        <script src="desarrollo/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="desarrollo/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="desarrollo/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="desarrollo/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="desarrollo/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>

        <script>
                                                        $(function () {
                                                            $("#example1").DataTable({
                                                                "stateSave": true,
                                                                "iDisplayLength": 10,
                                                                "sort": true
                                                            });

                                                            $(".content-wrapper").removeAttr('style');
                                                        });
        </script>
        <script>
            function edita(id) {
                var id = id;
                window.location = "edita_alumnos.php?id=" + id
            }

            function curso(id) {
                var id = id;
                window.location = "asignar_cursos.php?id=" + id
            }

            function borra(id) {
                var id = id;
                $.ajax({
                    type: "POST",
                    url: "acciones.php?valor=2&accion=consulta",
                    data: {
                        id: id
                    },
                    success: function (data) {
                        var mensaje = confirm(data);
                        if (mensaje) {
                            $.ajax({
                                type: "POST",
                                url: "acciones.php?valor=2&accion=eliminar",
                                data: {
                                    id: id
                                },
                                success: function (data) {
                                    alert("Alumno eliminado");
                                    
                        window.location.reload();
                                }
                            });
                        } else {
                            alert("No se elimino al alumno")
                        }
                    }
                });
            }

        </script>

    </body>
</html>
