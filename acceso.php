<?php 
	include_once('Connections/WebPivic_bbdd.php');
	include("Includes/funciones.php");
	$usuario = mysql_real_escape_string($_POST['usuario']);
	$password = mysql_real_escape_string( $_POST['password']);

	mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
	$sql = "SELECT IdUsuario, Email, Password FROM usuario WHERE Email='".$usuario."' AND Password='".$password."' AND Activo = 1";
	$LoginRS = mysql_query($sql, $WebPivic_bbdd) or die(mysql_error());
	$row_LoginRS = mysql_fetch_assoc($LoginRS);
	
	if($row_LoginRS)
		{
			$_SESSION['MM_IdUsuario'] = $row_LoginRS['IdUsuario'];
			echo "<div class='cent'>1</div>";
		}
	else
		echo "Usuario o contraseña incorrectos";
	mysql_free_result($LoginRS);
	mysql_close($WebPivic_bbdd);
?>