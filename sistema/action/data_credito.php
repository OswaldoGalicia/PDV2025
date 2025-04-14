<?php 

	include "../../conexion.php";
	session_start();
	//print_r($_POST);exit;
	 //Extraer datos del detalle_temp
		$query_conf = mysqli_query($conection,"SELECT moneda FROM configuracion");
		$result_conf = mysqli_num_rows($query_conf);
		$usuario = $_SESSION['idUser'];


				if ($result_conf > 0) {
					$info_conf = mysqli_fetch_assoc($query_conf);
					$moned = $info_conf['moneda'];
				}
			
			//Buscador en tirmpo real
			if (isset($_POST['busqueda'])) {
					$busqueda = mysqli_escape_string($conection,$_POST['busqueda']);

					$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM cliente
															WHERE (						   
																   nombre LIKE '%$busqueda%'
																   ) 
																AND status = 1 ");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];
			$por_pagina = $total_registro;

			if(empty($_POST['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_POST['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_pagina = ceil($total_registro / $por_pagina);

				$query = mysqli_query($conection,"SELECT f.noventa,MAX(f.fecha) as fecha ,SUM(f.totalventa) as totalventa,f.codcliente,f.status,SUM(f.abono) as abono,
															u.nombre as vendedor,
															cl.nombre as cliente
														FROM venta f
														INNER JOIN usuario u 
														ON f.usuario = u.idusuario
														INNER JOIN cliente cl 
														ON f.codcliente = cl.idcliente
														 WHERE (
																f.noventa LIKE '%$busqueda%' OR
																cl.nombre LIKE '%$busqueda%' OR
																u.nombre LIKE '%$busqueda%' OR
																f.fecha LIKE '%$busqueda%')
														 AND (f.status = 3 OR f.status = 4)
														 GROUP BY f.codcliente
														 ORDER BY MAX(f.fecha) DESC LIMIT $desde,$por_pagina");
				}
				
				$result = mysqli_num_rows($query);
				$lista = '';
				$detalleTabla = '';
				$arrayData    = array();

				$detalleTabla.='
								<table>
										<tr>
											<th>No.</th>
											<th>Fecha</th>
											<th>Cliente</th>
											<th>Vendedor</th>
											<th class="">Total Factura</th>
											<th>Estado</th>
											<th class="textcenter">Acciones</th>
										</tr>';

				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)) {

						date_default_timezone_set("America/Managua");
						$fecha = date('d-m-Y',strtotime($data["fecha"]));
						$fecha_a_vencer = date('d-m-Y',strtotime($fecha. '+ 30 days'));
						$hoy = strtotime(date('d-m-Y'));
						$estado_cuenta = '';

						if (strtotime($fecha_a_vencer) >= $hoy) {
							$estado_cuenta = $fecha_a_vencer;
						}else{
							$estado_cuenta = '<span class="anulada">Vencido</span>';
						}

						$totalventa= $data["totalventa"] - $data['abono'];

						if ($totalventa == 0) {
							$estado_cuenta = '';
							$saldo = '-';
						}else{
							$saldo = $moned.' '.number_format($totalventa,2);
						}
						
						$detalleTabla.='<tr id="row_'.$data['noventa'].'">
							<td>'.$data["noventa"].'</td>
							<td>'.$fecha.'</td>
							<td>'.$data["cliente"].'</td>
							<td>'.$data["vendedor"].'</td>
							<td class="textright">'.$saldo.'</td>
							<td class="estado">'.$estado_cuenta.'</td>
							<td>
								<div class="div_acciones">
									<div>
										<form action="movimientos.php" method="get" class="form_cuentas_cobrar">
											<input type="hidden" name="busqueda" id="busqueda" placeholder="No. Factura" value="'.$data["codcliente"].'">
											<button type="submit" class="btn_view" title="Ver movimientos"><i class="fas fa-eye"></i></button>
										</form>
									</div>
									<div>
												<form action="" method="" class="form_cuentas_cobrar">
													<input type="hidden" name="" id="" placeholder="" value="">
													<button type="submit" class="btn_view" onclick="event.preventDefault(); add_abono_cliente('.$data['codcliente'].','.$data['noventa'].');"
											 		title="Pagar"><i class="fa fa-money-bill-alt fa-w-20"></i></button>
												</form>
											</div>';
											
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