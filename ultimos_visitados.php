<?php
	$visitadoSQL = "SELECT Producto, Fotothumbs, NombreProducto, Logo FROM visitados INNER JOIN articulos ON Producto = CodigoProducto 
	INNER JOIN fabricantes ON articulos.Fabricante = fabricantes.IdPivic WHERE Sesion =".$_SESSION['MM_sesion']." ORDER BY Posicion ASC";
	$visitado = mysql_query($visitadoSQL,$WebPivic_bbdd);
	$row_visitado = mysql_fetch_assoc($visitado);
	if(mysql_num_rows($visitado))
	{
?>
	<div class='cont_comparar'>
    <h2 class='comparar_tittle'>&Uacute;ltimos visitados</h2>
   	<?php
		do{
			echo "<div class='producto_comparar'>";
			echo "<div class='cont_comparar_nombre'>";
			echo "<div class='comparar_nombre'>";
			echo "<a href='detalles.php?producto=".$row_visitado['Producto']."'>".$row_visitado['NombreProducto']."</a>";
			echo "</div>";
			echo "</div>";
			if(!empty($row_visitado['Fotothumbs']))
				echo "<img src='images/fotosthumbs/".$row_visitado['Fotothumbs']."'>";
			else if(!empty($row_visitado['Logo']))
				echo "<img src='images/fabricantes/".$row_visitado['Logo']."'>";
			else
				echo "<img src='images/nodisponible.jpg'/>";
			echo "</div>";
		}
		while($row_visitado = mysql_fetch_assoc($visitado));
	?>
    </div>
<?php
	}
	mysql_free_result($visitado);
?>