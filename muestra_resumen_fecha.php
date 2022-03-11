<?php

function mostrar_resumen($rango){

include 'conecta.php';
$div = explode(' - ', $rango);

$f1= $div[0];
$f2= $div[1];

$f1 = date('Y-m-d',strtotime($f1));
$f2 = date('Y-m-d',strtotime($f2));

$ingresos = "SELECT sum(cc.monto) as total from pagos p
                            LEFT JOIN cuenta_corriente cc on p.id_cc=cc.id_cc
                            WHERE cc.pago=1 and p.fecha between '$f1' and '$f2' ";

$existe = $mysqli->query($ingresos);

$ing = $existe->fetch_array(MYSQLI_ASSOC);

$egreso = "SELECT sum(monto) as total from gastos
                            WHERE activo=1 and gastos.fecha between '$f1' and '$f2'";

$existe1 = $mysqli->query($egreso);

$eg = $existe1->fetch_array(MYSQLI_ASSOC);

$res = $ing["total"] - $eg["total"];
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
            //include 'header.php';
            include 'menu.php';
            ?>

            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <h1 class="m-0 text-dark">Resumen Ingresos y Egresos</h1>
                            </div> 
                        </div>
                        <div class="col-sm-2">
                                <input type="text" id="rango" name="rango" class="form-control" placeholder="Rango" readonly="readonly" value='<?php echo $rango ?>'> 
                        </div>
                    </div>
                </div>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!---===============CUADROS CON DATOS======================--->
                            <div class="col-md-4">
                                <div class="box-body">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">INGRESOS DEL MES</span>
                                            <span class="info-box-number"><?php echo $ing["total"] ?></span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box-body">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-red"><i class="ion ion-ios-cart-outline"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">EGRESOS DEL MES</span>
                                            <span class="info-box-number"><?php echo $eg["total"] ?></span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box-body">
                                    <div class="info-box">
                                        <?php if ($res < 0) { ?>
                                            <span class="info-box-icon bg-red"><i class="ion ion-ios-cloud-download-outline"></i></i></span>
                                        <?php } else { ?>    
                                            <span class="info-box-icon bg-green"><i class="ion ion-ios-pricetag-outline"></i></i></span>
                                        <?php } ?>    
                                        <div class="info-box-content">
                                            <span class="info-box-text">RESUMEN</span>
                                            <span class="info-box-number"><?php echo $ing["total"] - $eg["total"] ?></span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                            </div>
                            <!---===============DATOS DE GASTOS======================--->
                            <div class="col-md-6">
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped" style="font-size: 12px">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;">ORDEN</th> 
                                                <th style="text-align:center;">CONCEPTO</th> 
                                                <th style="text-align:center;">FECHA</th>
                                                <th style="text-align:center;">MONTO</th>
                                                <th style="text-align:center;">EDITAR</th>
                                                <th style="text-align:center;">BORRAR</th>
                                                <?php //}  ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT
                                            DATE_FORMAT(p.fecha,'%d/%m/%Y')
                                            AS fecha, 
											CASE WHEN (cuota > 0 and cuota < 13) THEN CONCAT( apellido, ' ',nombre, ' CUOTA ', cuota) WHEN (cuota = 0) THEN CONCAT( apellido, ' ',nombre, ' MATRICULA ') ELSE CONCAT( apellido, ' ',nombre, ' PAGO DE HORAS ') END AS nombre, 
											cc.monto, a.id_personas, cc.id_cc, p.id_pago, p.cant_horas
                                            FROM
                                            pagos p
                                            LEFT JOIN cuenta_corriente cc ON p.id_cc = cc.id_cc 
                                            LEFT JOIN alumnos a on cc.id_persona=a.id_personas
                                            WHERE
                                            cc.pago = 1 
                                            AND p.fecha between '$f1' and '$f2' ORDER BY cc.cuota";
                                            
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
                                                    <?php
                                                    if($row["cant_horas"] == null){?>
                                                        <td style="text-align: left;"> <?php echo $row["nombre"] ?></td>
                                                    <?php
                                                    }else{?>
                                                        <td style="text-align: left;"> <?php echo $row["nombre"] . "(" . $row["cant_horas"] . ")" ?></td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td style="text-align: center;"> <?php echo $row["fecha"] ?></td>
                                                    <td> <?php echo $row["monto"] ?></td>
                                                    <td><a onclick="edita(<?php echo $row['id_personas']; ?>, <?php echo $row['id_cc']; ?>, <?php echo $row['id_pago']; ?>)"><i class="fa fa-fw fa-edit" style="font-size: 25px;;cursor:pointer;"></i></a></td>
                                                    <td><a onclick="borra(<?php echo $row['id_personas']; ?>, <?php echo $row['id_cc']; ?>, <?php echo $row['id_pago']; ?>)"><i class="fa fa-fw fa-trash" style="font-size: 25px;;cursor:pointer;"></i></a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="box-body">
                                    <table id="example2" class="table table-bordered table-striped" style="font-size: 12px">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;">ORDEN</th> 
                                                <th style="text-align:center;">CONCEPTO</th> 
                                                <th style="text-align:center;">FECHA</th>
                                                <th style="text-align:center;">MONTO</th>
                                                <th style="text-align:center;">EDITAR</th>
                                                <th style="text-align:center;">BORRAR</th>
                                                <?php //}  ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT
                                            DATE_FORMAT(fecha,'%d/%m/%Y')
                                            AS fecha,  
                                            concepto,
                                            monto, id_pago
                                            FROM
                                            gastos 
                                            WHERE
                                            activo = 1 
                                            AND gastos.fecha between '$f1' and '$f2'";
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
                                                    <td style="text-align: left;"> <?php echo $row["concepto"] ?></td>
                                                    <td style="text-align: center;"> <?php echo $row["fecha"] ?></td>
                                                    <td> <?php echo $row["monto"] ?></td>
                                                    <td><a onclick="edita_gasto(<?php echo $row['id_pago']; ?>)"><i class="fa fa-fw fa-edit" style="font-size: 25px;;cursor:pointer;"></i></a></td>
                                                    <td><a onclick="borra_gasto(<?php echo $row['id_pago']; ?>)"><i class="fa fa-fw fa-trash" style="font-size: 25px;;cursor:pointer;"></i></a></td>
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
                                                        $(function () {
                                                            $("#example2").DataTable({
                                                                "stateSave": true,
                                                                "iDisplayLength": 10,
                                                                "sort": true
                                                            });

                                                            $(".content-wrapper").removeAttr('style');
                                                        });
        </script>
        <script>
            function edita(id, id2, id3) {
                var id = id;
                var id2 = id2;
                var id3 = id3;
                var rango = document.getElementById('rango').value;
                localStorage.setItem("rango", rango);
                window.location = "edita_pagos.php?id=" + id + "&id2=" + id2 + "&id3=" + id3 + "&rango=" + rango
            }

            function borra(id, id2, id3) {
                var id = id;
                var id2 = id2;
                var id3 = id3;
                $.ajax({
                    type: "POST",
                    url: "acciones.php?valor=15&accion=consulta",
                    data: {
                        id: id,
                        id2: id2,
                        id3: id3
                    },
                    success: function (data) {
                        var mensaje = confirm(data);
                        if (mensaje) {
                            $.ajax({
                                type: "POST",
                                url: "acciones.php?valor=15&accion=eliminar",
                                data: {
                                    id: id,
                                    id2: id2,
                                    id3: id3
                                },
                                success: function (data) {
                                    alert("Pago eliminado");

                                    window.location.reload();
                                }
                            });
                        } else {
                            alert("No se elimino el pago")
                        }
                    }
                });
            }

            function edita_gasto(id){
                var id = id;
                var rango = document.getElementById('rango').value;
                localStorage.setItem("rango", rango);
                window.location = "edita_gastos.php?rango=" + rango + "&id=" + id
            }

            function borra_gasto(id){
                var id = id;
                $.ajax({
                    type: "POST",
                    url: "acciones.php?valor=16&accion=consulta",
                    data: {
                        id: id
                    },
                    success: function (data) {
                        var mensaje = confirm(data);
                        if (mensaje) {
                            $.ajax({
                                type: "POST",
                                url: "acciones.php?valor=16&accion=eliminar",
                                data: {
                                    id: id
                                },
                                success: function (data) {
                                    alert("Gasto eliminado");

                                    window.location.reload();
                                }
                            });
                        } else {
                            alert("No se elimino el gasto")
                        }
                    }
                });
            }

        </script>

    </body>
</html>
<?php } ?>