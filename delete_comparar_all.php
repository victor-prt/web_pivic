<?php
	require_once('Connections/WebPivic_bbdd.php');
	mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
	$delete = "DELETE FROM comparar WHERE IdSesion = ".$_SESSION['MM_sesion'];
	mysql_query($delete,$WebPivic_bbdd);
	mysql_close($WebPivic_bbdd);
?>