<?php

require_once('../modelos/modelologin.php');
require_once('../bd/config.php');

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
     
      
	$myemail = mysqli_real_escape_string($db,$_POST['email']);
	$mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
	if (login($db, $myemail, $mypassword)) {
		
		header("location: ../vista/vistauser.php");
	} else {
		
		echo "El usuario o contraseña introducidos no existen o estan mal";
	}
}
	
?>