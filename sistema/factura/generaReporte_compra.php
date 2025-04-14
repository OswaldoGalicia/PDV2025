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

		$usuario = $_SESSION['idUser'];

		if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 ){
			$query = mysqli_query($conection,"SELECT f.nocompra,f.fecha,f.totalcompra,f.codproveedor,f.status,
															u.nombre as vendedor,
															cl.proveedor as cliente
														FROM compras f
														INNER JOIN usuario u 
														ON f.usuario = u.idusuario
														INNER JOIN proveedor cl 
														ON f.codproveedor = cl.codproveedor
														 WHERE f.status != 2
														 ORDER BY f.fecha DESC ");

				//Buscador en tirmpo real
			if (isset($_REQUEST['busqueda'])) {
					$busqueda = mysqli_escape_string($conection,$_REQUEST['busqueda']);

				$query = mysqli_query($conection,"SELECT f.nocompra,f.fecha,f.totalcompra,f.codproveedor,f.status,
															u.nombre as vendedor,
															cl.proveedor as cliente
														FROM compras f
														INNER JOIN usuario u 
														ON f.usuario = u.idusuario
														INNER JOIN proveedor cl 
														ON f.codproveedor = cl.codproveedor
														 WHERE (
																f.nocompra LIKE '%$busqueda%' OR
																cl.proveedor LIKE '%$busqueda%' OR
																u.nombre LIKE '%$busqueda%' OR
																f.fecha LIKE '%$busqueda%')
														 AND f.status != 2
														 ORDER BY f.fecha DESC ");
				}
			}else{
///////////////////////Reporte vendedir//////////////////////////
				$query = mysqli_query($conection,"SELECT f.nocompra,f.fecha,f.totalcompra,f.codproveedor,f.status,
															u.nombre as vendedor,
															cl.proveedor as cliente
														FROM compras f
														INNER JOIN usuario u 
														ON f.usuario = u.idusuario
														INNER JOIN proveedor cl 
														ON f.codproveedor = cl.codproveedor
														 WHERE f.status != 2 AND f.usuario = $usuario
														 ORDER BY f.fecha DESC ");
				//Buscador en tirmpo real
			if (isset($_REQUEST['busqueda'])) {
					$busqueda = mysqli_escape_string($conection,$_REQUEST['busqueda']);

				$query = mysqli_query($conection,"SELECT f.nocompra,f.fecha,f.totalcompra,f.codproveedor,f.status,
															u.nombre as vendedor,
															cl.proveedor as cliente
														FROM compras f
														INNER JOIN usuario u 
														ON f.usuario = u.idusuario
														INNER JOIN proveedor cl 
														ON f.codproveedor = cl.codproveedor
														 WHERE (
																f.nocompra LIKE '%$busqueda%' OR
																cl.proveedor LIKE '%$busqueda%' OR
																f.fecha LIKE '%$busqueda%')
														 AND f.status != 2 AND f.usuario = $usuario
														 ORDER BY f.fecha DESC ");
				}
			}
				

				$result = mysqli_num_rows($query);

			ob_start();
		    include(dirname('__FILE__').'/reportePdf_compra.php');
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