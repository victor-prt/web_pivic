<?php 
	include_once('Connections/WebPivic_bbdd.php');
	include("Includes/funciones.php");
	$email = mysql_real_escape_string($_POST['mail2']);
	$pass_actual = mysql_real_escape_string($_POST['pass']);
	$password = mysql_real_escape_string( $_POST['pass2']);

	$correct_pass = "SELECT Password FROM usuario WHERE IdUsuario = ".$_SESSION['MM_IdUsuario'];
	$correct_passRS = mysql_query($correct_pass, $WebPivic_bbdd);
	$row_correct_pass = mysql_fetch_assoc($correct_passRS);
	if(!empty($pass_actual))
	{
		if($row_correct_pass['Password'] != $pass_actual)
			echo "<div id='cent'>1</div>La contraseña actual no es la correcta";
		else if(empty($email)){
			$sql_update = "UPDATE usuario SET Password = '".$password."' WHERE IdUsuario =".$_SESSION['MM_IdUsuario'];
			$sql_updateRS = mysql_query($sql_update,$WebPivic_bbdd);
			echo "Su contraseña ha sido actualizada correctamente";
		}
		else if(!empty($email))
		{
			$comprobar_sql = "SELECT Email FROM usuario WHERE Email ='".$email."'";
			$comprobarRS = mysql_query($comprobar_sql, $WebPivic_bbdd) or die(mysql_error());
			$row_comprobar = mysql_fetch_assoc($comprobarRS);
			if($row_comprobar)
				echo "Este e-mail ya está registrado";
			else
			{
				$sql_update = "UPDATE usuario SET Password = '".$password."', Email = '".$email."' WHERE IdUsuario =".$_SESSION['MM_IdUsuario'];
				$sql_updateRS = mysql_query($sql_update,$WebPivic_bbdd);
				echo "Su contrase&ntilde;a y su e-mail han sido actualizados correctamente";
			}
		}
	}
	else{
		if(!empty($email))
		{
			$comprobar_sql = "SELECT Email FROM usuario WHERE Email ='".$email."'";
			$comprobarRS = mysql_query($comprobar_sql, $WebPivic_bbdd) or die(mysql_error());
			$row_comprobar = mysql_fetch_assoc($comprobarRS);
			if($row_comprobar)
				echo "Este e-mail ya está registrado";
			else
			{
				$sql_update = "UPDATE usuario SET Email ='".$email."' WHERE IdUsuario=".$_SESSION['MM_IdUsuario'];
				$sql_updateRS = mysql_query($sql_update,$WebPivic_bbdd);
				echo "Su email ha sido actualizado correctamente";
			}
		}
	}
	mysql_free_result($correct_passRS);
	mysql_close($WebPivic_bbdd);
?>