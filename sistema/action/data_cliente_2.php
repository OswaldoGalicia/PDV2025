<?php 

	include "../../conexion.php";
	//include "../js/functions.js";
	session_start();

//print_r($_POST);exit;
	 //Extraer datos del detalle_temp
	   	$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM cliente WHERE status = 1 ");
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

				$query = mysqli_query($conection,"SELECT * FROM cliente
														 WHERE status = 1 ORDER BY idcliente ASC LIMIT $desde,$por_pagina ");
			//Buscador en tirmpo real
			if (isset($_POST['busqueda'])) {
					$busqueda = mysqli_escape_string($conection,$_POST['busqueda']);

					$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM cliente 
																WHERE (
																		nit LIKE '%$busqueda%' OR 
																		nombre LIKE '%$busqueda%') 
																AND status = 1 ");
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

				$query = mysqli_query($conection,"SELECT * FROM cliente WHERE
										(
											nit LIKE '%$busqueda%' OR 
											nombre LIKE '%$busqueda%'
											 ) 
											AND
										status = 1 ORDER BY idcliente ASC LIMIT $desde,$por_pagina ");


				}
				
				$result = mysqli_num_rows($query);
				$lista = '';
				$detalleTabla = '';
				$arrayData    = array();

				$detalleTabla.='
								<table>
									<tr>
										<th>CI</th>
										<th>Nombre</th>
										<th>Teléfono</th>
										<th>Dirección</th>
										<th>Acciones</th>
									</tr>';

				if ($result > 0) {
				  
				while ($data = mysqli_fetch_assoc($query)){
					
					$detalleTabla .= '<tr>
										<td style="display:none;">'.$data['idcliente'].'</td>
						                <td>'.$data['nit'].'</td>
						                <td colspan="">'.$data['nombre'].'</td>
						                <td class="">'.$data['telefono'].'</td>
						                <td class="">'.$data['direccion'].'</td>
						                <td class="">
							                 <a class="link_edit" id="" href="#" onclick="event.preventDefault(); agregarCliente('.$data['idcliente'].');"><i class="fas fa-plus"></i></a>
						                </td>
						             </tr>';
				}
				$detalleTabla.='</table>';

				$lista.='<ul>';

				if ($pagina > 1) {
					$lista.= '<li><a href="javascript:serchForDetalleCli();"><i class="fas fa-step-backward"></i></a></li>
				<li><a href="javascript:serchForDetalleCli('.($pagina-1).');"><i class="fas fa-caret-left"></i></a></li>';
				}

				for ($i=1; $i <= $total_pagina; $i++) { 

						if ($i == $pagina) 
						{
							$lista.= '<li class="pageSelected">'.$i.'</a></li>';	
						}else{
							$lista.= '<li><a href="javascript:serchForDetalleCli('.$i.');">'.$i.'</a></li>';
						}
					}

				if ($pagina < $total_pagina) {
					$lista.= '<li><a href="javascript:serchForDetalleCli('.($pagina+1).');"><i class="fas fa-caret-right"></i></a></li>
				<li><a href="javascript:serchForDetalleCli('.($pagina=$total_pagina).');"><i class="fas fa-step-forward"></i></a></li>';
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