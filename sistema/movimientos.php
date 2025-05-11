<?php
session_start(); 

include "../conexion.php";
if (isset($_REQUEST['busqueda'])){
	$cliente = $_REQUEST['busqueda'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"?>
	<title>Estado de cuenta cliente</title>
</head>
<body>
	<?php include "includes/header.php"?>
	<section id="container">

		<h1><i class="far fa-newspaper"></i> Estado de cuenta cliente</h1>
		
			<input type="hidden" name="busquedaMov" id="busquedaMov" placeholder="Buscar" value="<?php echo $cliente ?>">
		
		<div>
			<h5>Buscar por fecha</h5>
			<form action="" method="post" class="form_search_date" id="rango">
				<label>De:</label>
				<input type="date" name="fecha_de_mov" id="fecha_de_mov" required>
				<label>A</label>
				<input type="date" name="fecha_a_mov" id="fecha_a_mov" required>
				<button type="submit" class="btn_view btn_rango_fecha_mov"><i class="fas fa-search"></i></button>
				<a href="#" class="btn_view" id="reporte_pdf_mov">Generar reporte PDF</a>
			
		</div>
		<!--<div style="width: 120px; margin-bottom: 5px">
						
						<p>
							<strong>Mostrar por : </strong>
							<select name="cantidad_mostrar_movcobrar" id="cantidad_mostrar_movcobrar">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</p>

					</div>-->
		<div class="containerTable" id="listaMovimientos">
			<!--CONTENIDO AJAX-->
		</div>
		<div class="paginador" id="paginadorMovimientos">
			<!--CONTENIDO AJAX-->
		</div>
	</section>

		<?php include "includes/footer.php"?>

</body>
<script type="text/javascript">
	listaMovimientos(<?php echo $cliente ?>,1,10);

	$("body").on("click","#paginadorMovimientos li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = <?php echo $cliente ?>;
        valoroption = $("#cantidad_mostrar_movcobrar").val();
        //console.log(valorhref);
        listaMovimientos(valorBuscar,valorhref,valoroption);
    });

    $("#cantidad_mostrar_movcobrar").change(function(){
        valoroption = $(this).val();
        //console.log(valoroption);
        valorBuscar = <?php echo $cliente ?>;
        //console.log(valorBuscar);
        listaMovimientos(valorBuscar,1,valoroption);
    });
</script>
</html>