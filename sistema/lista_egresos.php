<?php
session_start(); 

include "../conexion.php";

//$query = mysqli_query($conection,"SELECT * FROM caja WHERE usuario = $user AND status = 1");
		$query_caja = mysqli_query($conection,"SELECT * FROM caja WHERE status = 1");
		$result_caja = mysqli_num_rows($query_caja);
		if ($result_caja > 0) {
			 		$data_caja = mysqli_fetch_assoc($query_caja);
			 		$id_caja = $data_caja['id'];
			 		$query_dash = mysqli_query($conection,"CALL dataDashboard($id_caja);");
		$result_das = mysqli_num_rows($query_dash);
		if ($result_das > 0) {
			$data_dash = mysqli_fetch_assoc($query_dash);
			$inicio = $data_dash['inicios'];
			$ventas = $data_dash['ventas'];
			$abonos = $data_dash['abonos'];
			$creditos = $data_dash['credito'];
			$egreso = $data_dash['egreso'];
			$total = $inicio + $ventas + $abonos - $egreso;
			mysqli_close($conection);
		}
			 		}



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>Lista de egresos</title>
</head>
<body>
	<?php include "includes/header.php"?>
	<section id="container">
		<input type="hidden" name="total_caja" id="total_caja" value="<?= $total; ?>">
		<h1><i class="fa fa-file-alt fa-w-12"></i> Lista de egresos</h1>
		<a href="#" class="btn_new" id="nuevoEgreso"><i class="fas fa-plus"></i> Nuevo egreso</a>

		<form action="" method="" class="form_search">
			<input type="text" name="busquedaEgresos" id="busquedaEgresos" placeholder="Buscar">	
		</form>
		<div style="width: 120px; margin-bottom: 5px">
						
						<p>
							<strong>Mostrar por : </strong>
							<select name="cantidad_mostrar_egresos" id="cantidad_mostrar_egresos">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</p>

					</div>
		<div class="containerTable" id="listaEgresos">
			<!--CONTENIDO AJAX-->
		</div>
		<div class="paginador" id="paginadoEgresos">
			<!--CONTENIDO AJAX-->
		</div>
	</section>


		<?php include "includes/footer.php"?>

</body>

</html>