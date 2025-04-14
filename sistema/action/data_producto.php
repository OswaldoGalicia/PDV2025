<?php 

	include "../../conexion.php";
	session_start();

	 //Extraer datos del detalle_temp
		$query_conf = mysqli_query($conection,"SELECT moneda FROM configuracion");
		$result_conf = mysqli_num_rows($query_conf);

				if ($result_conf > 0) {
					$info_conf = mysqli_fetch_assoc($query_conf);
					$moned = $info_conf['moneda'];
				}

				$por_pagina = 9;
			//Buscador en tiempo real
			if (isset($_POST['busquedaProd'])) {

					$busqueda = mysqli_escape_string($conection,$_POST['busquedaProd']);

					$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM producto 
																WHERE (
																		codigo LIKE '%$busqueda%' OR 
																		descripcion LIKE '%$busqueda%') 
																AND status = 1 ");
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

				$query = mysqli_query($conection,"SELECT * FROM producto WHERE
										(
											codigo LIKE '%$busqueda%' OR 
											descripcion LIKE '%$busqueda%'
											 ) 
											AND
										status = 1 ORDER BY descripcion ASC LIMIT $desde,$por_pagina ");


				}
				
				$result = mysqli_num_rows($query);
				$lista = '';
				$tabla = '';
				$arrayData    = array();

				if ($result > 0) {
				  $tabla .= '<div class="divContainer">
				  				<div class="dashboardventa">';
				while ($data = mysqli_fetch_assoc($query)){
					if ($data['foto'] != 'img_producto.png') {
							$foto = './img/uploads/'.$data['foto'];
						}else{
							$foto = './img/'.$data['foto'];
						}
						$precio = $data['precio'];

					$tabla .= '<a href="#" onclick="event.preventDefault(); infoProductAgregar('.$data['codproducto'].');" ><table class="table_venta">
												<tr style="background:none; color: black;">
													<td>'.$data['codigo'].'</td>
													<td class="textright">'.$data['descripcion'].'</td>
												</tr>
												<tr style="background:none; color: black;">
													<td rowspan="2" class="img_producto_venta"><img src="'.$foto.'"</td>
													<td class="textright" id="existencia_2'.$data['codproducto'].'">'.$data['existencia'].'</td>
												</tr>
												<tr style="background:none; color: black;">
													<td class="textright" id="txt_precio_2'.$data['codproducto'].'">'.$data['precio'].'</td>
												</tr>
											</table>										
								</a>';
				}

				$lista.='</div></div><ul>';

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
	<!--<td>'.$data['codigo'].'</td>
						                <td colspan="">'.$data['descripcion'].'</td>
						                <td class=""><input class="textright" type="number" style="width:70px;" id="existencia_2'.$data['codproducto'].'"value="'.$data['existencia'].'" disabled></td>
						                <td class=""><input  step="any" class="textright" type="number" style="width:100px;" id="txt_precio_2'.$data['codproducto'].'"value="'.$precio.'"></td>
						                <td class="img_producto"><img src="'.$foto.'" alt="'.$data['descripcion'].'"></td>
						                <td class=""><input class="textright" step="any" style="width:70px;" type="number" name="txt_cant_producto_2'.$data['codproducto'].'" id="txt_cant_producto_2'.$data['codproducto'].'" value="1" min"1"></td>
						                <td class="">
							                <a class="link_edit" id="add_product_venta_2" href="#" onclick="event.preventDefault(); agregarProducto('.$data['codproducto'].');"><i class="fas fa-plus"></i></a></td>-->