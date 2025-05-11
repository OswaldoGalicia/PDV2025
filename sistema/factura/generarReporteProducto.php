
<?php

	//print_r($_REQUEST);exit;
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

	$query_conf = mysqli_query($conection,"SELECT * FROM configuracion");
		$result_conf = mysqli_num_rows($query_conf);
		if($result_conf > 0){
			$configuracion = mysqli_fetch_assoc($query_conf);
		}

	//Busqueda por rango de fecha administrador
				if (isset($_REQUEST['fecha_de']) || isset($_REQUEST['fecha_a']) || isset($_REQUEST['busqueda'])) {
					
					$codigo = $_REQUEST['busqueda'];
					$fecha_de = mysqli_escape_string($conection,$_REQUEST['fecha_de']);
					$fecha_a = mysqli_escape_string($conection,$_REQUEST['fecha_a']);
					$f_de = $fecha_de.' 00:00:00';
					$f_a = $fecha_a.' 23:59:59';
					$where = "e.fecha BETWEEN '{$f_de}' AND '{$f_a}'";
					$usuario = $_SESSION['idUser'];
					//f.fecha BETWEEN '{$f_de} ' AND '{$f_a}'

				$query_codproducto = mysqli_query($conection, "SELECT codproducto FROM producto WHERE codigo = '$codigo'");
				$result_codproducto = mysqli_num_rows($query_codproducto);

				if ($result_codproducto > 0) {
					 	$data_codproducto = mysqli_fetch_array($query_codproducto);
					 	$codproducto = $data_codproducto['codproducto'];
					 } 
					//print_r($codproducto); exit;

			$query_reporte_producto = mysqli_query($conection,"SELECT e.nocompra,e.fecha,p.descripcion,e.cantidad,e.precio FROM entradas e
														INNER JOIN producto p
														ON e.codproducto = p.codproducto
														WHERE $where AND e.codproducto = '$codproducto'");

			$query_reporte_producto_venta = mysqli_query($conection,"SELECT e.noventa,e.fecha,p.descripcion,e.cantidad,e.precio_venta FROM detalleventa e
														INNER JOIN producto p
														ON e.codproducto = p.codproducto
														WHERE $where 
														AND e.codproducto = '$codproducto'
														AND e.status = 1");
							
				}

				$result_reporte_producto = mysqli_num_rows($query_reporte_producto);
				$result_reporte_producto_venta = mysqli_num_rows($query_reporte_producto_venta);

			ob_start();
		    include(dirname('__FILE__').'/reportePdf_producto.php');
		    $html = ob_get_clean();

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();

			$dompdf->loadHtml($html);
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('letter', 'portrait');
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('reporte.pdf',array('Attachment'=>0));
			exit;
		
	

?>