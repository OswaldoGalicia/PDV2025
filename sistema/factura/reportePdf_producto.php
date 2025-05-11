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
					<span class="h3">Reporte por producto</span>
					<p>Desde el: <?php echo $desde; ?></p>
					<p>Hasta el: <?php echo $hasta; ?></p>
					<p>Generado el: <?php echo $fecha; ?></p>
				</div>
			</td>
		</tr>
		
	</table>

	<table id="factura_detalle">
			<thead>
				<tr>
					<th>Fecha</th>
					<th>No. Compra</th>
					<th>Producto</th>
					<th>Cantidad</th>
					<th>Costo</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">
				<?php
				if ($result_reporte_producto > 0) {
					$total_compra = 0;
					while ( $data_reporte_porducto = mysqli_fetch_array($query_reporte_producto)) {
							$nocompra = $data_reporte_porducto['nocompra'];
							$codproducto = $data_reporte_porducto['descripcion'];
							$fecha = $data_reporte_porducto['fecha'];
							$cantidad = $data_reporte_porducto['cantidad'];
							$costo = $data_reporte_porducto['precio'];
							$total_compra = $total_compra + $cantidad;

					?>
						    <tr id="">
						    	<td ><?php echo $fecha; ?></td>
								<td ><?php echo $nocompra; ?></td>
								<td ><?php echo $codproducto; ?></td>
								<td ><?php echo $cantidad; ?></td>
								<td ><?php echo $moned.' '.number_format($costo,2); ?></td>
							</tr>
							</tbody>
				<?php
					}					
						?>
							<tfoot id="detalle_totales">
							<tr>
								<td></td>
								<td></td>
								<td><span>TOTAL COMPRA</span></td>
								<td><span><?php echo $total_compra; ?></span></td>
							</tr>							
							</tfoot>
				<?php
										
				}		?>			
	</table>

	<table id="factura_detalle">
			<thead>
				<tr>
					<th>Fecha</th>
					<th>No. Venta</th>
					<th>Producto</th>
					<th>Cantidad</th>
					<th>Precio</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">
				<?php
				if ($result_reporte_producto_venta > 0) {
					$total_venta = 0;
					while ( $data_reporte_porducto_venta = mysqli_fetch_array($query_reporte_producto_venta)) {
							$noventa = $data_reporte_porducto_venta['noventa'];
							$codproducto_venta = $data_reporte_porducto_venta['descripcion'];
							$fecha_venta = $data_reporte_porducto_venta['fecha'];
							$cantidad_venta = $data_reporte_porducto_venta['cantidad'];
							$precio = $data_reporte_porducto_venta['precio_venta'];
							$total_venta = $total_venta + $cantidad_venta;

					?>
						    <tr id="">
						    	<td ><?php echo $fecha_venta; ?></td>
								<td ><?php echo $noventa; ?></td>
								<td ><?php echo $codproducto_venta; ?></td>
								<td ><?php echo $cantidad_venta; ?></td>
								<td ><?php echo $moned.' '.number_format($precio,2); ?></td>
							</tr>
							</tbody>
				<?php
					}					
						?>
							<tfoot id="detalle_totales">
							<tr>
								<td></td>
								<td></td>
								<td><span>TOTAL VENTA</span></td>
								<td><span><?php echo $total_venta; ?></span></td>
							</tr>							
							</tfoot>
				<?php
										
				}		?>			
	</table>

</div>

</body>
</html>