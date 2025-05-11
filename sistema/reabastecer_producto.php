<?php 
	session_start();
	include "../conexion.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<?php include "includes/scripts.php"; ?>
	<title>Nueva Compra</title>
</head>
<body>
	<?php  include "includes/header.php"; 
	$query_conf = mysqli_query($conection,"SELECT moneda FROM configuracion");
		$result_conf = mysqli_num_rows($query_conf);

				if ($result_conf > 0) {
					$info_conf = mysqli_fetch_assoc($query_conf);
					$moned = $info_conf['moneda'];
				} 

		$query_proveedor = mysqli_query($conection,"SELECT * FROM proveedor ");
			$array = array();

			if ($query_proveedor) {
				while ($data = mysqli_fetch_array($query_proveedor)) {
					$nombre = $data['proveedor'];
					array_push($array, $nombre);
				}
			}

			$query_caja = mysqli_query($conection,"SELECT * FROM caja WHERE status = 1");
            $result_caja = mysqli_fetch_array($query_caja);

		?>


	<section id="container">
		<?php if ($result_caja > 0) { ?>
			<div style="flex-wrap: wrap;">
				<div>
				<h1 class="titlePanelControl">Reabastecer Productos</h1>
			</div>
			<div style="width: 59%;float: left;">
				<br>
					<input style="" type="text" name="busquedaProdCompra" id="busquedaProdCompra" placeholder="Buscar por código o descripción">
				<br>
						
				<div class="containerTable" id="dataProdCompra"></div>
		 		<div class="paginador" id="paginadorProdCompra"></div>
			</div>

			<div class="" style="width: 39%; float: right;margin: 5pt;">
			<table class="">
				<tr>
					<td><input type="hidden" name="idproveedor" id="idproveedor">
						<input type="text" name="nom_proveedor" id="nom_proveedor"  placeholder="Nombre del proveedor">
						<input type="number" name="tel_proveedor" id="tel_proveedor" disabled placeholder="Teléfono">
						<input type="text" name="dir_proveedor" id="dir_proveedor" disabled placeholder="Dirección"></td>
					<td><input type="text" name="con_proveedor" id="con_proveedor" placeholder="Contacto" disabled>
						<select name="tipo_pago" id="tipo_pago">
							<option value="1">Efectivo</option>
							<option value="3">Crédito</option>
						</select>
						<input type="" name="" value="Usuario: <?php echo $_SESSION['nombre'];?>" disabled>
					</td>
				</tr>
			</table>
			<table class="tbl_venta">				
				<thead>
					<tr>
						<th style="display:none;">ID</th>
						<th>Cantidad</th>
						<th colspan="3">Descripción</th>
						<th class="">Costo</th>
						<th class="">Costo Total</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody id="detalle_venta_compra">
					<!--CONTENIDO AJAX-->
				</tbody>
				<tfoot id="detalle_totales_compra">
					<!--CONTENIDO AJAX-->
					
				</tfoot>
			</table>
			<table class="tbl_venta">
				<tr>
					<td class="textcenter">
						<div class="wd50">
						<div id="acciones_venta">
							<a href="#" class="btn_ok textcenter" id="btn_anular_compra" onclick="event.preventDefault(); anularCompra();"><i class="fas fa-ban"></i> Anular</a>
							<a href="#" class="btn_new textcenter" id="btn_facturar_compra" style="display: none;" title="Procesar F10" onclick="event.preventDefault();comprar();"><i class="far fa-edit"></i> Procesar</a>
						</div>
					</div>
					</td>
				</tr>
			</table>
			</div>
			</div>
		<?php   }else{?>
	   	<a href="#" class="btn_new" id="abrir_caja"><i class="fas fa-plus"></i> Abrir caja</a>
       <?php   } ?>
	</section>

	<?php  include "includes/footer.php"; ?>

		

	<script type="text/javascript">
		$(document).ready(function(){
			var usuarioid = '<?php echo $_SESSION['idUser']; ?>';
			serchForDetalleCompra(usuarioid);

			var items = <?= json_encode($array); ?>;
				    $('#nom_proveedor').autocomplete({
				        source: items

			});

		});

		$(document).keydown(function(tecla){
				if (tecla.keyCode == 13) {
					//agregarProductoAlDetalle();
					var codigo = $('#busquedaProdCompra').val();
						infoProductAgregarCompraEnter(codigo);
					
				}
				if (tecla.keyCode == 121) {
					comprar();
				}
				if (tecla.keyCode == 115) {
					anularCompra();
				}
			})
	</script>

</body>


</html>