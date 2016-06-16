<?php 
	include_once('Connections/WebPivic_bbdd.php');
	include("Includes/funciones.php");
	
	$mail = mysql_real_escape_string($_POST['mail']);
	
	$comprobar_sql = "SELECT * FROM usuario WHERE Email = '".$mail."'";
	$comprobarRS = mysql_query($comprobar_sql,$WebPivic_bbdd) or die(mysql_error());
	$row_comprobar = mysql_fetch_assoc($comprobarRS);
	if($row_comprobar)
		echo "Este usuario ya está registrado, recupere su contraseña";
	else
		echo "<div class='cent'>1</div>";
	mysql_free_result($comprobarRS);
	mysql_close($WebPivic_bbdd);
		
?>