<?php 

	include "../../conexion.php";
	session_start();
	//print_r($_POST);
	 //Extraer datos del detalle_temp
		$query_conf = mysqli_query($conection,"SELECT moneda FROM configuracion");
		$result_conf = mysqli_num_rows($query_conf);
		$usuario = $_SESSION['idUser'];


				if ($result_conf > 0) {
					$info_conf = mysqli_fetch_assoc($query_conf);
					$moned = $info_conf['moneda'];
				}

		$por_pagina = $_POST['cantidad'];

		if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 ){

			//Buscador en tirmpo real
			if (isset($_POST['busqueda'])) {
					$busqueda = mysqli_escape_string($conection,$_POST['busqueda']);

					$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro, 
															f.nocompra,f.fecha,f.totalcompra,f.codproveedor,f.status,
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
														 AND f.status != 10");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			if(empty($_POST['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_POST['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_pagina = ceil($total_registro / $por_pagina);

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
														 AND f.status != 10
														 ORDER BY f.fecha DESC LIMIT $desde,$por_pagina");
				}

				//Busqueda por rango de fecha
				if (isset($_POST['fecha_de']) && isset($_POST['fecha_a'])){
					//print_r($_POST);
					if (empty($_POST['busqueda'])) {
						$busqueda = '';
					}else{
						$busqueda = $_POST['busqueda'];
					}

					$fecha_de = mysqli_escape_string($conection,$_POST['fecha_de']);
					$fecha_a = mysqli_escape_string($conection,$_POST['fecha_a']);
					$f_de = $fecha_de.' 00:00:00';
					$f_a = $fecha_a.' 23:59:59';
					//$where = "fecha BETWEEN '$f_de' AND '$f_a'";

					$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM compras 
																WHERE fecha BETWEEN '{$f_de} ' AND '{$f_a}'
																AND status != 10");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			//$por_pagina = 10;

			if(empty($_POST['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_POST['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_pagina = ceil($total_registro / $por_pagina);

				$query = mysqli_query($conection,"SELECT f.nocompra,f.fecha,f.totalcompra,f.codproveedor,f.status,
															u.nombre as vendedor,
															cl.proveedor as cliente
												FROM compras f
												INNER JOIN usuario u 
												ON f.usuario = u.idusuario
												INNER JOIN proveedor cl 
												ON f.codproveedor = cl.codproveedor
												WHERE f.fecha BETWEEN '{$f_de} ' AND '{$f_a}'
												AND f.status != 10 AND (u.nombre LIKE '%$busqueda%' OR
														 				cl.proveedor like '%$busqueda%')
												ORDER BY f.fecha DESC LIMIT $desde,$por_pagina");
				}
			}else{
//////////////////////////Ventas de vendedor////////////////////////////////				

			//Buscador en tirmpo real
			if (isset($_POST['busqueda'])) {
					$busqueda = mysqli_escape_string($conection,$_POST['busqueda']);

					$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro, f.nocompra,f.fecha,f.totalcompra,f.codproveedor,f.status,
															u.nombre as vendedor,
															cl.nombre as cliente
														FROM compras f
														INNER JOIN usuario u 
														ON f.usuario = u.idusuario
														INNER JOIN proveedor cl 
														ON f.codproveedor = cl.codproveedor
														 WHERE (
																f.nocompra LIKE '%$busqueda%' OR
																cl.proveedor LIKE '%$busqueda%' OR
																f.fecha LIKE '%$busqueda%')
														 AND f.usuario = $usuario  ");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			//$por_pagina = 10;

			if(empty($_POST['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_POST['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_pagina = ceil($total_registro / $por_pagina);

				$query = mysqli_query($conection,"SELECT f.nocompra,f.fecha,f.totalcompra,f.codproveedor,f.status,
															u.nombre as vendedor,
															cl.nombre as cliente
														FROM compras f
														INNER JOIN usuario u 
														ON f.usuario = u.idusuario
														INNER JOIN proveedor cl 
														ON f.codproveedor = cl.codproveedor
														 WHERE (
																f.nocompra LIKE '%$busqueda%' OR
																cl.proveedor LIKE '%$busqueda%' OR
																f.fecha LIKE '%$busqueda%')
														 AND f.usuario = $usuario 
														 ORDER BY f.fecha DESC LIMIT $desde,$por_pagina");
				}

				//Busqueda por rango de fecha
				if (isset($_POST['fecha_de']) && isset($_POST['fecha_a'])){
					//print_r($_POST);
					$fecha_de = mysqli_escape_string($conection,$_POST['fecha_de']);
					$fecha_a = mysqli_escape_string($conection,$_POST['fecha_a']);
					$f_de = $fecha_de.' 00:00:00';
					$f_a = $fecha_a.' 23:59:59';
					//$where = "fecha BETWEEN '$f_de' AND '$f_a'";

					$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM compras 
																WHERE fecha BETWEEN '{$f_de} ' AND '{$f_a}'
																AND usuario = $usuario ");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			//$por_pagina = 10;

			if(empty($_POST['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_POST['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_pagina = ceil($total_registro / $por_pagina);

				$query = mysqli_query($conection,"SELECT f.nocompra,f.fecha,f.totalcompra,f.codproveedor,f.status,
															u.nombre as vendedor,
															cl.proveedor as cliente
														FROM compras f
														INNER JOIN usuario u 
														ON f.usuario = u.idusuario
														INNER JOIN proveedor cl 
														ON f.codproveedor = cl.codproveedor
														 WHERE f.fecha BETWEEN '{$f_de} ' AND '{$f_a}'
														 AND f.usuario = $usuario
														 ORDER BY f.fecha DESC LIMIT $desde,$por_pagina");
				}
			}
				//Fin de la busqueda por rango de fecha
				
				$result = mysqli_num_rows($query);
				$lista = '';
				$detalleTabla = '';
				$arrayData    = array();

				$detalleTabla.='
								<table>
										<tr>
											<th>No.</th>
											<th>Fecha / Hora</th>
											<th>Proveedor</th>
											<th>Vendedor</th>
											<th>Estado</th>
											<th class="">Total Venta</th>
											<th class="textcenter">Acciones</th>
										</tr>';

				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)) {
						if ($data['status'] == 1) {
							$estatus = '<span class="pagada">Pagada</span>';
						}else if ($data['status'] == 2){
							$estatus = '<span class="anulada">Anulada</span>';
						}else{
							$estatus = '<span class="credito">Crédito</span>';
						}
						$totalventa= number_format($data["totalcompra"],2);
						$detalleTabla.='<tr id="row_'.$data['nocompra'].'">
							<td>'.$data["nocompra"].'</td>
							<td>'.$data["fecha"].'</td>
							<td>'.$data["cliente"].'</td>
							<td>'.$data["vendedor"].'</td>
							<td class="estado">'.$estatus.'</td>
							<td class="totalventa">'.$moned.' '.$totalventa.'</td>
							<td>
								<div class="div_acciones">
									<div>
										<a href class="btn_view view_ticket" title="Ver factura" onclick="event.preventDefault(); verFacturaCompra('.$data['codproveedor'].','.$data['nocompra'].');"><i class="fas fa-clipboard-list"></i></a>
									</div>';
								if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
								if ($data["status"] == 1 || $data['status'] == 3)
								 {
									$detalleTabla.= '<div class="div_factura">
										<a href="#" class="btn_anular anular_factura" title="Anular compra" onclick="event.preventDefault();
								                  infoAnularFacturaCompra('.$data['nocompra'].');"><i class="fas fa-ban"></i></a>
								    </div>';
								 }else{
										$detalleTabla.= '<div class="div_factura">
											<a href="#" class="btn_anular inactive"><i class="fas fa-ban"></i></a>
										</div></td></tr>';
									}
								}
				}
				$detalleTabla.='</table>';

				$lista.='<ul>';

				if ($pagina > 1) {
					$lista.= '<li><a href="1"><i class="fas fa-step-backward"></i></a></li>
				<li><a href="'.($pagina-1).'"><i class="fas fa-caret-left"></i></a></li>';
				}

			//muestro de los enlaces 
			//cantidad de link hacia atras y adelante
 			$cant = 2;
 			//inicio de donde se va a mostrar los links
			$pagInicio = ($pagina > $cant) ? ($pagina - $cant) : 1;
			//condicion en la cual establecemos el fin de los links
			if ($total_pagina > $cant)
			{
				//conocer los links que hay entre el seleccionado y el final
				$pagRestantes = $total_pagina - $pagina;
				//defino el fin de los links
				$pagFin = ($pagRestantes > $cant) ? ($pagina + $cant) :$total_pagina;
			}
			else 
			{
				$pagFin = $total_pagina;
			}

				for ($i=$pagInicio; $i <= $pagFin; $i++) 
				{ 

						if ($i == $pagina) 
						{
							$lista.= '<li class="pageSelected">'.$i.'</a></li>';	
						}else{
							$lista.= '<li><a href="'.$i.'">'.$i.'</a></li>';
						}
					}

				if ($pagina < $pagFin) {
					$lista.= '<li><a href="'.($pagina+1).'"><i class="fas fa-caret-right"></i></a></li>
				<li><a href="'.($total_pagina).'"><i class="fas fa-step-forward"></i></a></li>';
				}
				$lista.='</ul>';

				$arrayData['detalle'] = $detalleTabla;
				$arrayData['totales'] = $lista;

				echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);	               
			}else{
				echo 'error';
			}
			mysqli_close($conection);
		
		exit;
	   

			

	?>