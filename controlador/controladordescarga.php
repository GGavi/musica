<?php

require_once('../modelos/modelodescarga.php');
require_once('../bd/config.php');

session_start();

if (isset($_POST['carrito'])) {
    	
	$cancion = $_POST['cancion'];
	anadirCarrito($db, $cancion);
	
} else if (isset($_POST['comprar'])) {
    	
		if (insertarInvoice($db)) {
			
			if (insertarLineaInvoice($db)) {
				
				echo "La operacion se ha realizado correctamente";
                $id = $_SESSION['id'];
				unset($_COOKIE['carrito'.$id]);
    			setcookie('carrito'.$id, '', time() - 3600, '/'); // empty value and old timestamp
				mysqli_commit($db);
			} else {
				
				echo "Ha habido problemas al procesar la linea de la factura";
				mysqli_rollback($db);
			}
		} else {
			
			echo "Ha habido problemas al insertar la factura";
			mysqli_rollback($db);
		}
	}

?>
