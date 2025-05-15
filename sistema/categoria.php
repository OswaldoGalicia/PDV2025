<?php
session_start(); 

include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>Categorias</title>
</head>
<body>
	<?php include "includes/header.php"?>
	<section id="container">

		<h1><i class="far fa-newspaper"></i> Categorias</h1>
		<a href="#" class="btn_new btnNewVenta" onclick="nuevaCategoria();"><i class="fas fa-plus"></i> Nueva categoria</a>

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
		<div class="containerTable" id="listaCategorias"> <!--listaCompras-->
			<!--CONTENIDO AJAX-->
		</div>
		<div class="paginador" id="paginadorCategorias">
			<!--CONTENIDO AJAX-->
		</div>
	</section>

		<?php include "includes/footer.php"?>

</body>
</html>