 <?php
session_start(); 
if ($_SESSION['rol'] != 1 and $_SESSION['rol'] !=2) 
	{
		header("location: ./");
	} 
include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>Lista de proveedores</title>
</head>
<body>
	<?php include "includes/header.php"?>
	<section id="container">

		<h1><i class="far fa-building"></i> Lista de proveedores</h1>
		<a href="#" class="btn_new" id="nuevoProveedor"><i class="fas fa-plus"></i> Crear proveedor</a>

		<form action="" method="post" class="form_search">
			<input type="text" name="busquedaProveedor" id="busquedaProveedor" placeholder="Buscar">
		</form>
		<div style="width: 120px; margin-bottom: 5px">
						
						<p>
							<strong>Mostrar por : </strong>
							<select name="cantidad_mostrar_proveedor" id="cantidad_mostrar_proveedor">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</p>

					</div>
		<div class="containerTable" id="listaProveedor">
		    <!--CONTENIDO AJAX-->
		</div>
		<div class="paginador" id="paginadorProveedor">
			<!--CONTENIDO AJAX-->
		</div>

	</section>


		<?php include "includes/footer.php"?>

</body>
</html>