<?php
session_start(); 

include "../conexion.php";

$user = $_SESSION['idUser'];

$query_conf = mysqli_query($conection,"SELECT * FROM configuracion ");
$result_conf = mysqli_num_rows($query_conf);
if ($result_conf > 0) {
			$data_conf = mysqli_fetch_assoc($query_conf);
			$moneda = $data_conf['moneda'];
		}

//$query = mysqli_query($conection,"SELECT * FROM caja WHERE usuario = $user AND status = 1");
$query = mysqli_query($conection,"SELECT * FROM caja WHERE status = 1");
$result = mysqli_num_rows($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>Lista de caja</title>
</head>
<body>
	<?php include "includes/header.php"?>
	<section id="container">

		<h1><i class="fa fa-file-alt fa-w-12"></i> Lista de caja</h1>

		<!--<form action="" method="" class="form_search">
			<input type="text" name="busquedaEgresos" id="busquedaEgresos" placeholder="Buscar">	
		</form>-->
		<?php 
				if ($result > 0) {
			 		$data = mysqli_fetch_assoc($query);
			 		$id = $data['id'];
			 		$query_dash = mysqli_query($conection,"CALL dataDashboard($id);");
						$result_das = mysqli_num_rows($query_dash);
						if ($result_das > 0) {
							$data_dash = mysqli_fetch_assoc($query_dash);
		}
		?>
		<center><table style="width: 25%;">
			<thead>
				<th colspan="3" class="textcenter">Cierre de caja</th>
			</thead>
				<tbody>
					<tr>
						<td class="textright">Inicio</td>
						<td class="textright"><?= $moneda;?></td>
						<td id=""><?= number_format($data['inicio'],2);?></td>
					</tr>
					<tr>
						<td class="textright">Ventas</td>
						<td class="textright"><?= $moneda;?></td>
						<td id=""><?= number_format($data_dash['ventas'],2);?></td>
					</tr>
					<tr>
						<td class="textright">Abono</td>
						<td class="textright"><?= $moneda;?></td>
						<td id=""><?= number_format($data_dash['abonos'],2);?></td>
					</tr>
					<tr>
						<td class="textright">Créditos</td>
						<td class="textright"><?= $moneda;?></td>
						<td id=""><?= number_format($data_dash['credito'],2);?></td>
					</tr>
					<tr>
						<td class="textright">Egresos</td>
						<td class="textright"><?= $moneda;?></td>
						<td id=""><?= number_format($data_dash['egreso'],2);?></td>
					</tr>
					<tr style="font-weight: bold;">
						<td class="textright">Total efectivo</td>
						<td class="textright"><?= $moneda;?></td>
						<td id=""><?= number_format($data['inicio'] + $data_dash['ventas'] + $data_dash['abonos'] - $data_dash['egreso'],2);?></td>
						
					</tr>
				</tbody>
				<tfoot>
					<?php if ($data['usuario'] == $_SESSION['idUser']) { ?>
						<tr>
						<td colspan="3" class="textcenter">
							<form name="form_cierre_caja" id="form_cierre_caja" class="form_cuentas_cobrar" onsubmit="event.preventDefault(); cerrarCaja();">
								<input type="hidden" name="action" value="cerrarCaja">
								<input type="hidden" name="id_caja" id="id_caja" value="<?= $data['id'];?>">
								<input type="hidden" name="cant_inicio" id="cant_inicio" value="<?=$data['inicio'];?>">
								<input type="hidden" name="cant_ventas" id="cant_ventas" value="<?=$data_dash['ventas'];?>">
								<input type="hidden" name="cant_abonos" id="cant_abonos" value="<?=$data_dash['abonos'];?>">
								<input type="hidden" name="cant_creditos" id="cant_creditos" value="<?=$data_dash['credito'];?>">
								<input type="hidden" name="cant_egreso" id="cant_egreso" value="<?=$data_dash['egreso'];?>">
								<input type="hidden" name="total_cierre" id="total_cierre" value="<?= $data['inicio'] + $data_dash['ventas'] + $data_dash['abonos'] - $data_dash['egreso'];?>">
								<div class="alert alertAddProduct"></div>
								<button type="submit" class="btn_new" title="Cerrar caja">Cerrar caja</button>

							</form>
						</td>
						</tr>

				<?php } ?>
				</tfoot>
		</table>
		</center>
	<?php }else{ ?><a href="#" class="btn_new" id="abrir_caja"><i class="fas fa-plus"></i> Abrir caja</a><?php } ?>
	<form action="buscar_cliente.php" method="post" class="form_search">
			<input type="date" name="busquedaCaja" id="busquedaCaja" placeholder="Buscar fecha">	
		</form>
		<div style="width: 120px; margin-bottom: 5px">
						
						<p>
							<strong>Mostrar por : </strong>
							<select name="cantidad_mostrar_caja" id="cantidad_mostrar_caja">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</p>

					</div>
		<div class="containerTable" id="listaCaja">
			<!--CONTENIDO AJAX-->
		</div>
		<div class="paginador" id="paginadoCaja">
			<!--CONTENIDO AJAX-->
		</div>
	</section>


		<?php include "includes/footer.php"?>

</body>

</html>