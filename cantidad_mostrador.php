<?php 
	include_once('Connections/WebPivic_bbdd.php');
	include("Includes/funciones.php");
	
	//cnsultas de actualizar cantidades
	$producto = mysql_real_escape_string($_POST['producto']);
	$Update_sql = "INSERT INTO pedido (ID,pedlinea,PedIdProducto,pedcantidad,pedprecio) (SELECT ".$_SESSION['MM_sesion'].",(select count(*) + 1 FROM pedido WHERE ID=".$_SESSION['MM_sesion']."),".$producto.",0,(SELECT Precio FROM articulos WHERE CodigoProducto =".$producto.") FROM pedido WHERE NOT EXISTS (SELECT PedIdProducto FROM pedido WHERE PedIdProducto=".$producto." AND ID=".$_SESSION['MM_sesion'].") LIMIT 1)";
	$UpdateRS = mysql_query($Update_sql,$WebPivic_bbdd) or die(mysql_error());
	$insertSQL = "UPDATE pedido SET PedCantidad = PedCantidad + 1 WHERE PedIdProducto = ".$producto." AND ID = ".$_SESSION['MM_sesion'].";";
	$insertRS = mysql_query($insertSQL,$WebPivic_bbdd) or die(mysql_error());		
?>

