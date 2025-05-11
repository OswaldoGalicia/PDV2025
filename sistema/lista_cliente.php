<?php
session_start(); 

include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>Lista de cliente</title>
</head>
<body>
	<?php include "includes/header.php"?>
	<section id="container">

		<h1><i class="fas fa-users"></i> Lista de cliente</h1>
		<a href="#" class="btn_new" id="nuevoCliente"><i class="fas fa-user-plus"></i> Crear cliente</a>

		<form action="buscar_cliente.php" method="post" class="form_search">
			<input type="text" name="busquedaCliente" id="busquedaCliente" placeholder="Buscar">	
		</form>
		<div style="width: 120px; margin-bottom: 5px">
						
						<p>
							<strong>Mostrar por : </strong>
							<select name="cantidad_mostrar_clientes" id="cantidad_mostrar_clientes">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</p>

					</div>
		<div class="containerTable" id="listaCliente">
			<!--CONTENIDO AJAX-->
		</div>
		<div class="paginador" id="paginadorClient">
			<!--CONTENIDO AJAX-->
		</div>
	</section>


		<?php include "includes/footer.php"?>

</body>

</html>