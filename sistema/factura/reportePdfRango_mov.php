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
					<img src="img/<?php echo $configuracion['foto']; ?>">
				</div>
			</td>
			<td class="info_empresa">
				<?php
					if($result_conf> 0){
						$moned = $configuracion['moneda'];
					}
				 ?>
				<div>
					<span class="h2"><?php echo strtoupper($configuracion['nombre']); ?></span>
					<p><?php echo $configuracion['razon_social']; ?></p>
					<p><?php echo $configuracion['direccion']; ?></p>
					<p>NIT: <?php echo $configuracion['nit']; ?></p>
					<p>Teléfono: <?php echo $configuracion['telefono']; ?></p>
					<p>Email: <?php echo $configuracion['email']; ?></p>
				</div>
			</td>
			<td class="info_factura">

			</td>
		</tr>
		
	</table>

	<table id="factura_detalle">
			<thead>
				<tr>
					<th>No.</th>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Vendedor</th>
					<th>Estado</th>
					<th>Factura</th>
					<th>Abono</th>
					<th class="">Saldo total</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">
				<?php

				if ($result > 0) {
					$ventas_totales = 0;
					while ($data = mysqli_fetch_array($query)) {
						date_default_timezone_set("America/Managua");
						$fecha = date('d-m-Y',strtotime($data["fecha"]));
						$fecha_a_vencer = date('d-m-Y',strtotime($fecha. '+ 30 days'));
						$hoy = strtotime(date('d-m-Y'));
						$estado_cuenta = '';

						$nofactura = $data["noventa"];
						$cliente = $data["cliente"];
						$vendedor = $data["vendedor"];
						$totalfactura= number_format($data["totalventa"],2);
						$totalfact = $data["totalventa"];
						$abono = $data['abono'];
						$ventas_totales = $ventas_totales + $totalfact - $abono;

						if ($totalfact == 0 ) {
							$factura = '';
						}else{
							$factura = $moned.' '.number_format($totalfact,2);
						}

						if ($abono == 0) {
							$info_abono = '';
						}else{
							$info_abono = $moned.' '.number_format($abono,2);
						}

						?>
						    <tr id="">
							<td><?php echo $nofactura; ?></td>
							<td><?php echo $fecha; ?></td>
							<td><?php echo $cliente; ?></td>
							<td><?php echo $vendedor; ?></td>
							<td><?php echo $fecha_a_vencer; ?></td>
							<td><?php echo $factura; ?></td>
							<td><?php echo $info_abono; ?></td>
							<td class="totalfactura"><?php echo $moned.' '.$ventas_totales; ?></td>
							</tr>;

							<?php
							}
					}
				?>
						
			</tbody>	
			<tfoot id="detalle_totales">
				
		</tfoot>
	</table>
	<div>
		<!--<p class="nota">Si usted tiene preguntas sobre esta venta, <br>pongase en contacto con nombre, teléfono y Email</p>-->
		<!--<h4 class="label_gracias">¡Gracias por su compra!</h4>-->
	</div>

</div>

</body>
</html>