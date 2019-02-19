<?php

function mostrarCanciones($db) {
	
	echo "Selecciona las canciones con el desplegable y el boton de a&ntilde;adir, finaliza la compra con comprar";
	
	$selectCancion = "SELECT TrackId, Name FROM Track;";
	$queryCancion = mysqli_query($db, $selectCancion);
	while ($arrayCancion = mysqli_fetch_array($queryCancion, MYSQLI_ASSOC)) {
					
		echo "<option value='".$arrayCancion['TrackId']."'>".$arrayCancion['Name']."</option>";
	}
}

function anadirCarrito($db, $cancion) {
	
    $id = $_SESSION['id'];
	if (isset($_COOKIE['carrito'.$id])) {
		
		$datosCookie = array();
		$datosCookie = unserialize($_COOKIE['carrito'.$id]);
			
		if (in_array($cancion, $datosCookie)) {
				
			echo "La cancion ya esta en el carrito";
			echo "<a href='../vista/vistadescarga.php'>Volver</a>";
		} else {
				
			array_push($datosCookie, $cancion);
			setcookie('carrito'.$id, serialize($datosCookie), time() + (86400 * 30), "/");
			var_dump(unserialize($_COOKIE['carrito'.$id]));
			header("location: ../vista/vistadescarga.php");
		}
		
		
	} else {
		
		$carritoCanciones = array();
		array_push($carritoCanciones, $cancion);
		setcookie('carrito'.$id, serialize($carritoCanciones), time() + (86400 * 30), "/");
		var_dump(unserialize($_COOKIE['carrito'.$id]));
		header("location: ../vista/vistadescarga.php");
	}
}

function insertarInvoice($db) {
	
	$valido = true;
	$insertInvoice = mysqli_prepare($db, "INSERT INTO Invoice(InvoiceId, CustomerId, InvoiceDate, Total) VALUES (?,?,?,?);");
	$queryInvoiceId = mysqli_query($db, "SELECT max(InvoiceId)+1 AS InvoiceId FROM Invoice");
	$arrayInvoiceId = mysqli_fetch_array($queryInvoiceId, MYSQLI_ASSOC);
	$fecha = date('Y-m-d');
	$total = calcularTotal($db);
	
	mysqli_stmt_bind_param($insertInvoice, 'iisd', $arrayInvoiceId['InvoiceId'], $_SESSION['id'], $fecha, $total);
	if (!mysqli_stmt_execute($insertInvoice)) {
		
		$valido = false;
		return $valido;
	} else {
		
		$_SESSION['invoiceid'] = $arrayInvoiceId['InvoiceId'];
		return $valido;
	}
}

function insertarLineaInvoice($db) {
	
    $id = $_SESSION['id'];
	$valido = true;
	$insertInvoiceLine = mysqli_prepare($db, "INSERT INTO InvoiceLine(InvoiceLineId, InvoiceId, TrackId, UnitPrice, Quantity) VALUES (?,?,?,?,?);");
	$datosCookie = unserialize($_COOKIE['carrito'.$id]);
	
	for ($i = 0; $i < count($datosCookie); $i++) {
		
		$selectInvoiceLineId = "SELECT max(InvoiceLineId)+1 AS InvoiceLineId FROM InvoiceLine;";
		$queryInvoiceLineId = mysqli_query($db, $selectInvoiceLineId);
		$arrayInvoiceLineId = mysqli_fetch_array($queryInvoiceLineId, MYSQLI_ASSOC);
		$invoiceLineId = $arrayInvoiceLineId['InvoiceLineId'];
		
		$invoiceId = $_SESSION['invoiceid'];
		
		$trackId = $datosCookie[$i];
		
		$queryUnitPrice = mysqli_query($db, "SELECT UnitPrice FROM Track WHERE TrackId = $trackId;");
		$arrayUnitPrice = mysqli_fetch_array($queryUnitPrice);
		$unitPrice = $arrayUnitPrice['UnitPrice'];
		
		$quantity = 1;
		
		mysqli_stmt_bind_param($insertInvoiceLine, 'iiidi', $invoiceLineId, $invoiceId, $trackId, $unitPrice, $quantity);
		
		if (!mysqli_stmt_execute($insertInvoiceLine)) {
			
			$valido = false;
		}
	}
	
	return $valido;
}

function calcularTotal($db) {
	
    $id = $_SESSION['id'];
	$total = 0;
	$datosCookie = unserialize($_COOKIE['carrito'.$id]);
	
	for ($i = 0; $i < count($datosCookie); $i++) {
		
		$selectPrecio = "SELECT UnitPrice FROM Track WHERE TrackId = $datosCookie[$i];";
		$queryPrecio = mysqli_query($db, $selectPrecio);
		$arrayPrecio = mysqli_fetch_array($queryPrecio, MYSQLI_ASSOC);
		
		$total+= $arrayPrecio['UnitPrice'];
	}
	
	return $total;
}

?>
