<?php 
	include_once('Connections/WebPivic_bbdd.php');
	include("Includes/funciones.php");
	
	//datos comprador
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
	
	$insertcompradorSQL = "INSERT INTO comprador VALUES('".$_SESSION['MM_sesion']."','".$_SESSION['MM_IdUsuario']."','".$_SESSION['MM_precio']."','".$nif."','".$direccion."','".$CP."','".$poblacion."','".$provincia."','".$fijo."','".$movil."','".$forma."')";
	echo $insertcompradorSQL;
		$insertcompradorRS = mysql_query($insertcompradorSQL, $WebPivic_bbdd) or die(mysql_error());
		
		$insertenvioSQL = "INSERT INTO envio VALUES(".$_SESSION['MM_sesion'].",'".$direccion_envio."','".$poblacion_envio."','".$provincia_envio."',".$CP_envio.",'".$nombre_envio."','".$apellidos_envio."','".$telefono_envio."')";
		echo $insertenvioSQL;
		$insertenvioRS = mysql_query($insertenvioSQL, $WebPivic_bbdd) or die(mysql_error());
		$_SESSION['MM_sesion'] = NULL;
		unset($_SESSION['MM_session']);
?>