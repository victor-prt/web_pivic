<?php 
	include_once('Connections/WebPivic_bbdd.php');
	include("Includes/funciones.php");
	
	//cnsultas de actualizar cantidades
	$cantidad = mysql_real_escape_string($_POST['carrito_cantidad']);
	$producto = mysql_real_escape_string($_POST['carrito_producto']);
	
	$Update_sql = "UPDATE pedido SET PedCantidad =".$cantidad." WHERE ID =".$_SESSION['MM_sesion']." AND PedIdProducto = '".$producto."'";
	$UpdateRS = mysql_query($Update_sql,$WebPivic_bbdd) or die(mysql_error());
	
	header('Location: carrito.php');
?>
<?php
//mysql_free_result($pedido);
//mysql_free_result($ivaRS);
?>
