<?php
    require_once('Connections/WebPivic_bbdd.php');
	mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
	$compararSQL = "SELECT IdProducto, NombreProducto, Fotothumbs, Logo FROM comparar INNER JOIN articulos ON CodigoProducto = IdProducto 
	INNER JOIN fabricantes on articulos.Fabricante = fabricantes.IdPivic WHERE IdSesion =".$_SESSION['MM_sesion'];
	$comparar = mysql_query($compararSQL,$WebPivic_bbdd);
	$row_comparar = mysql_fetch_assoc($comparar);
	if(mysql_num_rows($comparar) > 0)
	{
?>

	<div class='cont_comparar'>
    <h2 class='comparar_tittle'>Lista comparaci&oacute;n</h2>
	<?php
		if(mysql_num_rows($comparar) > 1)
		{
	?>
    <form class='delete_all' action='delete_comparar_all.php' method='POST'>
    	<button class='deleteall_submit'>Eliminar Todos</button>
    </form>    
<?php
		}
	do{
		echo "<div class='producto_comparar'>";
?>
		<form id='delcomp<?php echo $row_comparar['IdProducto'];?>' action='delete_comparar.php' method='POST'>
        	<input type='hidden' name='prod' value='<?php echo $row_comparar['IdProducto'];?>' />
            <button id='delete_submit<?php echo $row_comparar['IdProducto'];?>' class='compdelete_submit'>Eliminar</button>
        </form>
         <script type='text/javascript'>
					$('#delete_submit<?php echo $row_comparar['IdProducto'];?>').click(function(){
						$.post( $('#delcomp<?php echo $row_comparar['IdProducto']; ?>').attr('action'),
								$('#delcomp<?php echo $row_comparar['IdProducto']; ?> :input').serializeArray());										
							$('#delcomp<?php echo $row_comparar['IdProducto']; ?>').submit(function(e) {
								e.stopPropagation();
								e.preventDefault();
							});
							$(this).parent().parent().fadeOut();
							$('.mostrar_comparar').load("mostrar_comparar.php");
					});
        </script>
<?php
		echo "<div class='cont_comparar_nombre'>";
		echo "<div class='comparar_nombre'>";
		echo "<a href='detalles.php?producto=".$row_comparar['IdProducto']."'>".$row_comparar['NombreProducto']."</a>";
		echo "</div>";
		echo "</div>";
		if(!empty($row_comparar['Fotothumbs']))
			echo "<img src='images/fotosthumbs/".$row_comparar['Fotothumbs']."'/>";
		else if(!empty($row_comparar['Logo']))
			echo "<img src='images/fabricantes/".$row_comparar['Logo']."'/>";
		else
			echo "<img src='images/nodisponible.jpg'/>";
		echo "</div>";
	}
	while($row_comparar = mysql_fetch_assoc($comparar));
	echo "<a href='comparar.php' class='comparar_btn'>Comparar</a>";
	}
	mysql_free_result($comparar);
	include("javascripts/funcionesJ.js.php");
?>  
	</div>