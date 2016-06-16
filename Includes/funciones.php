<?php 
if(is_file("Connections/WebPivic_bbdd.php"))
{
	require_once("Connections/WebPivic_bbdd.php");
}
else{
	require_once("../Connections/WebPivic_bbdd.php");
}
/*********************************************************/
/*********************************************************/
/*************Asignacion variable de sesion***************/
/*********************************************************/
/*********************************************************/
	if(!isset($_SESSION['MM_sesion']))
	{
		global $database_WebPivic_bbdd, $WebPivic_bbdd;
		mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
		$ses="SELECT contador+1 from contadores WHERE Tipo='Pedido' FOR UPDATE";
		$sesion = mysql_query($ses, $WebPivic_bbdd) or die(mysql_error());
		$sesion_row = mysql_fetch_array($sesion);
		$_SESSION['MM_sesion'] = $sesion_row[0];
		$insertSQL = "UPDATE contadores SET Contador = Contador + 1 WHERE Tipo = 'Pedido'";
		$sesion = mysql_query($insertSQL, $WebPivic_bbdd) or die(mysql_error());
		//mysql_free_result($sesion);
		//mysql_close($WebPivic_bbdd);
	}
?>
<?php
/*********************************************************/
/*********************************************************/
/*********************************************************/
/*********************************************************/
/*********************************************************/
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
/*********************************************************/
/*********************************************************/
/****************Obtención nombre Familia*****************/
/*********************************************************/
/*********************************************************/
	function ObtenerNombreFamilia($familia)
	{
			global $database_WebPivic_bbdd, $WebPivic_bbdd;
			mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
			$query_nombre_familia = "SELECT familias.FamNombre FROM familias WHERE familias.Idfam=$familia";
			$nombre_familia = mysql_query($query_nombre_familia, $WebPivic_bbdd) or die(mysql_error());
			$row_nombre_familia = mysql_fetch_assoc($nombre_familia);
			$totalRows_nombre_familia = mysql_num_rows($nombre_familia);
			return $row_nombre_familia['FamNombre']; 
			mysql_free_result($nombre_familia);
			
			mysql_close($WebPivic_bbdd);
	}
	
?>
<?php
/*********************************************************/
/*********************************************************/
/**************Obtención nombre SubFamilia****************/
/*********************************************************/
/*********************************************************/
	function ObtenerNombreSubFamilia($familia,$subfamilia)
	{
			global $database_WebPivic_bbdd, $WebPivic_bbdd;
			mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
			$query_nombre_subfamilia = "SELECT subfamilias.idNombre FROM subfamilias WHERE subfamilias.IdFam=$familia AND subfamilias.IdSubFam = $subfamilia";
			$nombre_subfamilia = mysql_query($query_nombre_subfamilia, $WebPivic_bbdd) or die(mysql_error());
			$row_nombre_subfamilia = mysql_fetch_assoc($nombre_subfamilia);
			$totalRows_nombre_subfamilia = mysql_num_rows($nombre_subfamilia);
			return $row_nombre_subfamilia['idNombre']; 
			mysql_free_result($nombre_subfamilia);
			
			mysql_close($WebPivic_bbdd);
	}
	
?>
<?php
/*********************************************************/
/*********************************************************/
/**************Obtención nombre Fabricante****************/
/*********************************************************/
/*********************************************************/
	function ObtenerNombreFabricante($fabricante)
	{
			global $database_WebPivic_bbdd, $WebPivic_bbdd;
			mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
			$query_nombre_fabricante = "SELECT fabricantes.Fabricante FROM fabricantes WHERE fabricantes.IdPivic=$fabricante";
			$nombre_fabricante = mysql_query($query_nombre_fabricante, $WebPivic_bbdd) or die(mysql_error());
			$row_nombre_fabricante = mysql_fetch_assoc($nombre_fabricante);
			$totalRows_nombre_fabricante = mysql_num_rows($nombre_fabricante);
			return $row_nombre_fabricante['Fabricante']; 
			mysql_free_result($nombre_fabricante);
			
			mysql_close($WebPivic_bbdd);
	}
	
?>
<?php
/*********************************************************/
/*********************************************************/
/****************Obtencion nombre usuario*****************/
/*********************************************************/
/*********************************************************/
function ObtenerNombreUsuario($identificador)
{
		global $database_WebPivic_bbdd, $WebPivic_bbdd;
		mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
$query_nombre_usuario = "SELECT usuario.Nombre FROM usuario WHERE usuario.IdUsuario=$identificador";
$nombre_usuario = mysql_query($query_nombre_usuario, $WebPivic_bbdd) or die(mysql_error());
$row_nombre_usuario = mysql_fetch_assoc($nombre_usuario);
$totalRows_nombre_usuario = mysql_num_rows($nombre_usuario);

return $row_nombre_usuario['Nombre']; 
		mysql_free_result($nombre_usuario);

mysql_close($WebPivic_bbdd);
}

/*********************************************************/
/*********************************************************/
/***************Obtencion nombre producto*****************/
/*********************************************************/
/*********************************************************/
function ObtenerNombreProducto($identificador)
{
		global $database_WebPivic_bbdd, $WebPivic_bbdd;
		mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
		$query_nombre_producto = "SELECT articulos.NombreProducto FROM articulos WHERE articulos.CodigoProducto='$identificador'";
		$nombre_producto = mysql_query($query_nombre_producto, $WebPivic_bbdd) or die(mysql_error());
		$row_nombre_producto = mysql_fetch_assoc($nombre_producto);
		$totalRows_nombre_producto = mysql_num_rows($nombre_producto);
		return $row_nombre_producto['NombreProducto']; 
		mysql_free_result($nombre_producto);
mysql_close($WebPivic_bbdd);
}
/*********************************************************/
/*********************************************************/
/********************Obtencion imagen*********************/
/*********************************************************/
/*********************************************************/
function ObtenerImagen($identificador)
{
		global $database_WebPivic_bbdd, $WebPivic_bbdd;
		mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
$query_imagen = "SELECT articulos.FotoThumbs FROM articulos WHERE articulos.CodigoProducto='$identificador'";
$nombre_imagen = mysql_query($query_imagen, $WebPivic_bbdd) or die(mysql_error());
$row_imagen = mysql_fetch_assoc($nombre_imagen);
$totalRows_imagen = mysql_num_rows($nombre_imagen);

return $row_imagen['FotoThumbs']; 
		mysql_free_result($nombre_imagen);

mysql_close($WebPivic_bbdd);
}




    ?>
