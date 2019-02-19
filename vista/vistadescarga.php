<?php

require_once('../modelos/modelodescarga.php');
require_once('../bd/config.php');

session_start();

$id = $_SESSION['id'];

if (isset($_COOKIE['carrito'.$id])) {
	
	$array = unserialize($_COOKIE['carrito'.$id]);
	var_dump($array);
}

?>

<html>
	<head>
		
	</head>
	<body>
		<h1>COMPRA Y DESCARGA DE MUSICA</h1>
		<form name="mi_formulario" action="../controlador/controladordescarga.php" method="post">
				
			<select name='cancion'>
				<?php
				mostrarCanciones($db);
				?>
			</select><br><br>

		<input type="submit" value="A&ntilde;adir" name="carrito"><br>
		<input type="submit" value="Comprar" name="comprar"><br>
		</form>
		<a href="vistauser.php">Volver</a>
	</body>	
</html>