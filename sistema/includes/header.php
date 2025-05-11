<?php 
	
	if(empty($_SESSION['active']))
	{
		header('location: ../');
	}
?>
<header>
		<div class="header">
			<a href="#" class="btnMenu"><i class="fas fa-bars"></i></a>
			<h1>Sistema De Ventas</h1>
			<div class="optionsBar">
				<p><?php echo fechaC(); ?></p>
				<span>|</span>
				<span class="user"><?php echo $_SESSION['user'].'-'.$_SESSION['rol']; ?></span>
				<!--<img class="photouser" src="img/user.png" alt="Usuario">-->
				<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
		<?php include "nav.php";?>
</header>
	<div class="modal">
		<div class="bodyModal">			
		</div>
	</div>

	<div class="modalBuscarCl">
		<div class="bodyModalBuscarCl">
			<section id="container_modal">
				<h1><i class="fas fa-users"></i> Lista de cliente</h1>
				<br>
									<form action="" method="post" class="form_search_modalCl">
										<input type="text" name="consulta" id="busquedaCli" placeholder="Buscar">
									</form>
									<a href="#" class="cerrarModalCl" onclick="coloseModal();">Aceptar</a>
		 		<div class="containerTable" id="dataCliente"></div>
		 		<div class="paginador" id="paginadorCliente"></div>
		 	</section>			
		</div>
	</div>

	<!--<div class="modalBuscarPr">
		<div class="bodyModalBuscarPr">
			<section id="container_modal">
				<h1><i class="fas fa-users"></i> Lista de productos</h1>
				<br>
									<form action="" method="post" class="form_search_modalCl">
										<input type="text" name="busquedaProd" id="busquedaProd" placeholder="Buscar">
									</form>
									<a href="#" class="cerrarModalCl" onclick="coloseModal();">Aceptar</a>
		 		<div class="containerTable" id="dataProd"></div>
		 		<div class="paginador" id="paginadorProd"></div>
		 	</section>		
		</div>
	</div>-->

	<!--<div class="modalBuscarPrCompra">
		<div class="bodyModalBuscarPrCompra">
			<section id="container_modal">
				<h1><i class="fas fa-users"></i> Lista de productos</h1>
				<br>
									<form action="" method="post" class="form_search_modalCl">
										<input type="text" name="busquedaProdCompra" id="busquedaProdCompra" placeholder="Buscar">
									</form>
									<a href="#" class="cerrarModalCl" onclick="coloseModal();">Aceptar</a>
		 		<div class="containerTable" id="dataProdCompra"></div>
		 		<div class="paginador" id="paginadorProdCompra"></div>
		 	</section>		
		</div>
	</div>-->

	

	
	
	