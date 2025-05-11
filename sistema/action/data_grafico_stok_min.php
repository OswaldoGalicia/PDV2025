<?php 

	include "../../conexion.php";
	session_start();

//print_r($_POST);exit;
	 //Extraer datos del detalle_temp


				$query = mysqli_query($conection,"SELECT * FROM producto WHERE existencia < 2 AND status = 1 LIMIT 15");
				$result = mysqli_num_rows($query);

				$arreglo = array();
				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)){
						$arreglo[] = $data;
					}
					echo json_encode($arreglo,JSON_UNESCAPED_UNICODE);					
				}
	   			

	?>