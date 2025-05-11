<?php
session_start(); 

include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>Lista de productos</title>
</head>
<body>
	<?php include "includes/header.php"?>
	<section id="container">

		<h1><i class="fas fa-cube"></i> Lista de productos</h1>
	<?php  
	if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 ){ ?>
		<a href="#" class="btn_new btnNewProducto" id="nuevoProducto"><i class="fas fa-plus"></i> Registrar producto</a>
		<a href="descargarExel.php" class="btn_new " id=""><i class="far fa-file-excel"></i> Exportar a excel</a>
		<a href="stock0.php" class="btn_new " id=""><i class="far fa-file-excel"></i> Stock 0</a>
		<a href="#" class="btn_new " id="reporteProducto"><i class="fa fa-file-alt fa-w-12"></i> Reporte Producto</a>
		<?php } ?>
		<form class="form_search">
			<input type="text" name="busquedaProducto" id="busquedaProducto" placeholder="Buscar">
		</form>
					<div style="width: 120px; margin-bottom: 5px">
						
						<p>
							<strong>Mostrar por : </strong>
							<select name="cantidad_mostrar_producto" id="cantidad_mostrar_producto">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</p>

					</div>
		<div class="containerTable" id="listaProducto">
			<!--CONTENIDO AJAX-->
		</div>
		<div class="paginador" id="paginadorProducto">
			<!--CONTENIDO AJAX-->
		</div>
		<br>
		<?php 

		$query_conf = mysqli_query($conection,"SELECT moneda FROM configuracion");

		$result_conf = mysqli_num_rows($query_conf);
		if ($result_conf > 0) {				  
			$data_conf = mysqli_fetch_assoc($query_conf);
			$moned = $data_conf['moneda'];
		}

		$query = mysqli_query($conection,"SELECT SUM(existencia * costo) as inversion, 																		SUM(existencia * precio) as proyeccion 
											FROM producto
											WHERE status = 1");

		$result = mysqli_num_rows($query);
		if ($result > 0) {
				  
			$data = mysqli_fetch_assoc($query);
		}
		$ganancia = $data['proyeccion'] - $data['inversion'];
		$utilidad = ($ganancia / $data['inversion'])*100;
					if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 ){ ?>
		
				            <div><table><tr>
										<td colspan="" class="textright">Inverción Total</td>
										<td><?= $moned.' '.number_format($data['inversion'],2);?></td>
										<td colspan="" class="textright">Proyección de ventas</td>
										<td><?= $moned.' '.number_format($data['proyeccion'],2);?></td>
										<td colspan="" class="textright">Utilidad</td>
										<td><?= number_format($utilidad,2);?> % </td>
									</tr>
							</table></div> <?php } ?>



	</section>


		<?php include "includes/footer.php"?>

</body>
</html>