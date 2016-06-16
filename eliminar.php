<?php 
require_once('Connections/WebPivic_bbdd.php'); 
include("Includes/funciones.php");

$producto = mysql_real_escape_string($_POST['carrito_producto']);
mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);

$linea_sql = "SELECT PedLinea FROM pedido WHERE PedIdProducto = ".$producto." AND ID=".$_SESSION['MM_sesion'];
$lineaRS = mysql_query($linea_sql,$WebPivic_bbdd) or die(mysql_error());
$row_linea = mysql_fetch_assoc($lineaRS);

$delete_sql= "DELETE FROM pedido WHERE ID = ".$_SESSION['MM_sesion']." AND PedIdProducto =".$producto ;
$deleteRS = mysql_query($delete_sql,$WebPivic_bbdd);
$linea_update = "UPDATE pedido SET PedLinea = PedLinea - 1 WHERE PedLinea > ".$row_linea['PedLinea']." AND ID=".$_SESSION['MM_sesion'];
$linea_updateRS = mysql_query($linea_update,$WebPivic_bbdd) or die(mysql_error());


header('Location: carrito.php');
mysql_free_result($lineaRS);
mysql_close($WebPivic_bbdd);

?>