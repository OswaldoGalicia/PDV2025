<?php
session_start(); 

include "../conexion.php";

	$query_cliente = mysqli_query($conection,"SELECT * FROM proveedor ");
	$array = array();

	if ($query_cliente) {
		while ($data = mysqli_fetch_array($query_cliente)) {
			$nombre = $data['proveedor'];
			array_push($array, $nombre);
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>Cuentas por pagar</title>
</head>
<body>
	<?php include "includes/header.php"?>
	<section id="container">

		<h1><i class="far fa-money-bill-alt"></i> Cuentas por pagar</h1>
		<form action="" method="post" class="form_search">
			<input type="text" name="busquedaPago" id="busquedaPago" placeholder="Buscar">	
		</form>
		<div style="width: 120px; margin-bottom: 5px">
						
						<p>
							<strong>Mostrar por : </strong>
							<select name="cantidad_mostrar_porpagar" id="cantidad_mostrar_porpagar">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</p>

					</div>

		<div class="containerTable" id="cuentas_por_pagar">
			<!--CONTENIDO AJAX-->
		</div>
		<div class="paginador" id="paginador_por_pagar">
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

		$query = mysqli_query($conection,"SELECT SUM(totalcompra) as pagar,SUM(abono) as abonos						 
											FROM compras
											WHERE status = 3");

		$result = mysqli_num_rows($query);
		if ($result > 0) {
				  
			$data = mysqli_fetch_assoc($query);
		}

					if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 ){ ?>
		
				            <div><table><tr>
										<td colspan="" class="textright">Total cuentas por pagar</td>
										<td><?= $moned.' '.number_format($data['pagar'] - $data['abonos'],2);?></td>
									</tr>
							</table></div> <?php } ?>
	</section>


		<?php include "includes/footer.php"?>
		<script type="text/javascript">
			$(document).ready(function(){
				var items = <?= json_encode($array); ?>;
				    $('#new_proveedor_fact').autocomplete({
				        source: items

			});
			    
    });
		</script>

</body>

</html>