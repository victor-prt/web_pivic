<?php 
	include_once('Connections/WebPivic_bbdd.php');
	include("Includes/funciones.php");
	
	$nombre = mysql_real_escape_string($_POST['nombre']);
	$apellidos = mysql_real_escape_string( $_POST['apellidos']);
	$email = mysql_real_escape_string( $_POST['mail']);
	$email2 = mysql_real_escape_string( $_POST['mail2']);
	$password = mysql_real_escape_string( $_POST['pass']);
	$password2 = mysql_real_escape_string( $_POST['pass2']);
	
	mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
	$sql_comprobar_usuario = "SELECT * from usuario WHERE Email ='".$email."'";
	$ComprobarRS = mysql_query($sql_comprobar_usuario, $WebPivic_bbdd) or die(mysql_error());
	$row_ComprobarRS = mysql_fetch_assoc($ComprobarRS);
	if($row_ComprobarRS)
		echo "Este usuario ya está registrado, recupere su contraseña";	
	else{
				$sql_IdUsuario = "SELECT Contador + 1 from contadores where tipo='user'";
				$IdUsuarioRS = mysql_query($sql_IdUsuario, $WebPivic_bbdd) or die(mysql_error());
				$row_IdUsuario = mysql_fetch_assoc($IdUsuarioRS);
				
				$sql_registro = "INSERT INTO usuario VALUES(".$row_IdUsuario['Contador + 1'].",'".$nombre."','".$apellidos."','".$email."','".$password."','1')";		
				$RegistroRS = mysql_query($sql_registro, $WebPivic_bbdd) or die(mysql_error());
			
				$sql_contador = "UPDATE contadores SET contador=contador+1 WHERE tipo='user';";
				$ContadorRs = mysql_query($sql_contador, $WebPivic_bbdd) or die(mysql_error());
				$_SESSION['MM_IdUsuario'] = $row_IdUsuario['Contador + 1'];
				echo "<div class='cent'>1</div>";
				
				mysql_free_result($IdUsuarioRS);
			}
	mysql_free_result($ComprobarRS);
	mysql_close($WebPivic_bbdd);
?>