<?php

session_start();

function mostrarFacturas($db) {
	
	$selectFactura = "SELECT Invoice.InvoiceId, Invoice.InvoiceDate, Invoice.Total, InvoiceLine.InvoiceLineId, InvoiceLine.TrackId, InvoiceLine.UnitPrice FROM Invoice, InvoiceLine WHERE CustomerId =".$_SESSION['id']." AND Invoice.InvoiceId = InvoiceLine.InvoiceId;";
	$queryFactura = mysqli_query($db, $selectFactura);
	
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
