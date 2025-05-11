<?php
session_start(); 

include "../conexion.php";
if (isset($_REQUEST['busqueda'])){
	$proveedor = $_REQUEST['busqueda'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>Estado de cuenta proveedor</title>
</head>
<body>
	<?php include "includes/header.php"?>
	<section id="container">

		<h1><i class="far fa-newspaper"></i> Estado de cuenta proveedor</h1>
		
			<input type="hidden" name="busquedaMov_proveedor" id="busquedaMov_proveedor" placeholder="Buscar" value="<?php echo $proveedor ?>">
		
		<div>
			<h5>Buscar por fecha</h5>
			<form action="" method="post" class="form_search_date" id="rango">
				<label>De:</label>
				<input type="date" name="fecha_de_mov_pagar" id="fecha_de_mov_pagar" required>
				<label>A</label>
				<input type="date" name="fecha_a_mov_pagar" id="fecha_a_mov_pagar" required>
				<button type="submit" class="btn_view btn_rango_fecha_mov_pagar"><i class="fas fa-search"></i></button>
				<a href="#" class="btn_view" id="reporte_pdf_mov_pagar">Generar reporte PDF</a>			
		</div>
		<!--<div style="width: 120px; margin-bottom: 5px">						
						<p>
							<strong>Mostrar por : </strong>
							<select name="cantidad_mostrar_movpagar" id="cantidad_mostrar_movpagar">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</p>
			</div>-->
		<div class="containerTable" id="listaMov_proveedor">
			<!--CONTENIDO AJAX-->
		</div>
		<div class="paginador" id="paginadorMov_proveedor">
			<!--CONTENIDO AJAX-->
		</div>
	</section>

		<?php include "includes/footer.php"?>

</body>
<script type="text/javascript">
	lista_Mov_proveedor(<?php echo $proveedor ?>,1,10);

	$("body").on("click","#paginadorMov_proveedor li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = <?php echo $proveedor ?>;
        valoroption = $("#cantidad_mostrar_movpagar").val();
        //console.log(valorhref);
        lista_Mov_proveedor(valorBuscar,valorhref,valoroption);
    });

    $("#cantidad_mostrar_movpagar").change(function(){
        valoroption = $(this).val();
        //console.log(valoroption);
        valorBuscar = <?php echo $proveedor ?>;
        //console.log(valorBuscar);
        lista_Mov_proveedor(valorBuscar,1,valoroption);
    });
</script>
</html>