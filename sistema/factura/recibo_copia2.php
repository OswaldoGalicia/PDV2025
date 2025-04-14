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

				<?php
					if($result_config > 0){
						$iva = $configuracion['iva'];
						$moned = $configuracion['moneda'];
					}

						if ($result_detalle > 0) {
							$data_recibo = mysqli_fetch_assoc($query_productos);
						}

						date_default_timezone_set("America/Managua");
						$fecha = date('d-m-Y',strtotime($data_recibo["fecha"]));

						$numeros_letras = $numtoletra->numtoletras($data_recibo['cantidad'],' cordobas');

					?>

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
			<h4 style="margin-left: 25px; display: flex;"><?php echo $fecha; ?></h4>
		<br>
			<h4 style="margin-left: 650px; display: flex;"><?php echo number_format($data_recibo['cantidad'],2); ?></h4>	
		<br>
		<br>
			<h4 style="margin-left: 100px; display: flex;"><?php echo $factura['nombre']; ?></h4>
		<br>
			<h4 style="margin-left: 170px; display: flex;"><?php echo $numeros_letras; ?></h4>
		<br>
		<br>
			<h4 style="margin-left: 150px; display: flex;">
				<?php echo number_format($data_recibo['saldo_anterior'],2); ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php echo number_format($data_recibo['cantidad'],2); ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php echo number_format($data_recibo['saldo_actual'],2); ?>
				</h4>
		<br>
		<br>
		<?php 
			if ($data_recibo['saldo_actual'] == 0) {
				$resultado = 'CANCELACION DE CUENTA';
			}else{
				$resultado = 'ABONO A SU CUENTA';
			}
		?>
			<h4 style="margin-left: 120px; display: flex;"><?php echo $resultado; ?></h4>					
					
					
					

	<div>
		<!--<p class="nota">Si usted tiene preguntas sobre esta factura, <br>pongase en contacto con nombre, teléfono y Email</p>
		<h4 class="label_gracias">¡Gracias por su compra!</h4>-->
	</div>

</div>

</body>
</html>