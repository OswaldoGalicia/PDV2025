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

		if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 ){
			$busqueda = mysqli_escape_string($conection,$_POST['busqueda']);
			//print_r($_POST);
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM 																detalle_recibo_compra WHERE 															nocompra = $busqueda");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];
			//print_r($total_registro);
			$por_pagina = 10;

			if(empty($_POST['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_POST['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_pagina = ceil($total_registro / $por_pagina);

			$query_venta = mysqli_query($conection,"SELECT codproveedor FROM compras WHERE nocompra = $busqueda");
			$result_venta = mysqli_num_rows($query_venta);
			if ($result_venta > 0) {
				$info_venta = mysqli_fetch_assoc($query_venta);
			}


				//$query = mysqli_query($conection,"SELECT * FROM detalle_recibo_compra WHERE nocompra = $busqueda");
				$query = mysqli_query($conection,"SELECT det.id,det.nocompra,det.fecha,u.nombre,det.saldo_anterior,det.cantidad,det.saldo_actual 
																FROM detalle_recibo_compra det
																INNER JOIN usuario u
																ON det.usuario = u.idusuario
																WHERE nocompra = $busqueda");

				//Busqueda por rango de fecha
				/*if (isset($_POST['fecha_de']) && isset($_POST['fecha_a'])){
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

					$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM detalle_recibo 
																WHERE fecha BETWEEN '{$f_de} ' AND '{$f_a}'
																AND noventa = $busqueda");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			$por_pagina = 10;

			if(empty($_POST['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_POST['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_pagina = ceil($total_registro / $por_pagina);

				$query = mysqli_query($conection,"SELECT * FROM detalle_recibo
													WHERE fecha BETWEEN '{$f_de} ' AND '{$f_a}'
														AND noventa = $busqueda 
														ORDER BY f.fecha ASC LIMIT $desde,$por_pagina");
				}*/
			}


				//Fin de la busqueda por rango de fecha
				
				$result = mysqli_num_rows($query);
				//print_r($result);
				$lista = '';
				$detalleTabla = '';
				$arrayData    = array();

				$detalleTabla.='
								<table class>
									<thead>
										<tr>
											<th style="display:none;">Id</th>
											<th>No. Compra</th>
											<th>Fecha</th>
											<th>Usuario</th>
											<th>Saldo anterios</th>
											<th>Abono</th>
											<th>Saldo actual</th>
										</tr>
									</thead>
									';

				if ($result > 0) {
					$saldo_total = 0;
					while ($data = mysqli_fetch_array($query)) {
						date_default_timezone_set("America/Managua");
						$fecha = date('d-m-Y',strtotime($data["fecha"]));						

						$detalleTabla.='<tr id="row_'.$data['id'].'">
							<td style="display:none;">'.$data["id"].'</td>
							<td>'.$data['nocompra'].'</td>
							<td>'.$fecha.'</td>
							<td>'.$data['nombre'].'</td>
							<td>'.$moned.' '.number_format($data['saldo_anterior'],2).'</td>
							<td>'.$moned.' '.number_format($data['cantidad'],2).'</td>
							<td>'.$moned.' '.number_format($data['saldo_actual'],2).'</td>';
							/*<td class="textcenter">
										<div class="div_acciones">
											<div>
												<form action="" method="" class="form_cuentas_cobrar">
													<input type="hidden" name="" id="" placeholder="" value="">
													<button type="submit" class="btn_view" onclick="event.preventDefault(); verRecibo('.$info_venta['codcliente'].','.$data['id'].');"
											 		title="Reimprimir"><i class="fa fa-clipboard-list fa-w-12"></i></button>
												</form>
											</div>
							</td>
							';*/
							}
												
				$detalleTabla.='</table>';

				$lista.='<ul>';

				if ($pagina > 1) {
					$lista.= '<li><a href="javascript:listaRecibos_proveedor();"><i class="fas fa-step-backward"></i></a></li>
				<li><a href="javascript:listaRecibos_proveedor('.($pagina-1).');"><i class="fas fa-caret-left"></i></a></li>';
				}
				//for($i=max(1, min($pagina-3,$total_pagina-7)); $i < max(8, min($pagina+4,$total_pagina+1)); $i++)
				for ($i=1; $i <= $total_pagina; $i++) 
				{ 

						if ($i == $pagina) 
						{
							$lista.= '<li class="pageSelected">'.$i.'</a></li>';	
						}else{
							$lista.= '<li><a href="javascript:listaRecibos_proveedor('.$i.');">'.$i.'</a></li>';
						}
					}

				if ($pagina < $total_pagina) {
					$lista.= '<li><a href="javascript:listaRecibos_proveedor('.($pagina+1).');"><i class="fas fa-caret-right"></i></a></li>
				<li><a href="javascript:listaRecibos_proveedor('.($pagina=$total_pagina).');"><i class="fas fa-step-forward"></i></a></li>';
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