<?php 

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
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


	?>
	<section id="container">

		<div class="divInfoSistema">
			<div>
				<h1 class="titlePanelControl">Configuración</h1>
			</div>
			<div class="containerPerfil">
				<div class="containerDataUser">
					<div class="logoUser">
						<img src="img/logoUser.png">
					</div>
					<div class="divDataUser">
						<h4>Información personal</h4>

						<div>
							<label>Nombre:</label> <span><?= $_SESSION['nombre']; ?></span>
						</div>
						<div>
							<label>Correo:</label> <span><?= $_SESSION['email']; ?></span>
						</div>

						<h4>Datos Usuarios</h4>

						<div>
							<label>Rol:</label> <span><?= $_SESSION['rol_name']; ?></span>
						</div>
						<div>
							<label>Usuario:</label> <span><?= $_SESSION['user']; ?></span>
						</div>

						<h4>Cambiar contraseña</h4>
						<form action="" method="post" name="frmChangePass" id="frmChangePass">
								<div>
									<input type="password" name="txtPassUser" id="txtPassUser" placeholder="Contraseña actual" required>								
								</div>
								<div>
									<input class="newPass" type="password" name="txtNewPassUser" id="txtNewPassUser" placeholder="Nueva contraseña" required>								
								</div>
								<div>
									<input class="newPass" type="password" name="txtPassConfirm" id="txtPassConfirm" placeholder="Confirmar contraseña" required>								
								</div>
								<div class="alertChangePass" style="display: none;" >
								</div>
								<div>
									<button type="submit" class="btn_save btnChangePass"><i class="fas fa-key"></i> Cambiar contraseña</button>
								</div>
								<a href="../backup/index.php" class="btn_save" style="text-align: center;"><i class="far fa-save fa-lg"></i> Crear copia de seguridad</a>
						</form>
					</div>
				</div>
				<?php if ($_SESSION['rol'] == 1) {
				 ?>
				<div class="containerDataEmpresa">
					<div class="logoUser">
						<img src="img/logoEmpresa.png">
					</div>
					<h4>Datos de la empresa</h4>

						<form action="" method="post" name="frmEmpresa" id="frmEmpresa">
							<input type="hidden" name="action" value="updateDataEmpresa">

								<div>
									<label>Nit:</label><input type="text" name="txtNit" id="txtNit" placeholder="Nit de la empresa" value="<?= $nit; ?>" required>								
								</div>
								<div>
									<label>Nombre:</label><input type="text" name="txtNombre" id="txtNombre" placeholder="Nombre de la empresa" value="<?= $nombreEmpresa; ?>" required>								
								</div>
								<div>
									<label>Razon social:</label><input type="text" name="txtRSocial" id="txtRSocial" placeholder="Razon social" value="<?= $razonSocial; ?>">								
								</div>
								<div>
									<label>Teléfono:</label><input type="text" name="txtTelEmpresa" id="txtTelEmpresa" placeholder="Númer de teléfono" value="<?= $telEmpresa; ?>" required>								
								</div>
								<div>
									<label>Correo electrónico:</label><input type="email" name="txtEmailEmpresa" id="txtEmailEmpresa" placeholder="Correo electrónico" value="<?= $emailEmpresa; ?>" required>					
								</div>
								<div>
									<label>Dirección:</label><input type="text" name="txtDirEmpresa" id="txtDirEmpresa" placeholder="Dirección de la empresa" value="<?= $dirEmpresa; ?>" required>								
								</div>
								<div>
									<label>Moneda:</label><input type="text" name="txtMoneda" id="txtMoneda" placeholder="Simbolo de moneda" value="<?= $moned; ?>" required>								
								</div>
								<!--<div>
									<label>IVA (%):</label><input type="text" name="txtIva" id="txtIva" placeholder="Impuesto al valor agregado (IVA)" value="<?= $iva; ?>" required>								
								</div>-->
								<div class="photo">
									<label for="foto">Foto</label>
				        				<div class="prevPhoto">
				        				<span class="delPhoto <?php echo $classRemove; ?>">X</span>
				        				<label for="foto"></label>
				        				<?php echo $foto; ?>
				        				</div>
				        				<div class="upimg">
				        				<input type="file" name="foto" id="foto" value="<?php echo $foto; ?>">
				        				</div>
				        				<div id="form_alert"></div>
								</div>
								<div class="alertFormEmpresa" style="display: none; text-align: center;"></div>
								<div>
									<button type="submit" class="btn_save btnChangePass"><i class="far fa-save fa-lg"></i> Guardar datos</button>
								</div>
						</form>
								
							
				</div>
			<?php } ?>
			</div>
		</div>
		<canvas id="myChart" width="400" height="400"></canvas>
	</section>


		<?php include "includes/footer.php"?>
		

</body>
</html>