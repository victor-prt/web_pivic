<?php require_once('Connections/WebPivic_bbdd.php'); ?>
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
$grupo = " ";
 
$idproducto_GrupoDetalle = "-1";
if (isset($_GET["producto"])) {
  $idproducto_GrupoDetalle = $_GET["producto"];
}
?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" ><!-- InstanceBegin template="/Templates/base.dwt.php" codeOutsideHTMLIsLocked="false" --><!-- DW6 --> <!--<![endif]-->
<head>
  <meta charset="iso-8859-1" />
  <meta name="viewport" content="width=device-width" />
  <title>Pivic</title>
 
  
  <link rel="stylesheet" href="stylesheets/app.css" />
  <link rel="stylesheet" href="stylesheets/style.css" />
  <link rel='stylesheet' type='text/css' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'/>
  

  <script src="javascripts/vendor/custom.modernizr.js"></script>
  <script src="javascripts/jquery-2.0.2.js" type="text/javascript"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
  
</head>
<body>
	<?php
		require_once("Includes/cabecera.php");
	?>
    <div class='menu_usuario'>
	<a href='...' class='options'><img src='images/menu_movil.png'></a>
	<?php
		if(isset($_SESSION['MM_IdUsuario']))
		{
	?>
    	<div class='cont_menu_first'>Mi cuenta</div>
        <div class='cont_menu'><a href=''>Mis Datos</a></div>
		<div class='cont_menu'><a href=''>Cerrar Sesión</a></div>
        <div class='cont_menu'><a href=''>Mi Carrito</a></div>
    <?php
		}
		else{
	?>
    	<div class='cont_menu_first'><a href='carrito.php'>Mi Carrito</a></div>
        <div class='cont_menu'><a href='registro.php'>Iniciar sesion</a></div>
    <?php	
	}
	?>
    </div>
	<div class="contenedor row large-10 large-centered small-12 columns">
			
				<?php
					include("Includes/menu.php");
				?>
			<div class="contenido large-10 small-9 large-offset-2 small-offset-3"><!-- InstanceBeginEditable name="contenido" -->
            <?php
				mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
				$existeSQL = "SELECT * FROM visitados WHERE Sesion = '".$_SESSION['MM_sesion']."' AND Producto = '".$idproducto_GrupoDetalle."'";
				$existeRS = mysql_query($existeSQL,$WebPivic_bbdd);
				$cantidad_visitados = "SELECT count(*) as cantidad FROM visitados WHERE Sesion =".$_SESSION['MM_sesion'];
				$cantidadRS = mysql_query($cantidad_visitados,$WebPivic_bbdd);
				$row_cantidad = mysql_fetch_assoc($cantidadRS);
				if(mysql_num_rows($existeRS) == 0)
				{
					if($row_cantidad['cantidad'] == 5)
					{
						$EliminarUltimo = "DELETE FROM visitados WHERE Sesion = ".$_SESSION['MM_sesion']." AND Posicion = 5";
						mysql_query( $EliminarUltimo,$WebPivic_bbdd);
						$Update = "UPDATE visitados SET Posicion = Posicion+1 WHERE Sesion =".$_SESSION['MM_sesion']." ORDER BY Posicion DESC";
						mysql_query($Update,$WebPivic_bbdd);
						$Insert_Producto = "INSERT INTO visitados (Sesion,Producto,Posicion) VALUES ('".$_SESSION['MM_sesion']."',".$idproducto_GrupoDetalle.",'1')";
						mysql_query($Insert_Producto,$WebPivic_bbdd);
					}
					else{				
						$Insert_Producto = "INSERT INTO visitados (Sesion,Producto,Posicion) VALUES ('".$_SESSION['MM_sesion']."','".$idproducto_GrupoDetalle."','".($row_cantidad['cantidad']+1)."')";
						mysql_query($Insert_Producto,$WebPivic_bbdd);
					}
				}
				$query_GrupoDetalle = sprintf("SELECT especdescrip.descripcion, especdetalle.valorpresentacion,especdetalle.grupocategoriaid FROM articulos 
				INNER JOIN especdetalle ON especdetalle.codigoproducto=articulos.codigoproducto INNER JOIN especdescrip ON especdescrip.idnombre=especdetalle.idnombre INNER JOIN especgrupo ON especgrupo.grupocategoriaid=especdetalle.grupocategoriaid INNER JOIN stocks ON stocks.stIdProducto = articulos.CodigoProducto WHERE articulos.CodigoProducto = %s ORDER BY especdetalle.grupocategoriaid,especgrupo.grupoid,especdetalle.idnombre", GetSQLValueString($idproducto_GrupoDetalle, "int"));
				$GrupoDetalle = mysql_query($query_GrupoDetalle, $WebPivic_bbdd) or die(mysql_error());
				$row_GrupoDetalle = mysql_fetch_assoc($GrupoDetalle);
				$totalRows_GrupoDetalle = mysql_num_rows($GrupoDetalle);
				$query_producto = "SELECT sum(stStock) AS stock,Precio,NombreProducto,Fotoalta, InfoMarketing, EANUPC,PartNumber, fabricantes.Fabricante, fabricantes.Logo FROM articulos INNER JOIN stocks ON stocks.stIdProducto = articulos.CodigoProducto INNER JOIN fabricantes ON idPivic = articulos.fabricante WHERE CodigoProducto =".$idproducto_GrupoDetalle;
				$Producto = mysql_query($query_producto,$WebPivic_bbdd);
				$row_Producto = mysql_fetch_assoc($Producto);
				
				$query_carrito = "SELECT PedIdProducto, PedCantidad FROM pedido WHERE PedIdProducto =".$idproducto_GrupoDetalle." AND ID = ".$_SESSION['MM_sesion'];
				$carrito = mysql_query($query_carrito, $WebPivic_bbdd);
				$row_carrito = mysql_fetch_assoc($carrito);

				$query_comparar = "SELECT IdProducto FROM comparar WHERE IdSesion = ".$_SESSION['MM_sesion'];
				$comparar = mysql_query($query_comparar,$WebPivic_bbdd);
				$num_comparar = mysql_num_rows($comparar);
				
				$query_caracteristicas = sprintf("SELECT especdescrip.descripcion,especgrupo.grupocategoriaid FROM especgrupo INNER JOIN especdescrip ON especdescrip.idnombre=especgrupo.idnombre WHERE especgrupo.grupocategoriaid = %s", GetSQLValueString($row_GrupoDetalle['grupocategoriaid'], "int"));
				$caracteristicas = mysql_query($query_caracteristicas,$WebPivic_bbdd);
				$num_caracteristicas = mysql_num_rows($caracteristicas);
			?>
            <h1 class='h1detalles'>Especificaciones t&eacute;cnicas</h1>
			<div id='contenedor_detalles_producto'>
            	<div id='contenedor_title_detalles'>
                	<div id='title_detalles'>
                    	<?php
							echo $row_Producto['NombreProducto'];
						?>
                    </div>
                </div>
                <div id='contenedor_imagen_detalles'>
               	 	<?php
						if(!empty($row_Producto['Fotoalta']))
							echo "<img src='images/fotosalta/".$row_Producto['Fotoalta']."'/>";
						else if(!empty($row_Producto['Logo']))
							echo "<img src='images/fabricantes/".$row_Producto['Logo']."'/>";
						else
							echo "<img src='images/nodisponible.jpg'/>";
					?>
                </div>
                <div id='contenedor_compra_detalles'>
                	<div id="detalles_grande">
                	<?php
						echo "<div class='negrita_detalles'>Código de barras: </div>".$row_Producto['EANUPC']."</br>";
						echo "<div class='negrita_detalles'>P/N: </div>".$row_Producto['PartNumber']."</br>";
						echo "<div class='negrita_detalles'>Fabricante :</div>".$row_Producto['Fabricante']."</br>";
						echo "<div class='negrita_detalles'>Unidades Disponibles: </div>".$row_Producto['stock']."</br>";
					?>
					</div>
                    <div id='precio_detalles'>
                    	<?php
							echo $row_Producto['Precio']." €";
						?>
                        <div id='detalles_iva'>
                        <?php
							//cambiar el valor del iva por el del pais donde se encuentra
							echo round($row_Producto['Precio'] + (0.21*$row_Producto['Precio']), 2, PHP_ROUND_HALF_UP)." € IVA incluido";
						?>
                        </div>
                    </div>
                  	<form id='comprar_detalles' action='cantidad_detalles.php' method='post'>
                    	<input type='hidden' name='carrito_producto' value='<?php echo $idproducto_GrupoDetalle;?>'/>
                        <?php
							if(empty($row_carrito))
							{
						?>
                        <input type='text' name='carrito_cantidad' id='cantidad_detalles' value='1'/>
                        <?php
							}
							else{
								echo "<input type='text' name='carrito_cantidad' id='cantidad_detalles' value='".$row_carrito['PedCantidad']."'/>";
							}
						?>
                        <button id='submit_comprar_detalles'><img src='images/carro.gif'/>Comprar</button>
                    </form>
                    <form id='comprar_detalles_min' action ='cantidad_mostrador.php' method='POST'>
                    	<input type='hidden' name='producto' value='<?php echo $idproducto_GrupoDetalle; ?>'>
                    	<button id='submit_comprar_detalles_min'><img src='images/carro.gif'/>Añadir a la cesta</button>
                    </form>
                    <?php
                    if($num_caracteristicas > 0)
                    {
                    ?>
                    <form id='comparar_detalles' action='anadir_comparar.php' method='POST'>
						  	<input type='hidden' name='prod' value='<?php echo $idproducto_GrupoDetalle;?>'/>
							<button id='submit_comparar_detalles'>+ Comparar</button>
					</form>
                    <script type='text/javascript'>
					$('#submit_comparar_detalles').click(function(){
						$.post( $('#comparar_detalles').attr('action'),
								$('#comparar_detalles :input').serializeArray(),
								function(data) {
									res = tiene_numeros(data);
									if(res){
										alert("Solo se pueden comparar tres productos a la vez!");
									}
								});
							$('#comparar_detalles').submit( function(e) {
								e.stopPropagation();
								e.preventDefault();
							});
							$.post('mostrar_comparar.php',{
									sesion:'<?php echo $_SESSION['MM_sesion']; ?>'},
									function(data){
										$('.mostrar_comparar').html(data);
									}
							);
					});
                    </script>
                    <?php
                	}
                    ?>
                </div>
            </div>
           	<?php
				if(!empty($row_Producto['InfoMarketing']))
				{
			?>
            <div id='infomktng_detalles'>
            <h1 id='descripcion_detalles'>Detalles del producto</h1>
            <?php
            	$saltos = array('<br /><br />\n','<br />\n','\n','\n\n','<br /><br />');
				$row_Producto['InfoMarketing'] = str_replace($saltos,'<br />',$row_Producto['InfoMarketing']);
				$row_Producto['InfoMarketing'] = str_replace('<br />','<br /><br />',$row_Producto['InfoMarketing']);
				$row_Producto['InfoMarketing'] = str_replace('<i>','<i font-size="5px">',$row_Producto['InfoMarketing']);
				echo $row_Producto['InfoMarketing'];
			?>
            </div>
            <?php
				}
				if(!empty($row_GrupoDetalle))
				{
			?>
			<table id="tblcaract">
<?php 
	do {
?>
      
        <tbody>
          <tr width="40%">
            <?php 
                                       if ($grupo <> $row_GrupoDetalle['grupocategoriaid']){
										   $query_GrupEspec = sprintf("SELECT especdescrip.descripcion,especgrupo.grupocategoriaid FROM especgrupo INNER JOIN especdescrip ON especdescrip.idnombre=especgrupo.idnombre WHERE especgrupo.grupocategoriaid = %s", GetSQLValueString($row_GrupoDetalle['grupocategoriaid'], "int"));
                                                           $GrupEspec = mysql_query($query_GrupEspec, $WebPivic_bbdd) or die(mysql_error());
                                                           $row_GrupEspec = mysql_fetch_assoc($GrupEspec);
                                                           echo  "<th colspan='2'>".$row_GrupEspec['descripcion']."</th>"; 
                                                           $grupo = $row_GrupEspec['grupocategoriaid'];
                                                           mysql_free_result($GrupEspec);
                                               }
                                   ?> 
          </tr>
          <tr>
            <td id="tbldetname"><?php echo $row_GrupoDetalle['descripcion']; ?> </td>
            <td id="tblvalue"><?php echo $row_GrupoDetalle['valorpresentacion']; ?></td>
          </tr>
        </tbody>
      
      <?php } while ($row_GrupoDetalle = mysql_fetch_assoc($GrupoDetalle));?>
      </table>
      <?php
				}  			
	  ?>
	        <div class='margen_derecho'>
				<?php
				require("ultimos_visitados.php");
				echo "<div class='mostrar_comparar'>";
				if($num_comparar > 0)
				{
					include("mostrar_comparar.php");
				}
				echo"</div>";
			?>
			</div>
			<!-- InstanceEndEditable -->
				
			</div>
	</div>
    <div class='pie'>
        <p style="line-height:10pt;">Pivic Technologic Data S.L. - 08027 Barcelona - Tel. 669 031803 - correo electrónico: <a href="mailto:info@pivicdata.com">info@pivicdata.com</a> <br>
Reg. Mercantil de Barcelona Tomo 38940, Folio 208, Hoja B 332759, Inscripción 1ª</p
    ></div>
<script>
  $(document).write('<script src=' +
  ('__proto__' in {} ? 'javascripts/vendor/zepto' : 'javascripts/vendor/jquery') +
  '.js><\/script>');
  </script>
  
  <script src="javascripts/foundation/foundation.js"></script>
    <!--<script src="javascripts/funcionesJ.js" type="text/javascript"></script>-->
<?php 
	include("javascripts/funcionesJ.js.php");
?>
	
	<script src="javascripts/foundation/foundation.alerts.js"></script>
	
	<script src="javascripts/foundation/foundation.clearing.js"></script>
	
	<script src="javascripts/foundation/foundation.cookie.js"></script>
	
	<script src="javascripts/foundation/foundation.dropdown.js"></script>
	
	<script src="javascripts/foundation/foundation.forms.js"></script>
	
	<script src="javascripts/foundation/foundation.joyride.js"></script>
	
	<script src="javascripts/foundation/foundation.magellan.js"></script>
	
	<script src="javascripts/foundation/foundation.orbit.js"></script>
	
	<script src="javascripts/foundation/foundation.placeholder.js"></script>
	
	<script src="javascripts/foundation/foundation.reveal.js"></script>
	
	<script src="javascripts/foundation/foundation.section.js"></script>
	
	<script src="javascripts/foundation/foundation.tooltips.js"></script>
	
	<script src="javascripts/foundation/foundation.topbar.js"></script>
	
  
  <script>
    $(document).foundation();
  </script>
</body>
<!-- InstanceEnd -->
<?php 
mysql_free_result($GrupoDetalle);
mysql_free_result($cantidadRS);
?>
</html>