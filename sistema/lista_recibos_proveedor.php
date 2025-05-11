<?php
session_start(); 

include "../conexion.php";
if (isset($_REQUEST['busqueda'])){
	$no_compra = $_REQUEST['busqueda'];
}

		$query_conf = mysqli_query($conection,"SELECT moneda FROM configuracion");
		$result_conf = mysqli_num_rows($query_conf);
		$usuario = $_SESSION['idUser'];


				if ($result_conf > 0) {
					$info_conf = mysqli_fetch_assoc($query_conf);
					$moned = $info_conf['moneda'];
				}
				
	$query_venta = mysqli_query($conection,"SELECT v.nocompra,v.fecha,v.nodocumento,cl.proveedor as proveedor,u.nombre as usuario,v.totalcompra 
											FROM compras v
											INNER JOIN usuario u
											ON v.usuario = u.idusuario
											INNER JOIN proveedor cl
											ON v.codproveedor = cl.codproveedor
											WHERE nocompra = $no_compra ");
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
	<title>Recibos por factura de proveedor</title>
</head>
<body>
	<?php include "includes/header.php"?>
	<section id="container">

		<h1><i class="far fa-newspaper"></i> Recibos por factura de proveedor</h1>
		
			<input type="hidden" name="busquedaRecibo_prov" id="busquedaRecibo_prov" placeholder="Buscar" value="<?php echo $no_compra ?>">
		<div class="containerTable">
			<table>
				<thead>
					<th>No. compra</th>
					<th>Fecha</th>
					<th>Proveedor</th>
					<th>Usuario</th>
					<th>No. factura</th>
					<th>cantidad</th>
					<th>Estado</th>
				</thead>
						<tr>
							<td id="id_nocompra"><?php echo $no_compra ?></td>
							<td><?php echo $fecha; ?></td>
							<td id="id_proveedor"><?php echo $info_venta['proveedor']; ?></td>
							<td><?php echo $info_venta['usuario']; ?></td>
							<td><?php echo $info_venta['nodocumento']; ?></td>
							<td><?php echo $moned.' '.number_format($info_venta['totalcompra'],2); ?></td>
							<td><?php echo $estado_cuenta ?></td>
						</tr>
			</table>
			
		</div>	
		
		<div class="containerTable" id="listaRecibos_proveedor">
			<!--CONTENIDO AJAX-->
		</div>
		<div class="paginador" id="paginadorRecibos_proveedor">
			<!--CONTENIDO AJAX-->
		</div>
	</section>

		<?php include "includes/footer.php"?>

</body>
<script type="text/javascript">
 		listaRecibos_proveedor();
</script>
</html>