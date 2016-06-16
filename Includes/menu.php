<?php
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

mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
$query_Recordset1 = "SELECT TRIM(familias.FamNombre) AS FamNombre,familias.IdFam FROM familias  INNER JOIN subfamilias ON familias.IdFam=subfamilias.IdFam AND subfamilias.IdInternet='S'  INNER JOIN articulos ON articulos.Familia= subfamilias.IdFam AND subfamilias.IdSubFam=articulos.Subfamilia AND articulos.MarcaInternet='S' AND articulos.Fabricante>0 WHERE familias.FamInternet='S' GROUP BY familias.IdFam ORDER BY familias.Idfam ";
$Recordset1 = mysql_query($query_Recordset1, $WebPivic_bbdd) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<div class='menu large-2 small-3 columns'>
<?php 
echo "<ul class='fam'>";
do {  
	echo "<li><a href='productos_familia.php?familia=".$row_Recordset1['IdFam']."'>".$row_Recordset1['FamNombre']."</a>";
	/***********************Lectura  y distribucion subfamilias************************/
		$VarFamilia_Recordset2 = "0";
		if (isset($row_Recordset1['IdFam'])) {
		  $VarFamilia_Recordset2 = $row_Recordset1['IdFam'];
		}
		mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
		$query_Recordset2 = sprintf("SELECT TRIM(subfamilias.idNombre) AS idNombre, subfamilias.IdSubFam AS IdSubFam FROM subfamilias INNER JOIN articulos ON articulos.Familia=subfamilias.IdFam AND articulos.subfamilia=subfamilias.IdSubFam AND idInternet='S' AND articulos.MarcaInternet='S' AND articulos.Fabricante >0 WHERE subfamilias.IdFam=%s GROUP BY subfamilias.IdFam, subfamilias.IdSubFam ORDER BY subfamilias.IdFam, subfamilias.IdSubFam", GetSQLValueString($VarFamilia_Recordset2, "text"));
		$Recordset2 = mysql_query($query_Recordset2, $WebPivic_bbdd) or die(mysql_error());
		$row_Recordset2 = mysql_fetch_assoc($Recordset2);
		$totalRows_Recordset2 = mysql_num_rows($Recordset2);


	
	if($totalRows_Recordset2 <= 5)
	{
		echo "<ul class='subfam1'>";
	}
	if($totalRows_Recordset2 > 5 && $totalRows_Recordset2 <= 10)
	{
		echo "<ul class='subfam2 large-block-grid-2 small-block-grid-2'>";
	}
	if($totalRows_Recordset2 > 10)
	{
		echo "<ul class='subfam3 large-block-grid-3 small-block-grid-3'>";
	}
	do{
		echo "<li><a href='productos_subfamilia.php?familia=".$row_Recordset1['IdFam']."&subfamilia=".$row_Recordset2['IdSubFam']."' >".$row_Recordset2['idNombre']."</a>";
		/********************lectura y posicionamiento fabricantes*************************/
		$VarFamilia_Recordset3 = "0";
if (isset($row_Recordset1['IdFam'])) {
  $VarFamilia_Recordset3 = $row_Recordset1['IdFam'];
}
$VarSubFam_Recordset3 = "0";
if (isset($row_Recordset2['IdSubFam'])) {
  $VarSubFam_Recordset3 = $row_Recordset2['IdSubFam'];
}
mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
$query_Recordset3 = sprintf("SELECT fabricantes.Fabricante AS Nombre,fabricantes.IdPivic AS IdFab FROM articulos INNER JOIN fabricantes ON fabricantes.IdPivic=articulos.Fabricante WHERE articulos.Familia=%s AND articulos.Subfamilia=%s AND articulos.Marcainternet='S' AND articulos.fabricante > 0 GROUP BY articulos.Fabricante ORDER BY articulos.Fabricante", GetSQLValueString($VarFamilia_Recordset3, "text"),GetSQLValueString($VarSubFam_Recordset3, "text"));
$Recordset3 = mysql_query($query_Recordset3, $WebPivic_bbdd) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
		if($totalRows_Recordset3 <= 3){
			echo "<ul class='fab'>";
		}
		else{
			echo"<ul class='fab1 large-block-grid-2 small-block-grid-2'>";
		}
		do{
			echo "<li><a href='productos_fabricante.php?familia=".$row_Recordset1['IdFam']."&subfamilia=".$row_Recordset2['IdSubFam']."&fabricante=".$row_Recordset3['IdFab']."'>".$row_Recordset3['Nombre']."</a></li>";
		}while($row_Recordset3 = mysql_fetch_assoc($Recordset3));

		echo "</ul>";
		echo "</li>";
	}
	
	while($row_Recordset2 = mysql_fetch_assoc($Recordset2));
	/**********************************************************************************/
	echo "</ul>";
	echo "</li>";
	
} 
while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 
echo "</ul>";
?>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
