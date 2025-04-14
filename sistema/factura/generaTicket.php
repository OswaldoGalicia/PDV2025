<?php

	//print_r($_REQUEST);
	//exit;
	//echo base64_encode('2');
	//exit;
	session_start();
	if(empty($_SESSION['active']))
	{
		header('location: ../');
	}

	include "../../conexion.php";
	require_once '../pdf/vendor/autoload.php';
	use Dompdf\Dompdf;

	if(empty($_REQUEST['cl']) || empty($_REQUEST['f']))
	{
		echo "No es posible generar la venta.";
	}else{
		$codCliente = $_REQUEST['cl'];
		$noVenta = $_REQUEST['f'];
		$anulada = '';

		$query_config   = mysqli_query($conection,"SELECT * FROM configuracion");
		$result_config  = mysqli_num_rows($query_config);
		if($result_config > 0){
			$configuracion = mysqli_fetch_assoc($query_config);
		}


		$query = mysqli_query($conection,"SELECT f.noventa, DATE_FORMAT(f.fecha, '%d/%m/%Y') as fechaF, DATE_FORMAT(f.fecha,'%H:%i:%s') as  horaF, f.codcliente, f.status,f.fecha,f.descuento,
												 v.nombre as vendedor,
												 cl.nit, cl.nombre, cl.telefono,cl.direccion
											FROM venta f
											INNER JOIN usuario v
											ON f.usuario = v.idusuario
											INNER JOIN cliente cl
											ON f.codcliente = cl.idcliente
											WHERE f.noventa = $noVenta AND f.codcliente = $codCliente  AND f.status != 10 ");

		$result = mysqli_num_rows($query);
		if($result > 0){

			$venta = mysqli_fetch_assoc($query);
			$no_venta = $venta['noventa'];

			if($venta['status'] == 2){
				$anulada = '<img class="anulada" src="img/anulado.png" alt="Anulada">';
			}

			$query_productos = mysqli_query($conection,"SELECT p.descripcion,dt.cantidad,dt.precio_venta,(dt.cantidad * dt.precio_venta) as precio_total,p.codigo
														FROM venta f
														INNER JOIN detalleventa dt
														ON f.noventa = dt.noventa
														INNER JOIN producto p
														ON dt.codproducto = p.codproducto
														WHERE f.noventa = $no_venta ");
			$result_detalle = mysqli_num_rows($query_productos);

			ob_start();
		    include(dirname('__FILE__').'/ticket.php');
		    $html = ob_get_clean();

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();

			$dompdf->loadHtml($html);
			// (Optional) Setup the paper size and orientation
			$paper_size = array(0,0,204,1000);
			$dompdf->setPaper($paper_size);
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('venta_'.$noVenta.'.pdf',array('Attachment'=>0));
			exit;
		}
	}

?>