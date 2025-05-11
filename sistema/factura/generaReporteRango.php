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
					if (empty($_REQUEST['busqueda'])) {
						$Busqueda = '';
					}else{
						$Busqueda = $_REQUEST['busqueda'];
					}
					
					$fecha_de = mysqli_escape_string($conection,$_REQUEST['fecha_de']);
					$fecha_a = mysqli_escape_string($conection,$_REQUEST['fecha_a']);
					$f_de = $fecha_de.' 00:00:00';
					$f_a = $fecha_a.' 23:59:59';
					$where = "f.fecha BETWEEN '{$f_de}' AND '{$f_a}'";
					$usuario = $_SESSION['idUser'];
					//f.fecha BETWEEN '{$f_de} ' AND '{$f_a}'
		if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 ){
				$query = mysqli_query($conection,"SELECT f.noventa,f.fecha,f.totalventa,f.codcliente,f.status,f.abono,
															u.nombre as vendedor,
															cl.nombre as cliente
														FROM venta f
														INNER JOIN usuario u 
														ON f.usuario = u.idusuario
														INNER JOIN cliente cl 
														ON f.codcliente = cl.idcliente
														 WHERE $where
														 AND (f.status = 1 OR f.status = 4)
														 AND (u.nombre LIKE '%$Busqueda%' OR
														 cl.nombre like '%$Busqueda%')
														 ORDER BY f.fecha DESC ");
													
				
				}else{
					//Busqueda por rango de fecha vendedor

				$query = mysqli_query($conection,"SELECT f.noventa,f.fecha,f.totalventa,f.codcliente,f.status,f.abono,
															u.nombre as vendedor,
															cl.nombre as cliente
														FROM venta f
														INNER JOIN usuario u 
														ON f.usuario = u.idusuario
														INNER JOIN cliente cl 
														ON f.codcliente = cl.idcliente
														 WHERE $where
														 AND (f.status = 1 OR f.status = 4) 
														 AND f.usuario = $usuario
														 ORDER BY f.fecha DESC ");
													}
				}

				$result = mysqli_num_rows($query);

			ob_start();
		    include(dirname('__FILE__').'/reportePdf.php');
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