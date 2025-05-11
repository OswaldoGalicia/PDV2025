<?php 

	include "../../conexion.php";
	session_start();
	
	 //Extraer datos del detalle_temp
	//print_r($_POST);
		$query_conf = mysqli_query($conection,"SELECT moneda FROM configuracion");
		$result_conf = mysqli_num_rows($query_conf);
		$usuario = $_SESSION['idUser'];


				if ($result_conf > 0) {
					$info_conf = mysqli_fetch_assoc($query_conf);
					$moned = $info_conf['moneda'];
				}

			//$por_pagina = $_POST['cantidad'];

			$busqueda = mysqli_escape_string($conection,$_POST['busqueda']);
			//print_r($_POST);
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM venta 
																WHERE codcliente = $busqueda
																AND (status = 3 OR status = 4)");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];
			//print_r($total_registro);exit;
			$por_pagina = $total_registro;

			if(empty($_POST['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_POST['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_pagina = ceil($total_registro / $por_pagina);

				$query = mysqli_query($conection,"SELECT f.noventa,f.fecha,f.totalventa,f.codcliente,f.status,f.abono,
															u.nombre as vendedor,
															cl.nombre as cliente
														FROM venta f
														INNER JOIN usuario u 
														ON f.usuario = u.idusuario
														INNER JOIN cliente cl 
														ON f.codcliente = cl.idcliente
														 WHERE f.codcliente = $busqueda
														 AND (f.status = 3 OR f.status = 4)
														 ORDER BY f.fecha ASC LIMIT $desde,$por_pagina");

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

					$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM venta 
																WHERE fecha BETWEEN '{$f_de} ' AND '{$f_a}'
																AND codcliente = $busqueda AND (status = 3 OR status = 4)");
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

				$query = mysqli_query($conection,"SELECT f.noventa,f.fecha,f.totalventa,f.codcliente,f.status,f.abono,
															u.nombre as vendedor,
															cl.nombre as cliente
														FROM venta f
														INNER JOIN usuario u 
														ON f.usuario = u.idusuario
														INNER JOIN cliente cl 
														ON f.codcliente = cl.idcliente
														WHERE f.fecha BETWEEN '{$f_de} ' AND '{$f_a}'
														AND f.codcliente = $busqueda AND f.status BETWEEN 3 AND 4
														ORDER BY f.fecha ASC LIMIT $desde,$por_pagina");
				}
			


				//Fin de la busqueda por rango de fecha
				
				$result = mysqli_num_rows($query);
				$lista = '';
				$detalleTabla = '';
				$arrayData    = array();

				$detalleTabla.='
								<table class>
									<thead>
										<tr>
											<th>No.</th>
											<th>Fecha</th>
											<th>Cliente</th>
											<th>Vendedor</th>
											<th>Factura</th>
											<th>Abono</th>
											<th class="">Saldo total</th>
											<th>Estado</th>
											<th>Acciones</th>
										</tr>
									</thead>
									';

				if ($result > 0) {
					$saldo_total = 0;
					while ($data = mysqli_fetch_array($query)) {

						date_default_timezone_set("America/Managua");
						$fecha = date('d-m-Y',strtotime($data["fecha"]));
						
						$hoy = strtotime(date('d-m-Y'));

					if ($data["totalventa"] !=0) {
						$totalventa = $info_conf['moneda'].' '. number_format($data["totalventa"],2);
						$fecha_a_vencer = date('d-m-Y',strtotime($fecha. '+ 30 days'));
					}else{
							$totalventa = '';
							$fecha_a_vencer = '';
						}

						if ($data["abono"] != 0) {
							$abono = $info_conf['moneda'].' '. number_format($data["abono"],2);
						}else{
							$abono = '';
						}


						//$estado_cuenta = '';
						$saldo_total = $saldo_total + $data["totalventa"] - $data["abono"];
						//$saldo_fact = number_format($totalventa - $abono,2);
						

						$detalleTabla.='<tr id="row_'.$data['noventa'].'">
							<td>'.$data["noventa"].'</td>
							<td>'.$fecha.'</td>
							<td>'.$data["cliente"].'</td>
							<td>'.$data["vendedor"].'</td>
							<td>'.$totalventa.'</td>
							<td>'.$abono.'</td>
							<td>'.$info_conf['moneda'].' '.number_format($saldo_total,2).'</td>
							<td class="estado">'.$fecha_a_vencer.'</td>
							<td class="textcenter">
										<div class="div_acciones">';
										if ($totalventa != '') {
											$detalleTabla.='<div>
												<form action="" method="" class="form_cuentas_cobrar">
													<input type="hidden" name="" id="" placeholder="" value="">
													<button type="submit" class="btn_view" onclick="event.preventDefault(); verTicket('.$data['codcliente'].','.$data['noventa'].');"
											 		title="Ver factura"><i class="fa fa-clipboard-list fa-w-12"></i></button>
												</form>
											</div>';
										}else{
											$detalleTabla.='<div>
												<form action="" method="" class="form_cuentas_cobrar">
													<input type="hidden" name="" id="" placeholder="" value="">
													<button type="submit" class="btn_view" onclick="event.preventDefault(); verRecibo('.$data['codcliente'].','.$data['noventa'].');"
											 		title="Ver recibo"><i class="fa fa-clipboard-list fa-w-12"></i></button>
												</form>
											</div></td>';
										}							
							}
							$detalleTabla.='<tfoot id="detalle_totales">

							</tfoot>';
												
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