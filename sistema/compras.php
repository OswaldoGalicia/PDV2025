<?php
session_start(); 

include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>Lista de compras</title>
</head>
<body>
	<?php include "includes/header.php"?>
	<section id="container">

		<h1><i class="far fa-newspaper"></i> Lista de compras</h1>
		<a href="reabastecer_producto.php" class="btn_new btnNewVenta"><i class="fas fa-plus"></i> Nueva compra</a>

		<form action="" method="post" class="form_search">
			<input type="text" name="busquedaCompra" id="busquedaCompra" placeholder="Buscar">
		</form>

		<div>
			<h5>Buscar por fecha</h5>
			<form action="" method="post" class="form_search_date" id="rango">
				<label>De:</label>
				<input type="date" name="fecha_de_compra" id="fecha_de_compra" required>
				<label>A</label>
				<input type="date" name="fecha_a_compra" id="fecha_a_compra" required>
				<button type="submit" class="btn_view btn_rango_fecha_compra"><i class="fas fa-search"></i></button>
				<a href="#" class="btn_view" id="reporte_pdf_compra">Generar reporte PDF</a>
			</form>
			
		</div>
		<div style="width: 120px; margin-bottom: 5px">
						
						<p>
							<strong>Mostrar por : </strong>
							<select name="cantidad_mostrar_compras" id="cantidad_mostrar_compras">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</p>

					</div>
		<div class="containerTable" id="listaCompras">
			<!--CONTENIDO AJAX-->
		</div>
		<div class="paginador" id="paginadorCompras">
			<!--CONTENIDO AJAX-->
		</div>
	</section>

		<?php include "includes/footer.php"?>

</body>
</html>