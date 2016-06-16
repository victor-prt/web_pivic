<?php 
	include_once('Connections/WebPivic_bbdd.php');
	include("Includes/funciones.php");
	//datos de registro
	$nombre = mysql_real_escape_string($_POST['nombre']);
	$apellidos = mysql_real_escape_string($_POST['apellidos']);
	$email = mysql_real_escape_string($_POST['mail']);
	$password = mysql_real_escape_string($_POST['pass']);
	//datos del comprador
	$nif = mysql_real_escape_string($_POST['NIF']);
	$direccion = mysql_real_escape_string($_POST['direccion']);
	$poblacion = mysql_real_escape_string($_POST['poblacion']);
	$provincia = mysql_real_escape_string($_POST['provincia']);
	$CP = mysql_real_escape_string($_POST['CP']);
	$fijo = mysql_real_escape_string($_POST['fijo']);
	$movil = mysql_real_escape_string($_POST['movil']);
	//datos envio
	$nombre_envio = mysql_real_escape_string($_POST['nombree']);
	$apellidos_envio = mysql_real_escape_string($_POST['apellidose']);
	$direccion_envio = mysql_real_escape_string($_POST['direccione']);
	$provincia_envio = mysql_real_escape_string($_POST['provinciae']);
	$poblacion_envio = mysql_real_escape_string($_POST['poblacione']);
	$CP_envio = mysql_real_escape_string($_POST['CPe']);
	$telefono_envio = mysql_real_escape_string($_POST['tele']);
	//forma de pago
	$forma = mysql_real_escape_string($_POST['optionList']);
	
	$comprobar_mail_sql = "SELECT Email FROM usuario WHERE Email = '".$email."'";
	$comprobar_mailRS = mysql_query($comprobar_mail_sql,$WebPivic_bbdd) or die(mysql_error());
	$row_comprobar_mail = mysql_fetch_assoc($comprobar_mailRS);
	if($row_comprobar_mail)
	{
		echo "Este e-mail ya está registrado";
	}
	else{
		$sql_IdUsuario = "SELECT Contador + 1 from contadores where tipo='user'";
		$IdUsuarioRS = mysql_query($sql_IdUsuario, $WebPivic_bbdd) or die(mysql_error());
		$row_IdUsuario = mysql_fetch_assoc($IdUsuarioRS);
		
		$sql_registro = "INSERT INTO usuario VALUES(".$row_IdUsuario['Contador + 1'].",'".$nombre."','".$apellidos."','".$email."','".$password."','1')";		
		$RegistroRS = mysql_query($sql_registro, $WebPivic_bbdd) or die(mysql_error());
		
		$sql_contador = "UPDATE contadores SET contador=contador+1 WHERE tipo='user';";
		$ContadorRs = mysql_query($sql_contador, $WebPivic_bbdd) or die(mysql_error());		
		$_SESSION['MM_IdUsuario'] = $row_IdUsuario['Contador + 1'];
		
		$insertcompradorSQL = "INSERT INTO comprador VALUES('".$_SESSION['MM_sesion']."','".$_SESSION['MM_IdUsuario']."','".$_SESSION['MM_precio']."','".$nif."','".$direccion."','".$CP."','".$poblacion."','".$provincia."','".$fijo."','".$movil."','".$forma."')";
		$insertcompradorRS = mysql_query($insertcompradorSQL, $WebPivic_bbdd) or die(mysql_error());
		
		$insertenvioSQL = "INSERT INTO envio VALUES(".$_SESSION['MM_sesion'].",'".$direccion_envio."','".$poblacion_envio."','".$provincia_envio."',".$CP_envio.",'".$nombre_envio."','".$apellidos_envio."','".$telefono_envio."')";
		$insertenvioRS = mysql_query($insertenvioSQL, $WebPivic_bbdd) or die(mysql_error());
		mysql_free_result($IdUsuarioRS);
		$_SESSION['MM_sesion'] = NULL;
		unset($_SESSION['MM_session']);
		echo"<div id='cent'>1</div>";
	}
	
	
	mysql_close($WebPivic_bbdd);
?>