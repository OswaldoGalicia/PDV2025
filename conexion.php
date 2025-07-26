<?php
	
	$host = 'localhost';
	$user = 'root';
	$password = '428655';
	$db = 'bd_ventas';

	$conection = @mysqli_connect($host,$user,$password,$db);

	if (!$conection) {
		echo "Error en la conexion";
	}

?>