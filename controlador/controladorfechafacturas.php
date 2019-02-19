<?php

require_once('../bd/config.php');

$fecha1 = $_POST['fecha1'];
$fecha2 = $_POST['fecha2'];

if ($fecha1 == null && $fecha2 == null) {
	
	echo "No se han introducido las fechas";
	header("Location: ../vista/pedirdatosfacfecha.php");
} else {
	
	require_once('../vista/vistafacturas.php');
}

?>