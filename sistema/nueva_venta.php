<?php 
	session_start();
	include "../conexion.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<?php include "includes/scripts.php"; ?>
	<title>Nueva Venta</title>
</head>
<body>

	<?php  
		include "includes/header.php"; 
		$user = $_SESSION['idUser'];
	$query_conf = mysqli_query($conection,"SELECT moneda FROM configuracion");
		$result_conf = mysqli_num_rows($query_conf);

				if ($result_conf > 0) {
					$info_conf = mysqli_fetch_assoc($query_conf);
					$moned = $info_conf['moneda'];
				}

				$query_proveedor = mysqli_query($conection,"SELECT * FROM cliente ");
			$array = array();

			if ($query_proveedor) {
				while ($data = mysqli_fetch_array($query_proveedor)) {
					$nombre = $data['nombre'];
					array_push($array, $nombre);
				}
			}

			//$query_caja = mysqli_query($conection,"SELECT * FROM caja WHERE usuario = $user AND status = 1");
			$query_caja = mysqli_query($conection,"SELECT * FROM caja WHERE status = 1");
            $result_caja = mysqli_fetch_array($query_caja);

          ?>
            	

	<section id="container">
		<?php if ($result_caja > 0) { ?>
		<div style="flex-wrap: wrap;">
			<div>
				<h1 class="titlePanelControl">Nueva Venta</h1>
			</div>
			<div class="data_producto">
				<br>
					<input style="" type="text" name="busquedaProd" id="busquedaProd" placeholder="Buscar por código o descripción">
				<br>
						
				<div class="containerTable" id="dataProd"></div>
		 		<div class="paginador" id="paginadorProd"></div> 
			</div>

			<div class="data_venta">
			<table class="table_venta">
				<tr>
					<td><input type="hidden" name="idcliente" id="idcliente" placeholder="Nit">
						<input type="text" name="nom_cliente" id="nom_cliente" placeholder="Nombre del cliente">
						<input type="text" name="nit_cliente" id="nit_cliente" disabled placeholder="Nit">
				<input type="number" name="tel_cliente" id="tel_cliente" disabled placeholder="Teléfono">
			<input type="text" name="dir_cliente" id="dir_cliente" disabled placeholder="Dirección"></td>
			<td>
				<select name="comprobante" id="comprobante">
							<option value="1">Ticket</option>
							<option value="2">Factura</option>
				</select>
				<select name="tipo_pago" id="tipo_pago">
							<option value="1">Efectivo</option>
							<option value="3">Crédito</option>
						</select>
						<input type="number" name="descuneto_venta" id="descuneto_venta" value="" placeholder="Descuento">
						<input type="" name="" value="Vendedor: <?php echo $_SESSION['nombre'];?>" disabled>
					</td>
				</tr>
			</table>
			<table class="tbl_venta table_venta">				
				<thead>
					<tr>
						<th style="display:none;">ID</th>
						<th>Cantidad</th>
						<th colspan="3">Descripción</th>
						<th class="">Precio</th>
						<th class="">Precio Total</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody id="detalle_venta">
					<!--CONTENIDO AJAX-->
				</tbody>
				<tfoot id="detalle_totales">
					<!--CONTENIDO AJAX-->
					
				</tfoot>
			</table>
			<table class="tbl_venta table_venta">
				<tr>
					<td class="textcenter">
						<div class="wd50">
						<div id="acciones_venta">
							<a href="#" class="btn_ok textcenter" id="btn_anular_venta" onclick="event.preventDefault(); anularVent();"><i class="fas fa-ban"></i> Anular</a>
							<a href="#" class="btn_new textcenter" id="btn_facturar_venta" style="display: none;" title="Procesar F10" onclick="event.preventDefault();facturar();"><i class="far fa-edit"></i> Procesar</a>
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
			var descuento = $('#descuneto_venta').val();
			serchForDetalle(usuarioid,descuento);

			var items = <?= json_encode($array); ?>;
				    $('#nom_cliente').autocomplete({
				        source: items

			});

			$("#descuneto_venta").keyup(function(e){
				e.preventDefault();
        		var descuento = $(this).val();
        		var usuarioid = '<?php echo $_SESSION['idUser']; ?>';
        		//console.log(valoroption);
        		//valorBuscar = $("input[name=descuneto_venta]").val();
        		//console.log(valorBuscar);
       		 serchForDetalle(usuarioid,descuento);
    		});

		});

		$(document).keydown(function(tecla){
				if (tecla.keyCode == 13) {
					//agregarProductoAlDetalle();
					var codigo = $('#busquedaProd').val();
						infoProductAgregarEnter(codigo);
					
				}
				if (tecla.keyCode == 121) {
					facturar();
				}
				if (tecla.keyCode == 115) {
					anularVent();
				}
			})
	</script>

</body>


</html>