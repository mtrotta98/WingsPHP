<?php

$usuario = "root";
$password = "";
$servidor = "localhost";
$basededatos = "wings";

//$conexion = mysqli_connect($servidor, $usuario, "") or die("No se ha podido conectar al servidor de Base de datos");

//$db = mysqli_select_db($conexion, $basededatos) or die("Upps! Pues va a ser que no se ha podido conectar a la base de datos");

$mysqli = new mysqli("localhost", "root", "", "wings");
if ($mysqli->connect_errno) {
    echo "Fallo al realizar la conexion (". $mysqli->connect_errno . ") " . $mysqli->connect_errno;
}

echo $mysqli->host_info . "\n";
?>