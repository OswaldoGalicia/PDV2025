<?php 
 	session_start(); 

	header("Content-Type: Application/xls");
	header("Content-Disposition: attachment; filename= lista de productos.xls");
 ?>
		<table>
				<tr>
					<th>Código</th>
					<th>Descripción</th>
					<th>Existencia</th>
					<th>Costo</th>
					<th>Precio</th>
					<th>Proveedor</th>
				</tr>
 <?php

include "../conexion.php";

 $query = mysqli_query($conection,"SELECT p.codproducto, p.codigo, p.descripcion,p.costo, p.precio, p.existencia, pr.proveedor, p.status FROM producto p
						INNER JOIN proveedor pr
						ON p.proveedor = pr.codproveedor
						WHERE p.status = 1 ORDER BY p.codproducto");
				
				$result = mysqli_num_rows($query);

				if ($result > 0) {
				  
				while ($data = mysqli_fetch_assoc($query)){
	
				?>
				<tr>
						                <td><?php echo $data['codigo']; ?></td>
						                <td colspan=""><?php echo $data['descripcion'] ; ?></td>
						                <td class=""><?php echo $data['existencia'] ; ?></td>
						                <td class=""><?php echo $data['costo']; ?></td>
						                <td class=""><?php echo $data['precio']; ?></td>
						                <td class=""><?php echo $data['proveedor'] ; ?></td>
				</tr>

				<?php 
				}
			} 
		?>