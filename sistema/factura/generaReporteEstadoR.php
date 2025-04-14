
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

	$query_conf = mysqli_query($conection,"SELECT * FROM configuracion");
		$result_conf = mysqli_num_rows($query_conf);
		if($result_conf > 0){
			$configuracion = mysqli_fetch_assoc($query_conf);
		}

	//Busqueda por rango de fecha administrador
				if (isset($_REQUEST['fecha_de']) || isset($_REQUEST['fecha_a'])) {
					
					$fecha_de = mysqli_escape_string($conection,$_REQUEST['fecha_de']);
					$fecha_a = mysqli_escape_string($conection,$_REQUEST['fecha_a']);
					$f_de = $fecha_de.' 00:00:00';
					$f_a = $fecha_a.' 23:59:59';
					$where = "fecha BETWEEN '{$f_de}' AND '{$f_a}'";
					$usuario = $_SESSION['idUser'];
					//f.fecha BETWEEN '{$f_de} ' AND '{$f_a}'
				$query_venta = mysqli_query($conection,"SELECT SUM(totalventa) as ventas FROM venta
														 WHERE $where AND status = 1");

				$query_abono = mysqli_query($conection,"SELECT SUM(abono) as abonos FROM venta 
														 WHERE $where AND status = 4");

				$query_compra = mysqli_query($conection,"SELECT SUM(cantidad * costo) as compras FROM detalleventa
														 WHERE $where AND status = 1");

				$query_gasto = mysqli_query($conection,"SELECT * FROM egresos
														 WHERE $where ");
							
				}

				$result_venta = mysqli_num_rows($query_venta);
				$result_abono = mysqli_num_rows($query_abono);
				$result_compra = mysqli_num_rows($query_compra);
				$result_gasto = mysqli_num_rows($query_gasto);

			ob_start();
		    include(dirname('__FILE__').'/reportePdf_estadoR.php');
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