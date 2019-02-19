<?php

function login($db, $myemail, $mypassword) {
	
	$valido;
	$selectUser = "SELECT Email, LastName, CustomerId FROM Customer WHERE Email = '$myemail' AND LastName = '$mypassword';";
	$queryUser = mysqli_query($db, $selectUser);
	$arrayUser = mysqli_fetch_array($queryUser);
	
	if ($arrayUser['Email'] == null || $arrayUser['LastName'] == null) {
		
		$valido = false;
	} else {
		
		$valido = true;
		$_SESSION['id'] = $arrayUser['CustomerId'];
	}
	
	return $valido;
}

?>
