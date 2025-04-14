<?php 

	include "../../conexion.php";
	session_start();

//print_r($_POST);exit;
	 //Extraer datos del detalle_temp

			$por_pagina = $_POST['cantidad'];

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

			//$por_pagina = 10;

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
										status = 1 ORDER BY idcliente DESC LIMIT $desde,$por_pagina ");
				}
				
				$result = mysqli_num_rows($query);
				$lista = '';
				$detalleTabla = '';
				$arrayData    = array();

				$detalleTabla.='
								<table>
									<tr>
										<th>Ced.</th>
										<th>Nombre</th>
										<th>Teléfono</th>
										<th>Dirección</th>';
					if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
						$detalleTabla.='<th>Acciones</th>';
						}
									

				if ($result > 0) {
				  
				while ($data = mysqli_fetch_assoc($query)){
					
					$detalleTabla .= '</tr><tr>
						                <td>'.$data['nit'].'</td>
						                <td colspan="">'.$data['nombre'].'</td>
						                <td class="">'.$data['telefono'].'</td>
						                <td class="">'.$data['direccion'].'</td>';
						     if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
					  $detalleTabla .= '<td class="">
							                <a class="link_edit" id="editarCliente" href="javascript:editarCliente('.$data['idcliente'].');"><i class="fas fa-edit"></i> Editar</a>	
											 | 
											 <a class="link_delete" id="eliminarCliente" href="javascript:infoEliminarCliente('.$data['idcliente'].');"><i class="fas fa-trash-alt"></i> Eliminar</a>
								                </td>
								             </tr>';
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