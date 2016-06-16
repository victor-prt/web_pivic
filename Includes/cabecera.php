<?php require_once('Connections/WebPivic_bbdd.php'); ?>
<?php include ("Includes/funciones.php");?>
<div class="row">
		<div class="cabecera large-12 small-12 columns">
			<div class="logo">
				<a href="index.php"><img src="images/LogoWeb.gif"/></a>
			</div>
			<!--<div class="carrito_min">
				<a href="carrito.php">Mi carrito(0)</a>
			</div>
			<div class="registro_min">
				<a href="..." class='login_btn_mvl'>Iniciar sesi&oacute;n</a>
			</div>-->
			<a href='...' class='options'><img src='images/menu_movil.png'></a>
			<a href='carrito.php' class="carro">
				<img src="images/carro.gif"/>Carrito 
			</a>
			<?php
			if(isset($_SESSION['MM_IdUsuario']))
				echo"<a href='#' class='login_btn'><img src='images/log.gif'>Mi cuenta</a>";
			else
				echo "<a href='registro.php' class='navlogin'>Iniciar sesi&oacuten</a>";
			?>
			<div id="registro_caja">
				<div id="tab">
					<a href='...' class='login_btn'><img src='images/log.gif'>Mi cuenta</a>
				</div>
				<div class="triangulo_registro"></div>
				<div class="triangulo_registro2"></div>
				<div id='contenido_registro'>
					<?php
					/*
					if(!isset($_SESSION['MM_IdUsuario']))
					{
					?>
					<form id="myForm" action="acceso.php" method="POST">
						<input type="text" name="usuario" id="usuario" placeholder="email">
						<input type="password" name="password" id="password" placeholder="Password">
						<button id="login_submit">Acceder</button>
					</form>
						<div id="registrar"><a href='registro.php' class='signin'>Reg&iacutestrese</a></div>
						<div id="recuperar_password"><a href='#' class='signin'>&iquest;Olvid&oacute la contrase&ntildea&#63;</a></div>
						<div id='ack'></div>
					<?php 
					}
					else{*/
						if(isset($_SESSION['MM_IdUsuario']))//{
						//echo "<div id='infousuario'><div id='nombreusuario'>Bienvenido/a ".ObtenerNombreUsuario($_SESSION['MM_IdUsuario'])."</div>";
						//echo "<div id='modificarusuario'><img src='images/options.png'><a href='#' class='signin'>Actualice sus datos</a></div>";
						include("Includes/logout.php");
						//echo"</div>";
					//}
					?>
				</div>
			</div>

			<div class="buscador">
				<form action="" method="post" name="buscador">
					<input type="text" name="bus" id="busqueda" value="buscar..." onclick="if(this.value=='buscar...') this.value=''" onblur="if(this.value=='') this.value='buscar...'">
					<input type="submit" id="button" value="">
				</form>
			</div>
		</div>
</div>