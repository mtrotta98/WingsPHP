<?php
session_start();

include 'conecta.php';

$usuario = $_REQUEST["usuario"];
$clave = $_REQUEST["clave"];

 $sql = "SELECT usuario,nivel FROM usuarios WHERE usuario='$usuario' and clave=SHA1('$clave') ";
       //$res_existe = mysqli_query($conexion, $sql);
       //$existe = mysqli_fetch_array($res_existe);
       $res_existe = $mysqli->query($sql);
       $existe = $res_existe->fetch_array(MYSQLI_ASSOC);
        if ($existe) {
            $_SESSION["aprobado"]="SI";
            ?>
    <script>
        location.href = "alumnos.php";
    </script>
            <?php
        }else{
            ?>
            <script>
                alert("Usuario incorrecto!!!");
                location.href = "index.php";
            </script>
    <?php
        }

?>