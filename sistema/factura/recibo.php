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
    <link rel="stylesheet" href="styleticket.css">
</head>
<body>
<?php echo $anulada; ?>
<div id="page_pdf">
	<?php
					if($result_config > 0){
						$iva = $configuracion['iva'];
						$moned = $configuracion['moneda'];
					}

						if ($result_detalle > 0) {
							$data_recibo = mysqli_fetch_assoc($query_productos);
						}

						date_default_timezone_set("America/Managua");
						//$fecha = date('d-m-Y',strtotime($data_recibo["fecha"]));
						//$hora = date_format($data_recibo['fecha'],'%H:%i:%s');
						$numeros_letras = $numtoletra->numtoletras($data_recibo['cantidad'],' cordobas');

					?>

	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img src="img/<?php echo $configuracion['foto']; ?>">
				</div>
			</td>
		</tr>
		<tr>
			<td class="info_empresa">

				<?php
					if($result_config > 0){
						$iva = $configuracion['iva'];
						$moned = $configuracion['moneda'];
					}
				 ?>
				<div>
					<span class="h2"><?php echo strtoupper($configuracion['nombre']); ?></span>
					<p><?php echo $configuracion['razon_social']; ?></p>
					<p><?php echo $configuracion['direccion']; ?></p>
					<p>RUC: <?php echo $configuracion['nit']; ?>&nbsp;&nbsp;&nbsp;&nbsp;Cel: <?php echo $configuracion['telefono']; ?></p>
					<p></p>					
				</div>
			</td>
			</tr>
			<tr>
			<td class="">

				<div class="round">
					<strong>&nbsp;&nbsp;No. Recibo: <?php echo str_pad($data_recibo['id'],11,'0', STR_PAD_LEFT); ?>&nbsp;&nbsp;&nbsp;&nbsp;Fecha: <?php echo $data_recibo['fecha'] ; ?></strong>
					<p>&nbsp;&nbsp;Hora: <?php echo $data_recibo['hora']; ?></p>
					<p>&nbsp;&nbsp;Usuario: <?php echo $data_recibo['nombre']; ?></p>
					<strong>&nbsp;&nbsp;Cliente: <?php echo $factura['nombre']; ?></strong>
					<p>&nbsp;&nbsp;Nit: <?php echo $factura['nit']; ?></p>
				</div>
			</td>
		</tr>
	</table>

	<table id="factura_detalle">
			<thead>
				<tr>
					<th colspan="2" class="textleft"> ------------------------------------------------------------------ </th>
				</tr>
				<tr>
					<th class="textright"> Descripción</th>
					<th class="" class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cantidad</th>
				</tr>
				<tr>
					<th colspan="2" class="textleft"> ------------------------------------------------------------------ </th>
				</tr>
			</thead>
			<tbody id="detalle_productos">

				<tr>
					<td class="textright">Saldo anterior:</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $moned.' ' .number_format($data_recibo['saldo_anterior'],2); ?></td>
				</tr>
				<tr>
					<td class="textright">Abono:</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $moned.' ' .number_format($data_recibo['cantidad'],2); ?></td>
				</tr>

			</tbody>
			<tfoot id="detalle_totales">
				<tr>
					<td colspan="3"><p>---------------------------------------------------------</p></td>
				</tr>
				<tr>
					<td class="textright"><span>Saldo actual:<span></td>
					<td><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $moned.' ' .number_format($data_recibo['saldo_actual'],2); ?></span></td>
				</tr>
		</tfoot>
	</table>
	<br>
	<br>
	<br>
	<div>
		<!--<p class="nota">Si usted tiene preguntas sobre esta factura, <br>pongase en contacto con nombre, teléfono y Email</p>-->
		<h4 class="label_gracias">¡Gracias por su visita!</h4>
		<p class="label_gracias">Email: <?php echo $configuracion['email']; ?></p>
	</div>

</div>

</body>
</html>