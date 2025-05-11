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
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php echo $anulada; ?>
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
					if($result_config > 0){
						$iva = $configuracion['iva'];
						$moned = $configuracion['moneda'];

				if ($factura['status'] == 1) {
					$tipo_pago = 'Contado';
				}elseif($factura['status'] == 3){
					$tipo_pago = 'Crédito';
				}else{
					$tipo_pago = 'Anulado';
				}
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
				<?php
					}
				 ?>
			</td>
			<td class="info_factura">
				<div class="round">
					<span class="h3">Factura</span>
					<p>No. Compra: <strong><?php echo $factura['nocompra']; ?></strong></p>
					<p>Fecha: <?php echo $factura['fecha']; ?></p>
					<p>Hora: <?php echo $factura['hora']; ?></p>
					<p>Vendedor: <?php echo $factura['vendedor']; ?></p>
					<p>Compra al: <?php echo $tipo_pago; ?></p>
					<br>
				</div>
			</td>
		</tr>
	</table>

	<table id="factura_cliente">
		<tr>
			<td class="info_cliente">

				<div class="round">
					<span class="h3">Cliente</span>
					<table class="datos_cliente">
						<tr>
							<td><label>Contacto:</label><p><?php echo $factura['contacto']; ?></p></td>
							<td><label>Teléfono:</label> <p><?php echo $factura['telefono']; ?></p></td>
						</tr>
						<tr>
							<td><label>Proveedor:</label> <p><?php echo $factura['proveedor']; ?></p></td>
							<td><label>Dirección:</label> <p><?php echo $factura['direccion']; ?></p></td>
						</tr>
					</table>
				</div>
			</td>

		</tr>
	</table>

	<table id="factura_detalle">
			<thead>
				<tr>
					<th width="50px">Cant.</th>
					<th class="textleft">Descripción</th>
					<th class="" width="150px">Precio Unitario.</th>
					<th class="" width="150px"> Precio Total</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">

			<?php

				if($result_detalle > 0){

					while ($row = mysqli_fetch_assoc($query_productos)){
						$precio_venta = number_format($row['precio'],2);
						$precio_total = number_format($row['precio_total'],2);

			 ?>
				<tr>
					<td class="textcenter"><?php echo $row['cantidad']; ?></td>
					<td><?php echo $row['descripcion']; ?></td>
					<td class=""><?php echo $moned.' '.$precio_venta; ?></td>
					<td class=""><?php echo $moned.' '.$precio_total; ?></td>
				</tr>
			<?php
						$precio_total = $row['precio_total'];
						$subtotal = round($subtotal + $precio_total, 2);
					}
				}

				$impuesto 	= round($subtotal * ($iva / 100), 2);
				$tl_sniva 	= round($subtotal - $impuesto,2 );
				$total 		= number_format($tl_sniva + $impuesto,2);
				$tl_sniva1 = number_format($subtotal - $impuesto,2);
				$impuesto1 = number_format($subtotal * ($iva / 100), 2);
			?>
			</tbody>
			<tfoot id="detalle_totales">
				<!--<tr>
					<td colspan="2" class="textright"><span>SUBTOTAL </span></td>
					<td></td>
					<td class=""><span> <?php echo $moned.' '.$tl_sniva1; ?></span></td>
				</tr>
				<tr>
					<td colspan="2" class="textright"><span>IVA (<?php echo $iva; ?> %) </span></td>
					<td></td>
					<td class=""><span> <?php echo $moned.' '.$impuesto1; ?></span></td>
				</tr>-->
				<tr>
					<td colspan="2" class="textright"><span>TOTAL </span></td>
					<td></td>
					<td class=""><span> <?php echo $moned.' '.$total; ?></span></td>
				</tr>
		</tfoot>
	</table>
	<!--<div>
		<p class="nota">Si usted tiene preguntas sobre esta factura, <br>pongase en contacto con nombre, teléfono y Email</p>
		<h4 class="label_gracias">¡Gracias por su compra!</h4>
	</div>-->

</div>

</body>
</html>