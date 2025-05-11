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
	require_once '../numeroaletrasphp/numeroaletras.php';
	require_once '../pdf/vendor/autoload.php';
	use Dompdf\Dompdf;
	$numtoletra = new modelonumero(); 
	$numeroaletra = new numeroaletras();
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

		$query = mysqli_query($conection,"SELECT f.noventa, DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(f.fecha,'%H:%i:%s') as  hora, f.codcliente, f.status,f.abono,
												 v.nombre as vendedor,
												 cl.nit, cl.nombre, cl.telefono,cl.direccion
											FROM venta f
											INNER JOIN usuario v
											ON f.usuario = v.idusuario
											INNER JOIN cliente cl
											ON f.codcliente = cl.idcliente
											WHERE f.noventa = $noFactura AND f.codcliente = $codCliente ");


		$result = mysqli_num_rows($query);
		if($result > 0){

			$factura = mysqli_fetch_assoc($query);
			$no_factura = $factura['noventa'];
			$idcliente = $factura['codcliente'];

			if($factura['status'] == 2){
				$anulada = '<img class="anulada" src="img/anulado.png" alt="Anulada">';
			}

			$query_productos = mysqli_query($conection,"SELECT 																dt.id,dt.noventa,DATE_FORMAT(dt.fecha, '%d/%m/%Y') as fecha,DATE_FORMAT(dt.fecha,'%H:%i:%s') as  hora,dt.saldo_anterior,dt.cantidad,dt.saldo_actual,u.nombre 
													FROM detalle_recibo dt 
													INNER JOIN usuario u
													ON dt.usuario = u.idusuario
													WHERE noventa = $noFactura");
			$result_detalle = mysqli_num_rows($query_productos);

			ob_start();
		    include(dirname('__FILE__').'/recibo.php');
		    $html = ob_get_clean();

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();

			$dompdf->loadHtml($html);
			// (Optional) Setup the paper size and orientation
			$paper_size = array(0,0,204,650);
			$dompdf->setPaper($paper_size);
			//$dompdf->setPaper('letter', 'portrait');
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('recibo_'.$noFactura.'.pdf',array('Attachment'=>0));
			exit;

			}
		}
	

?>