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
		echo "No es posible generar la factura.";
	}else{
		$codCliente = $_REQUEST['cl'];
		$noFactura = $_REQUEST['f'];
		$anulada = '';

		$query_config   = mysqli_query($conection,"SELECT * FROM configuracion");
		$result_config  = mysqli_num_rows($query_config);

		if($result_config > 0){
			$configuracion = mysqli_fetch_assoc($query_config);
		}

		$query_recibo = mysqli_query($conection,"SELECT noventa FROM detalle_recibo WHERE id = $noFactura");
		$result_recibo = mysqli_num_rows($query_recibo);

		if ($result_recibo > 0) {
			$info_venta = mysqli_fetch_assoc($query_recibo);
		}
		$no_venta = $info_venta['noventa'];

		$query = mysqli_query($conection,"SELECT f.noventa, DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(f.fecha,'%H:%i:%s') as  hora, f.codcliente, f.status,f.nodocumento,f.abono,
												 v.nombre as vendedor,
												 cl.nit, cl.nombre, cl.telefono,cl.direccion
											FROM venta f
											INNER JOIN usuario v
											ON f.usuario = v.idusuario
											INNER JOIN cliente cl
											ON f.codcliente = cl.idcliente
											WHERE f.noventa = $no_venta AND f.codcliente = $codCliente ");


		$result = mysqli_num_rows($query);
		if($result > 0){

			$factura = mysqli_fetch_assoc($query);
			$no_factura = $factura['noventa'];

			if($factura['status'] == 2){
				$anulada = '<img class="anulada" src="img/anulado.png" alt="Anulada">';
			}

			$query_productos = mysqli_query($conection,"SELECT * FROM detalle_recibo WHERE id = $noFactura");
			$result_detalle = mysqli_num_rows($query_productos);

			ob_start();
		    include(dirname('__FILE__').'/recibo.php');
		    $html = ob_get_clean();

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();

			$dompdf->loadHtml($html);
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('letter', 'portrait');
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('recibo_'.$noFactura.'.pdf',array('Attachment'=>0));
			exit;

			}
		}
	

?>