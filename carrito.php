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

$sesion_pedido = "-1";
if (isset($_SESSION['MM_sesion'])) {
  $sesion_pedido = $_SESSION['MM_sesion'];
}
mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
$query_pedido = sprintf("SELECT pedido.PedIdProducto, pedido.PedCantidad, pedido.PedPrecio FROM pedido WHERE pedido.ID = %s", GetSQLValueString($sesion_pedido, "int"));
$pedido = mysql_query($query_pedido, $WebPivic_bbdd) or die(mysql_error());
$row_pedido = mysql_fetch_assoc($pedido);
$totalRows_pedido = mysql_num_rows($pedido);

mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
$query_iva = "SELECT iva.iva FROM iva WHERE iva.Id=1";
$iva = mysql_query($query_iva, $WebPivic_bbdd) or die(mysql_error());
$row_iva = mysql_fetch_assoc($iva);
$totalRows_iva = mysql_num_rows($iva);
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
            <h1 class='carritotitle'>Carrito de la compra</h1>
			<?php
			if($totalRows_pedido == 0)
				echo "su carrito está vacío";
			else{
			$precio_total = 0;
			$subtotal = 0;
			echo "<ul class='carrito_lista'>";
			do{
			echo "<li class='producto_carrito'>";
				echo"<img src='images/fotosthumbs/".ObtenerImagen($row_pedido['PedIdProducto'])."'>";				
					echo "<div class='cont_nombre_carrito'>";
						echo"<div class='nombre_carrito_large'>";
						echo ObtenerNombreProducto( $row_pedido['PedIdProducto']);
						echo "</div>";
						echo "<div class='nombre_carrito_min'>".substr(ObtenerNombreProducto($row_pedido['PedIdProducto']), 0,50)."...</div>";
					echo "</div>";
					echo "<form class='delete_form' action='eliminar.php' method='POST'>";
						echo "<input type='hidden' value='".$row_pedido['PedIdProducto']."' name='carrito_producto' >";
						echo"<button class='eliminar_button'><img src='images/eliminar1.png'></button>";
					echo "</form>";
					echo "<div class='carrito_precio_total'>".$row_pedido['PedPrecio'] * $row_pedido['PedCantidad']." €</div>";
					echo "<form class='cantidades' action='cantidades_carrito.php' method='POST'>";
						echo "<input type='text' name='carrito_cantidad' class='carrito_cantidad' onchange='this.form.submit()' value='".$row_pedido['PedCantidad']."'>";
						echo"<input type='hidden' name = 'carrito_producto' value='".$row_pedido['PedIdProducto']."'>";
					echo"</form>";
					echo "<div class='carrito_precio'>".$row_pedido['PedPrecio']." €</div>"; 
					echo "</li>";
					$subtotal = $row_pedido['PedPrecio'] * $row_pedido['PedCantidad']; 
					$precio_total += $subtotal;
			} while($row_pedido = mysql_fetch_assoc($pedido));
			echo "</ul>";
			echo "<div class='contenedor_precio_total'>";
			$iva = round($precio_total * $row_iva['iva'], 2, PHP_ROUND_HALF_UP);
			echo "<div class='precio_final'>".$precio_total." €</div>";
			echo "<div class='nombre_pagar'>SUBTOTAL:</div><br/><br/>";
			echo "<div class='precio_final'>".$iva." €</div>";
			echo "<div class='nombre_pagar'>IVA (".($row_iva['iva']*100)."%) :</div><br/><br/>";
			$_SESSION['MM_precio']= $precio_total + $iva;
			echo "<div class='precio_total_final'>".$_SESSION['MM_precio']." €</div>";
			echo "<div class='nombre_pagar_final'>TOTAL + IVA:</div><br/><br/>";
			echo "</div>";
			echo"<div id='pagar_btn'>";
            echo "<a href='finalizar.php'>Finalizar compra</a>";
            echo"</div>";
		}
			?>
			<div class="contenedor_precio_total_min">
			<?php
				echo $_SESSION['MM_precio']." €";
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
<!-- InstanceEnd --></html>
<?php
mysql_free_result($pedido);
//mysql_free_result($iva);
mysql_close($WebPivic_bbdd);

?>