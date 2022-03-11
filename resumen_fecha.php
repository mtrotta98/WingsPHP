<?php
session_start();
if ($_SESSION["aprobado"] != "SI") {
?>
    <script>
        location.href = "index.php";
    </script>
<?php
}
if (!isset($_REQUEST['rango'])){
    include 'elegir_fecha.php';
    elegir_fecha();
} else{
    include 'muestra_resumen_fecha.php';
    mostrar_resumen($_REQUEST['rango']);
}
?>
