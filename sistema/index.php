<?php 

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Sisteme Ventas</title>
</head>
<body>
	<?php 

		include "includes/header.php";
		include "../conexion.php";

		//Datos empresa
		$nit = '';
		$nombreEmpresa = '';
		$razonSocial = '';
		$telEmpresa = '';
		$emailEmpresa = '';
		$dirEmpresa = '';
		$iva = '';
		$usuario_id = $_SESSION['idUser'];

		$query_empresa = mysqli_query($conection,"SELECT * FROM configuracion");
		$row_empesa = mysqli_num_rows($query_empresa);
		if ($row_empesa > 0) 
		{
			while ($arrInfoEmpresa = mysqli_fetch_assoc($query_empresa)) {
				$nit = $arrInfoEmpresa['nit'];
				$nombreEmpresa = $arrInfoEmpresa['nombre'];
				$razonSocial = $arrInfoEmpresa['razon_social'];
				$telEmpresa = $arrInfoEmpresa['telefono'];
				$emailEmpresa = $arrInfoEmpresa['email'];
				$dirEmpresa = $arrInfoEmpresa['direccion'];
				$iva = $arrInfoEmpresa['iva'];
				$foto1 = $arrInfoEmpresa['foto'];
				$moned = $arrInfoEmpresa['moneda'];
			}
			$foto = '';
			$classRemove = 'notBlock';

			if ($foto1 != '') {
				$classRemove = '';
				$foto = '<img id="img" src="factura/img/'.$foto1.'" alt="Producto">';
			}
		}

			$inicio 	= ' 0.00';
			$ventas 	= ' 0.00';
			$abonos 	= ' 0.00';
			$creditos 	= ' 0.00';
			$egreso 	= ' 0.00';
			$total 		= ' 0.00';

		//$query = mysqli_query($conection,"SELECT * FROM caja WHERE usuario = $user AND status = 1");
		$query_caja = mysqli_query($conection,"SELECT * FROM caja WHERE status = 1");
		$result_caja = mysqli_num_rows($query_caja);
		if ($result_caja > 0) {
			 		$data_caja = mysqli_fetch_assoc($query_caja);
			 		$id_caja = $data_caja['id'];
			 		$query_dash = mysqli_query($conection,"CALL dataDashboard($id_caja);");
			 		$result_das = mysqli_num_rows($query_dash);
				if ($result_das > 0) {
					$data_dash = mysqli_fetch_assoc($query_dash);
					$inicio = $data_dash['inicios'];
					$ventas = $data_dash['ventas'];
					$abonos = $data_dash['abonos'];
					$creditos = $data_dash['credito'];
					$egreso = $data_dash['egreso'];
					$total = $inicio + $ventas + $abonos - $egreso;
					mysqli_close($conection);
				}
				if ($inicio == 0) {
					$inicio = '0.00';
				}
				if ($ventas == 0) {
					$ventas = '0.00';
				}
				if ($abonos == 0) {
					$abonos = '0.00';
				}
				if ($creditos == 0) {
					$creditos = '0.00';
				}
				if ($egreso == 0) {
					$egreso = '0.00';
				}
			 		}

		
		
	?>
	<section id="container">
		<div class="divContainer">
			<div>
				<h1 class="titlePanelControl">Panel de control</h1>
			</div>
			<div class="dashboard">

				<a href="#">
					<i class="fas fa-money-bill-alt"></i>
					<p>
						<strong>Inicio</strong><br>
						<strong><?= $moned.' '.$inicio; ?></strong>
					</p>
				</a>
				<a href="ventas.php">
					<i class="fas fa-shopping-cart"></i>
					<p>
						<strong>Ventas</strong><br>
						<strong><?= $moned.' '.$ventas; ?></strong>
					</p>

				</a>

				<a href="#">
					<i class="far fa-money-bill-alt"></i>
					<p>
						<strong>Abonos</strong><br>
						<strong><?= $moned.' '.$abonos; ?></strong>
					</p>

				</a>
				<a href="#">
					<i class="far fa-credit-card"></i>
					<p>
						<strong>Créditos</strong><br>
						<strong><?= $moned.' '.$creditos; ?></strong>
					</p>
				</a>
				<a href="#">
					<i class="fas fa-dollar-sign"></i>
					<p>
						<strong>Gastos</strong><br>
						<strong><?= $moned.' '.$egreso; ?></strong>
					</p>
				</a>
				<a href="#">
					<i class="fas fa-money-bill-alt"></i>
					<p>
						<strong>Total cierre</strong><br>
						<strong><?= $moned.' '.$total; ?></strong>
					</p>
				</a>
			</div>
		</div>

		<div class="divInfoSistema">
			<div>
				<h1 class="titlePanelControl">Reporte gráfico de movimientos de productos</h1>
			</div>
			<div class="containerPerfil">
				
				<div class="containerDataUser">
					<h1 class="titlePanelControl">Productos más vendidos del mes</h1>
					<canvas id="myChart" width="5" height="5"></canvas>
				</div>

				<div class="containerDataEmpresa">
					<h1 class="titlePanelControl">Productos con stock mínimo</h1>
					<canvas id="myChartStokMin" width="5" height="5"></canvas>
				</div>
	
			</div>
		</div>
		<canvas id="myChart" width="5" height="5"></canvas>
	</section>


		<?php include "includes/footer.php"?>
		

</body>
</html>
<script>
	cargarDatosGraficoBar();
	cargarDatosGraficoBarStokMin();

	function cargarDatosGraficoBarStokMin(){
	$.ajax({
		url:'action/data_grafico_stok_min.php',
		type:'POST'
	}).done(function(resp){
		//console.log(resp);
		if (resp.length > 0) {
			var titulo = [];
		var cantidad = [];
		var colores = [];
		var data = JSON.parse(resp);
		for(var i = 0; i < data.length; i++){
			titulo.push(data[i][2]);
			cantidad.push(data[i][6]);
			colores.push(colorRGB());
		}
		CrearGrafico(titulo,cantidad,colores,'doughnut','GRAFICO DE PRODUCTOS MÁS VENDIDOS','myChartStokMin');
		}
				
	});
}

function cargarDatosGraficoBar(){
	$.ajax({
		url:'action/data_grafico.php',
		type:'POST'
	}).done(function(resp){
		//console.log(resp);
		if (resp.length > 0) {
			var titulo = [];
		var cantidad = [];
		var colores = [];
		var data = JSON.parse(resp);
		for(var i = 0; i < data.length; i++){
			titulo.push(data[i][0]);
			cantidad.push(data[i][1]);
			colores.push(colorRGB());
		}
		CrearGrafico(titulo,cantidad,colores,'doughnut','GRAFICO DE PRODUCTOS MÁS VENDIDOS','myChart');
		}
				
	});
}

function CrearGrafico(titulo,cantidad,colores,tipo,encabezado,id){
	const ctx = document.getElementById(id);
const myChart = new Chart(ctx, {
    type: tipo,
    data: {
        labels: titulo,
        datasets: [{
            label:encabezado,
            data: cantidad,
            backgroundColor: colores,
            borderColor: colores,
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

}

  function generarNumero(numero){
	return (Math.random()*numero).toFixed(0);
    }

    function colorRGB(){
        var coolor = "("+generarNumero(255)+"," + generarNumero(255) + "," + generarNumero(255) +")";
        return "rgb" + coolor;
    }
</script>