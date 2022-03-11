<?php
session_start();
if ($_SESSION["aprobado"]!="SI"){
    ?>
    <script>
        location.href = "index.php";
    </script>
            <?php
}
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
                                <h1 class="m-0 text-dark">Historial de Pagos</h1>
                            </div>  
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
                                                <th style="text-align:center;">ORDEN</th> 
                                                <th style="text-align:center;">APELLIDO Y NOMBRE</th> 
                                                <th style="text-align:center;">DNI</th>
                                                <th style="text-align:center;">MONTO</th>
                                                <th style="text-align:center;">CUOTA/FICHA</th>
                                                <th style="text-align:center;">MEDIO DE PAGO</th>
                                                <th style="text-align:center;">FECHA DE PAGO</th>
                                                <th style="text-align:center;">RECIBO</th>
                                                <?php //} ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT CONCAT(a.nombre, ' ', a.apellido) AS nomYap, a.dni, cc.monto, cc.cuota, p.fecha, mp.medio_pago, cc.id_cc, p.fecha_clase FROM alumnos a INNER JOIN cuenta_corriente cc ON (a.id_personas = cc.id_persona)
                                            INNER JOIN pagos p ON (cc.id_cc = p.id_cc)
                                            INNER JOIN medios_pago mp ON (mp.id_medio = p.medio) WHERE a.id_personas = $id and cc.pago = 1 order by cc.cuota";
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
                                                    <td style="text-align: left;"> <?php echo $row['nomYap'] ?></td>
                                                    <td style="text-align: center;"> <?php echo $row["dni"] ?></td>
                                                    <td style="text-align: center;"> <?php echo $row["monto"] ?></td>
                                                    <?php 
                                                        if($row["cuota"] == 0){
                                                            ?>
                                                            <td style="text-align: center;">Matricula</td>
                                                            <?php
                                                        }elseif($row["cuota"] != 0){
                                                            if($row["cuota"] == 999){?>
                                                                <td style="text-align: center;">PAGO DE HORAS DEL <?php echo $row["fecha_clase"] ?></td>
                                                                <?php 
                                                            }else{?>
                                                                <td style="text-align: center;"> <?php echo "CUOTA" . " " . $row["cuota"] ?></td>
                                                                <?php 
                                                            }
                                                        }
                                                    ?>
                                                    <td style="text-align: center;"> <?php echo $row["medio_pago"] ?></td>
                                                    <td style="text-align: center;"> <?php echo $row["fecha"] ?></td>
                                                    <td style="text-align: center;"><a href="imp_recibos.php?id=<?php echo $row['id_cc']; ?>"><i class="fa fa-list-alt" style="font-size: 25px;;cursor:pointer;"></i></a></td>
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

    </body>
</html>
