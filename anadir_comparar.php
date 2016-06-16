<?php
	require_once('Connections/WebPivic_bbdd.php');
	mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
	$page =getenv('HTTP_REFERER'); 
	$producto = $_POST['prod'];
	$compararSQL = "SELECT IdProducto FROM comparar WHERE IdSesion = ".$_SESSION['MM_sesion'];
	$comparar = mysql_query($compararSQL,$WebPivic_bbdd) or die(mysql_error());
	$row_comparar = mysql_fetch_assoc($comparar);
	if(mysql_num_rows($comparar) <= 2)
	{
		$insertSQL = "INSERT INTO comparar VALUES(".$_SESSION['MM_sesion'].",".$producto.")";
		mysql_query($insertSQL,$WebPivic_bbdd);
	}
	else{
		echo "<div class='cent'>1</div>";
	}
	mysql_free_result($comparar);
	mysql_close($WebPivic_bbdd);
?>