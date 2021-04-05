<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index.php" class="nav-link">Inicio</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <?php
                $hoy = date('Y-m-d');

                    $consulta1 = "Select count(*) as total from turnos where fecha='{$hoy}'";
                    $turnosdehoy1 = mysqli_query($conexion, $consulta1);
                    $resultado_turnos1 = mysqli_fetch_array($turnosdehoy1);
                    $son = $resultado_turnos1["total"];
                ?>
                <span class="badge badge-warning navbar-badge"><?php echo $son ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">Turnos del dia</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item"> 
                    <?php
                    if ($son > 0) {
                        $consulta = "Select PresNro from turnos where fecha='{$hoy}'";
                        $turnosdehoy = mysqli_query($conexion, $consulta);
                        while ($resultado_turnos = mysqli_fetch_array($turnosdehoy)) {
                            echo '<i class="fas fa-envelope mr-2"></i>' . $resultado_turnos["PresNro"];
                            echo "<br />";
                        }
                    }
                    ?>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">Ir a turnos</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>