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
	<title>Factura</title>
    <link rel="stylesheet" type="text/css" href="style.css?1.0">
</head>
<body>
<?php echo $anulada; ?>
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
					if($result_config > 0){
						$iva = $configuracion['iva'];
						$moned = $configuracion['moneda'];
				 ?>
				<div>
					<br>
					<span class="h2"><?php echo strtoupper($configuracion['nombre']); ?></span>
					<br>
					<p><?php echo $configuracion['razon_social']; ?></p>
					<br>
					<p><?php echo $configuracion['direccion']; ?></p>
					<br>
					<p>NIT: <?php echo $configuracion['nit']; ?></p>
					<br>
					<p>Teléfono: <?php echo $configuracion['telefono']; ?></p>
					<br>
					<p>Email: <?php echo $configuracion['email']; ?></p>
					<br>
				</div>
				<?php
					}
				 ?>
			</td>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
			<td class="info_empresa">

				<div class="">
					<span class="">Factura</span>
					<br>
					<p>No. Factura: <strong><?php echo $factura['noventa']; ?></strong></p>
					<br>
					<p>Fecha: <?php echo $factura['fecha']; ?></p>
					<br>
					<p>Hora: <?php echo $factura['hora']; ?></p>
					<br>
					<p>Vendedor: <?php echo $factura['vendedor']; ?><?php echo $factura['nit']; ?></p>
					<br>
				</div>
			</td>
		</tr>
	</table>
	<table id="factura_cliente">
		<tr>
			<td class="info_cliente">
				<div class="">
					<br>
						<br>

					<span>Cliente</span>
					<br>
					<table class="datos_cliente">
						<tr>
							<br>
							<td><label>Nit:</label><p><?php echo $factura['nit']; ?></p></td>
							<br>
							<td><label>Teléfono:</label> <p><?php echo $factura['telefono']; ?></p></td>
							<br>
						</tr>
						<tr>
							<td><label>Cliente:</label> <p><?php echo $factura['nombre']; ?></p></td>
							<td><label>Dirección:</label> <p><?php echo $factura['direccion']; ?></p></td>
						</tr>
					</table>
				</div>
			</td>

		</tr>
	</table>
<br>
<br>
<br>
<br>
	<table id="factura_detalle">
			<thead>
				<tr>
					<th>No. Factura</th>
					<th>Cliente</th>
					<th>Saldo anterior</th>
					<th>Abono</th>
					<th>Saldo actual</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">
					<?php 
						if ($result_detalle > 0) {
							$data_recibo = mysqli_fetch_assoc($query_productos);
						}

					?>
				<tr>
					<td class="textcenter"><?php echo $factura['nodocumento']; ?></td>
					<td><?php echo $factura['nombre']; ?></td>
					<td><?php echo $data_recibo['saldo_anterior']; ?></td>
					<td class=""><?php echo $data_recibo['cantidad']; ?></td>
					<td><?php echo $data_recibo['saldo_actual']; ?></td>
				</tr>

			</tbody>
			<tfoot id="detalle_totales">

		</tfoot>
	</table>
	<div>
		<!--<p class="nota">Si usted tiene preguntas sobre esta factura, <br>pongase en contacto con nombre, teléfono y Email</p>-->
		<h4 class="label_gracias">¡Gracias por su compra!</h4>
	</div>

</div>

</body>
</html>