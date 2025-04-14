<?php
session_start(); 

include "../conexion.php";
if (isset($_REQUEST['busqueda'])){
	$no_venta = $_REQUEST['busqueda'];
}

		$query_conf = mysqli_query($conection,"SELECT moneda FROM configuracion");
		$result_conf = mysqli_num_rows($query_conf);
		$usuario = $_SESSION['idUser'];


				if ($result_conf > 0) {
					$info_conf = mysqli_fetch_assoc($query_conf);
					$moned = $info_conf['moneda'];
				}

	$query_venta = mysqli_query($conection,"SELECT v.noventa,v.fecha,v.nodocumento,cl.nombre as cliente,													u.nombre as usuario,v.totalventa 
											FROM venta v
											INNER JOIN usuario u
											ON v.usuario = u.idusuario
											INNER JOIN cliente cl
											ON v.codcliente = cl.idcliente
											WHERE noventa = $no_venta ");
	$result = mysqli_num_rows($query_venta);
	if ($result > 0) {
		$info_venta = mysqli_fetch_assoc($query_venta);
	}

						date_default_timezone_set("America/Managua");
						$fecha = date('d-m-Y',strtotime($info_venta["fecha"]));
						$fecha_a_vencer = date('d-m-Y',strtotime($fecha. '+ 30 days'));
						$hoy = strtotime(date('d-m-Y'));
						$estado_cuenta = '';

						if (strtotime($fecha_a_vencer) >= $hoy) {
							$estado_cuenta = $fecha_a_vencer;
						}else{
							$estado_cuenta = '<span class="anulada">Vencido</span>';
						}

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

		<h1><i class="far fa-newspaper"></i> Recibos por factura</h1>
		
			<input type="hidden" name="busquedaRecibo" id="busquedaRecibo" placeholder="Buscar" value="<?php echo $no_venta ?>">
		<div class="containerTable">
			<table>
				<thead>
					<th>No. venta</th>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Vendedor</th>
					<th>No. factura</th>
					<th>cantidad</th>
					<th>Estado</th>
				</thead>
						<tr>
							<td id="id_noventa"><?php echo $no_venta ?></td>
							<td><?php echo $fecha; ?></td>
							<td id="id_cliente"><?php echo $info_venta['cliente']; ?></td>
							<td><?php echo $info_venta['usuario']; ?></td>
							<td><?php echo $info_venta['nodocumento']; ?></td>
							<td><?php echo $moned.' '.number_format($info_venta['totalventa'],2); ?></td>
							<td><?php echo $estado_cuenta ?></td>
						</tr>
			</table>
			
		</div>	
		
		<div class="containerTable" id="listaRecibos">
			<!--CONTENIDO AJAX-->
		</div>
		<div class="paginador" id="paginadorRecibos">
			<!--CONTENIDO AJAX-->
		</div>
	</section>

		<?php include "includes/footer.php"?>

</body>
<script type="text/javascript">
 		listaRecibos();
</script>
</html>