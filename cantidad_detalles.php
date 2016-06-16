<?php 
	include_once('Connections/WebPivic_bbdd.php');
	include("Includes/funciones.php");
	
	//cnsultas de actualizar cantidades
	$cantidad = mysql_real_escape_string($_POST['carrito_cantidad']);
	$producto = mysql_real_escape_string($_POST['carrito_producto']);
	$insert_sql = "INSERT INTO pedido (ID,pedlinea,PedIdProducto,pedcantidad,pedprecio) (SELECT ".$_SESSION['MM_sesion'].",(select count(*) + 1 FROM pedido WHERE ID=".$_SESSION['MM_sesion']."),".$producto.",".$cantidad.",(SELECT Precio FROM articulos WHERE CodigoProducto =".$producto.") FROM pedido WHERE NOT EXISTS (SELECT PedIdProducto FROM pedido WHERE PedIdProducto=".$producto." AND ID=".$_SESSION['MM_sesion'].") LIMIT 1)";
	$insertRS = mysql_query($insert_sql,$WebPivic_bbdd) or die(mysql_error());
	$Update_sql = "UPDATE pedido SET pedcantidad = ".$cantidad." WHERE PedIdProducto = ".$producto." AND ID = ".$_SESSION['MM_sesion'];
	$UpdateRS = mysql_query($Update_sql,$WebPivic_bbdd);
?>
<?php
mysql_close($database_WebPivic_bbdd);
?>
