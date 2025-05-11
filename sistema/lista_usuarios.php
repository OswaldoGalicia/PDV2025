<?php
session_start();
	if ($_SESSION['rol'] != 1) 
	{
		header("location: ./");
	} 

include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php";?>
	<title>Sisteme Ventas</title>
</head>
<body>
	<?php include "includes/header.php";?>
	<section id="container">

		<h1><i class="fas fa-users"></i> Listade usuarios</h1>
		<a href="#" class="btn_new" id="nuevoUsuario"><i class="fas fa-user-plus"></i> Crear Usuario</a>

		<form action="" method="post" class="form_search">
			<input type="text" name="busquedaUsuario" id="busquedaUsuario" placeholder="Buscar">
		</form>
		<div style="width: 120px; margin-bottom: 5px">
						
						<p>
							<strong>Mostrar por : </strong>
							<select name="cantidad_mostrar_usuarios" id="cantidad_mostrar_usuarios">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</p>

					</div>
		<div class="containerTable" id="listaUsuario">
			<!--CONTENIDO AJAX-->
		</div>
		<div class="paginador" id="paginadorUsuario">
			<!--CONTENIDO AJAX-->
		</div>
	</section>


		<?php include "includes/footer.php"?>

</body>
</html>