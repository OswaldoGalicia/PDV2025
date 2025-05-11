<?php
session_start(); 

include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>Lista de ventas</title>
</head>
<body>
	<?php include "includes/header.php"?>
	<section id="container">

		<h1><i class="far fa-newspaper"></i> Lista de ventas</h1>
		<a href="nueva_venta.php" class="btn_new btnNewVenta"><i class="fas fa-plus"></i> Nueva venta</a>
		<form action="" method="post" class="form_search">
			<input type="text" name="busquedaVentas" id="busquedaVentas" placeholder="Buscar">
		</form>

		<div>
			<h5>Buscar por fecha</h5>
			<form action="" method="post" class="form_search_date" id="rango">
				<label>De:</label>
				<input type="date" name="fecha_de" id="fecha_de" required>
				<label>A</label>
				<input type="date" name="fecha_a" id="fecha_a" required>
				<button type="submit" class="btn_view btn_rango_fecha"><i class="fas fa-search"></i></button>
				<a href="#" class="btn_view" id="reporte_pdf">Generar reporte PDF</a>
				<a href="#" class="btn_new" id="devolucion"><i class="fas fa-undo-alt"></i> Devolución</a>
			</form>
			
		</div>
		<div style="width: 120px; margin-bottom: 5px">
						
						<p>
							<strong>Mostrar por : </strong>
							<select name="cantidad_mostrar_ventas" id="cantidad_mostrar_ventas">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</p>

					</div>
		<div class="containerTable" id="listaVentas">
			<!--CONTENIDO AJAX-->
		</div>
		<div class="paginador" id="paginadorVentas">
			<!--CONTENIDO AJAX-->
		</div>
	</section>

		<?php include "includes/footer.php"?>

</body>
</html>