<nav>
			<ul>
				<li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
				<?php 
				if ($_SESSION['rol'] == 1) {
				
				?>
				<li class="principal">
					<a href="#"><i class="fas fa-user"></i> Usuarios</a>
					<ul>
						<li><a href="lista_usuarios.php"><i class="fas fa-users"></i> Lista de usuarios</a></li>
					</ul>
				</li>
			<?php  } ?>
				<li class="principal">
					<a href="#"><i class="fas fa-users"></i> Clientes</a>
					<ul>
						<li><a href="lista_cliente.php"><i class="fas fa-users"></i> Lista de clientes</a></li>
						<li><a href="cuentas_por_cobrar.php"><i class="far fa-money-bill-alt"></i> Cuentas por cobrar</a></li>
					</ul>
				</li>
				<?php 
				if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
				
				?>
				<li class="principal">
					<a href="#"><i class="far fa-building"></i> Proveedores</a>
					<ul>
						<li><a href="lista_proveedor.php"><i class="far fa-building"></i> Lista de proveedores</a></li>
						<li><a href="cuentas_por_pagar.php"><i class="fas fa-dollar-sign"></i> Cuentas por pagar</a></li>
					</ul>
				</li>
				<?php  } ?>

				
				<li class="principal">
					<a href="#"><i class="fas fa-cubes"></i> Productos</a>
					<ul>
						<li><a href="lista_producto.php"><i class="fas fa-cubes"></i> Lista de productos</a></li>
						<?php 
				if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
				
				?>
						<li><a href="reabastecer_producto.php"><i class="fas fa-cart-plus"></i> Reabastecer</a></li>
						<li><a href="compras.php"><i class="far fa-file-alt fa-w-12"></i> Compras</a></li>
						<?php  } ?>
					</ul>				
				</li>
			

				<li class="principal">
					<a href="#"><i class="far fa-file-alt"></i> Ventas</a>
					<ul>
						<li><a href="ventas.php"><i class="far fa-file-alt"></i> Venta</a></li>
						<li><a href="nueva_venta.php"><i class="fas fa-plus"></i> Nueva Venta</a></li>
					</ul>
				</li>


				<li class="principal">
					<a href="#"><i class="fas fa-plus"></i></i> Otros</a>
					<ul>
						<li><a href="lista_egresos.php"><i class="fas fa-dollar-sign"></i> Egresos</a></li>
						<li><a href="lista_caja.php"><i class="far fa-money-bill-alt"></i> Caja</a></li>
				<?php 
				if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
				
				?>
						<li><a href="#" id="estado_resultado"><i class="far fa-file-alt"></i> Estado de R.</a></li>
						<?php  } ?>
						<li><a href="configuracion.php"><i class="fas fa-cog"></i> Configuración</a></li>
					</ul>
				</li>

			</ul>
		</nav>