<?php 
 	session_start(); 

	header("Content-Type: Application/xls");
	header("Content-Disposition: attachment; filename= lista de productos.xls");
 ?>
		<table>
				<tr>
					<th>Fecha</th>
					<th>No. Compra</th>
					<th>Producto</th>
					<th>cantidad</th>
					<th>Precio</th>
				</tr>
 <?php

include "../conexion.php";

 $query_compra = mysqli_query($conection,"SELECT fecha,nocompra,codproducto,cantidad,precio FROM entradas");
				
				$result = mysqli_num_rows($query_compra);

				if ($result > 0) {
				  
				while ($data = mysqli_fetch_assoc($query_compra)){
	
				?>
				<tr>
						                <td colspan=""><?php echo $data['fecha'] ; ?></td>
						                <td class=""><?php echo $data['nocompra'] ; ?></td>
						                <td class=""><?php echo $data['codproducto']; ?></td>
						                <td><?php echo $data['cantidad']; ?></td>
						                <td class=""><?php echo $data['precio']; ?></td>
				</tr>

				<?php 
				}
			} 
		?>