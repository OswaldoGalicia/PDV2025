<?php 

	include "../../conexion.php";
	session_start();
	//print_r($_POST);exit;

	 //Extraer datos del detalle_temp
		$query_conf = mysqli_query($conection,"SELECT moneda FROM configuracion");
		$result_conf = mysqli_num_rows($query_conf);

				if ($result_conf > 0) {
					$info_conf = mysqli_fetch_assoc($query_conf);
					$moned = $info_conf['moneda'];
				}

		$por_pagina = $_POST['cantidad'];

			//Buscador en tiempo real
			if (isset($_POST['busqueda'])) {

					$busqueda = mysqli_escape_string($conection,$_POST['busqueda']);

					$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM producto 
																WHERE (
																		codigo LIKE '%$busqueda%' OR
																		descripcion LIKE '%$busqueda%' OR 
																		proveedor LIKE '%$busqueda%'
											 						   ) 
																AND status != 10 ");
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

				$query = mysqli_query($conection,"SELECT p.codproducto, p.codigo, p.descripcion,p.costo, p.precio, p.existencia, pr.proveedor, p.foto, p.status FROM producto p
						INNER JOIN proveedor pr
						ON p.proveedor = pr.codproveedor
						WHERE (p.codigo LIKE '%$busqueda%' OR
						p.descripcion LIKE '%$busqueda%' OR 
						pr.proveedor LIKE '%$busqueda%')
						AND p.status != 10 ORDER BY p.codproducto DESC LIMIT $desde,$por_pagina ");
				}
				
				$result = mysqli_num_rows($query);
				$lista = '';
				$tabla = '';
				$arrayData    = array();

				$tabla.='<table>
									<tr>
										<th style="display:none;">ID</th>
										<th>Código</th>
										<th>Descripción</th>
										<th>Existencia</th>
										<th>Costo</th>
										<th>Precio</th>
										<th>Proveedor</th>
										<th>Foto</th>';
				if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 ) {
							   $tabla.='<th>Acciones</th>';
									}

				if ($result > 0) {
				  
				while ($data = mysqli_fetch_assoc($query)){
					if ($data['foto'] != 'img_producto.png') {
							$foto = './img/uploads/'.$data['foto'];
						}else{
							$foto = './img/'.$data['foto'];
						}
						$costo = number_format($data['costo'],2);
						$precio = number_format($data['precio'],2);

					if ($data['status'] != 0) {
						$tabla .= '</tr><tr>
						                <td style="display:none;">'.$data['codproducto'].'</td>
						                <td>'.$data['codigo'].'</td>
						                <td colspan="">'.$data['descripcion'].'</td>
						                <td class="">'.$data['existencia'].'</td>
						                <td class="">'.$moned.' '.$costo.'</td>
						                <td class="">'.$moned.' '.$precio.'</td>
						                <td class="">'.$data['proveedor'].'</td>
						                <td class="img_producto"><img src="'.$foto.'" alt="'.$data['descripcion'].'"></td>';
						if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 ) {					
					$tabla.='<td class=""> <!--<a class="link_add add_product" href="#" onclick="event.preventDefault();
							      		agregarProd('.$data['codigo'].');"><i class="fas fa-plus" ></i> Agregar</a>
										|-->
										<a class="link_edit" href="#" onclick="event.preventDefault(); editarProducto('.$data['codproducto'].');"><i class="fas fa-edit"></i> Editar</a>
										|	
										<a class="link_delete del_product"  href="#" onclick="event.preventDefault(); infoEliminarProducto('.$data['codproducto'].');"><i class="fa fa-ban fa-w-16"></i> Desactivar</a>';	                
					}

					}else{
						$tabla .= '<tr style="color:grey;">
						                <td style="display:none;">'.$data['codproducto'].'</td>
						                <td>'.$data['codigo'].'</td>
						                <td colspan="">'.$data['descripcion'].'</td>
						                <td class="">'.$data['existencia'].'</td>
						                <td class="">'.$moned.' '.$precio.'</td>
						                <td class="">'.$data['proveedor'].'</td>
						                <td class="img_producto"><img src="'.$foto.'" alt="'.$data['descripcion'].'"></td>';
					if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 ){
						$tabla .= '<td class=""><a class="link_delete del_product" style="color:grey;"  ><i class="fa fa-ban fa-w-16"></i> Desactivado</a>
						                |
						                <a class="link_add del_product"  href="#" onclick="event.preventDefault(); infoActivarProducto('.$data['codproducto'].');"><i class="fas fa-plus"></i> Activar</a></td></tr>';}	                
						     
					}
						
				}

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

				$arrayData['detalle'] = $tabla;
				$arrayData['totales'] = $lista;

				echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);	               
			}else{
				echo 'error';
			}
			mysqli_close($conection);
		
		exit;
	   

			

	?>