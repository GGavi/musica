<?php

function mostrarFechas($db, $fecha1, $fecha2) {
	
	$selectFactura = "SELECT Invoice.InvoiceId, Invoice.InvoiceDate, Invoice.Total, InvoiceLine.InvoiceLineId, InvoiceLine.TrackId, InvoiceLine.UnitPrice FROM Invoice, InvoiceLine WHERE CustomerId =".$_SESSION['id']." AND Invoice.InvoiceId = InvoiceLine.InvoiceId AND Invoice.InvoiceDate BETWEEN '$fecha1' AND '$fecha2';";
	$queryFactura = mysqli_query($db, $selectFactura);
	$arrayFactura = mysqli_fetch_array($queryFactura, MYSQLI_ASSOC);
	
	while($arrayFactura = mysqli_fetch_array($queryFactura, MYSQLI_ASSOC)) {
		
		echo "<tr>";
			echo "<td>".$arrayFactura['InvoiceId']."</td>";
			echo "<td>".$arrayFactura['InvoiceLineId']."</td>";
			echo "<td>".$arrayFactura['InvoiceDate']."</td>";
			echo "<td>".$arrayFactura['TrackId']."</td>";
			echo "<td>".$arrayFactura['Total']."</td>";
			echo "<td>".$arrayFactura['UnitPrice']."</td>";
		echo "</tr>";
	}
}

?>
