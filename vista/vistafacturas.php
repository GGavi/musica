<?php

require_once('../bd/config.php');
require_once('../modelos/modelohistorial.php');
require_once('../modelos/modelofacturafecha.php');

session_start();

?>

<html>
	<head>
		
	</head>
	
	<body>
	<table border=2px align="center">
		<tr>
			<td>Numero pedido</td>
			<td>Numero de linea</td>
			<td>Fecha de pedido</td>
			<td>Id de cancion</td>
			<td>Precio total</td>
			<td>Precio unitario</td>
		</tr>
		<?php
		if (empty($fecha1) &&  empty($fecha2)) {
			
			mostrarFacturas($db);
		} else {
			
			mostrarFechas($db, $fecha1, $fecha2);
		}
		?>
	</table>
	</body>
</html>