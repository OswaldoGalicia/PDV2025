<?php
	$subtotal 	= 0;
	$iva 	 	= 0;
	$impuesto 	= 0;
	$tl_sniva   = 0;
	$total 		= 0;
 //print_r($configuracion); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Venta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img style="width: 200px;" src="img/<?php echo $configuracion['foto']; ?>">
				</div>
			</td>
			<td class="info_empresa">
				<?php
				$user = $_SESSION['idUser'];
					if($result_conf> 0){
						$moned = $configuracion['moneda'];
					}
					$query_usuario = mysqli_query($conection,"SELECT nombre FROM usuario WHERE idusuario = $user");
					$result_usuario = mysqli_num_rows($query_usuario);
					if ($result_usuario > 0) {
					 	$data_user = mysqli_fetch_array($query_usuario);
					 	$usuario = $data_user['nombre'];
					 } 
					 date_default_timezone_set("America/Managua");
					$fecha = date('d-m-Y');
					$desde = date('d-m-Y',strtotime($fecha_de));
					$hasta = date('d-m-Y',strtotime($fecha_a));
				 ?>
				<div>
					<span class="h2"><?php echo strtoupper($configuracion['nombre']); ?></span>
					<p><?php echo $configuracion['razon_social']; ?></p>
					<p><?php echo $configuracion['direccion']; ?></p>
					<p>NIT: <?php echo $configuracion['nit']; ?></p>
					<p>Teléfono: <?php echo $configuracion['telefono']; ?></p>
					<p>Email: <?php echo $configuracion['email']; ?></p>
					<br>
				</div>
			</td>
			<td class="info_factura">
				<div class="round">
					<span class="h3">Estado de resultado</span>
					<p>Desde el: <?php echo $desde; ?></p>
					<p>Hasta el: <?php echo $hasta; ?></p>
					<p>Generado el: <?php echo $fecha; ?></p>
					<p>Usuario: <?php echo  $usuario ?></p>
				</div>
			</td>
		</tr>
		
	</table>

	<table id="factura_detalle">
			<thead>
				<tr>
					<th colspan="2">Estado de Resultado</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">
				<?php
				if ($result_venta > 0) {
					$data_venta = mysqli_fetch_array($query_venta);
					$ventas = $data_venta['ventas'];
					}

				if ($result_abono > 0) {
					$data_abono = mysqli_fetch_array($query_abono);
					$abonos = $data_abono['abonos'];
					}
						
				if ($result_compra > 0) {
					$data_compra = mysqli_fetch_array($query_compra);
					$compras = $data_compra['compras'];
					}
					$beneficio_bruto = $ventas + $abonos - $compras;
					$totalventa = $ventas + $abonos;
					?>
						    <tr id="">
							<td width="50%"><?php echo 'Ingreso total'; ?></td>
							<td><?php echo $moned.' '.number_format($totalventa,2); ?></td>
							</tr>
							<tr id="">
							<td width="50%"><?php echo 'Coste de bienes vendidos'; ?></td>
							<td><?php echo $moned.' '.number_format($compras,2); ?></td>
							</tr>

							</tbody>	
							<tfoot id="detalle_totales">
								<tr>
									<td colspan="" class=""><span>Beneficio Bruto</span></td>
									<td class=""><span><?php echo $moned.' '.number_format($beneficio_bruto,2);?></span></td>
								</tr>								
							</tfoot>			
	</table>
	<table id="factura_detalle">
			<thead>
				<tr>
					<th colspan="2">Coste Operativos</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">
				<?php
				$gastos_operativo = 0;
				if ($result_gasto > 0) {
					while ( $data_gasto = mysqli_fetch_assoc($query_gasto)) {
						$gastos = $data_gasto['cantidad'];
						$descripcion = $data_gasto['descripcion'];
						$gastos_operativo = $gastos_operativo + $gastos;
						?>
						<tr id="">
							<td width="50%"><?php echo $descripcion; ?></td>
							<td><?php echo $moned.' '.number_format($gastos,2); ?></td>
						</tr>
					<?php }					
					}
						$beneficios_operativo = $beneficio_bruto - $gastos_operativo;
					?>
						    
							</tbody>	
							<tfoot id="detalle_totales">
								<tr>
									<td colspan="" class=""><span>Gatos Operativos Totales</span></td>
									<td class=""><span><?php echo $moned.' '.number_format($gastos_operativo,2);?></span></td>
								</tr>
								<tr>
									<td colspan="" class=""><span>Beneficios Operativos</span></td>
									<td class=""><span><?php echo $moned.' '.number_format($beneficios_operativo,2);?></span></td>
								</tr>
								
							</tfoot>			
	</table>

	<div>
		<!--<p class="nota">Si usted tiene preguntas sobre esta venta, <br>pongase en contacto con nombre, teléfono y Email</p>-->
		<!--<h4 class="label_gracias">¡Gracias por su compra!</h4>-->
	</div>

</div>

</body>
</html>