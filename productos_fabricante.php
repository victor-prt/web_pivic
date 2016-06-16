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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_fabricante = 18;
$pageNum_fabricante = 0;
if (isset($_GET['pageNum_fabricante'])) {
  $pageNum_fabricante = $_GET['pageNum_fabricante'];
}
$startRow_fabricante = $pageNum_fabricante * $maxRows_fabricante;

$VarFamilia_fabricante = "-1";
if (isset($_GET['familia'])) {
  $VarFamilia_fabricante = $_GET['familia'];
}
$VarSubFamilia_fabricante = "-1";
if (isset($_GET['subfamilia'])) {
  $VarSubFamilia_fabricante = $_GET['subfamilia'];
}
$VarFabricante_fabricante = "0";
if (isset($_GET['fabricante'])) {
  $VarFabricante_fabricante = $_GET['fabricante'];
}
mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
$query_fabricante = sprintf("SELECT NombreProducto, Precio, Fotobaja, CodigoProducto, Logo FROM articulos INNER JOIN fabricantes ON IdPivic = articulos.Fabricante WHERE articulos.Familia = %s AND articulos.Subfamilia = %s AND  articulos.Fabricante = %s AND articulos.MarcaInternet = 'S' AND articulos.Fabricante > 0 ORDER BY precio", GetSQLValueString($VarFamilia_fabricante, "text"),GetSQLValueString($VarSubFamilia_fabricante, "text"),GetSQLValueString($VarFabricante_fabricante, "int"));
$query_limit_fabricante = sprintf("%s LIMIT %d, %d", $query_fabricante, $startRow_fabricante, $maxRows_fabricante);
$fabricante = mysql_query($query_limit_fabricante, $WebPivic_bbdd) or die(mysql_error());
$row_fabricante = mysql_fetch_assoc($fabricante);
$query_comparar = "SELECT IdProducto FROM comparar WHERE IdSesion = ".$_SESSION['MM_sesion'];
$comparar = mysql_query($query_comparar,$WebPivic_bbdd);
$row_comparar = mysql_fetch_assoc($comparar);
$num_comparar = mysql_num_rows($comparar);	
if (isset($_GET['totalRows_fabricante'])) {
  $totalRows_fabricante = $_GET['totalRows_fabricante'];
} else {
  $all_fabricante = mysql_query($query_fabricante);
  $totalRows_fabricante = mysql_num_rows($all_fabricante);
}
$totalPages_fabricante = ceil($totalRows_fabricante/$maxRows_fabricante);

$queryString_fabricante = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fabricante") == false && 
        stristr($param, "totalRows_fabricante") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_fabricante = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_fabricante = sprintf("&totalRows_fabricante=%d%s", $totalRows_fabricante, $queryString_fabricante);
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
            <div class='navegador'>
            <?php
            	echo "<a href='index.php'>Home</a> > <a href='productos_familia.php?familia=".$VarFamilia_fabricante."'>".ObtenerNombreFamilia($VarFamilia_fabricante)."</a> > <a href='productos_subfamilia.php?familia=".$VarFamilia_fabricante."&subfamilia=".$VarSubFamilia_fabricante."'>".ObtenerNombreSubFamilia($VarFamilia_fabricante,$VarSubFamilia_fabricante)."</a> > ".ObtenerNombreFabricante($VarFabricante_fabricante);
			?>
            </div>
			<?php echo "<h1 class='h1productos'>".ObtenerNombreSubFamilia($VarFamilia_fabricante,$VarSubFamilia_fabricante)."</h1>";?>
            <div class='organizador'>
            <?php
            	echo "   ".($startRow_fabricante + 1)." - ".min($startRow_fabricante + $maxRows_fabricante, $totalRows_fabricante)." de ". $totalRows_fabricante." artículos"; 
            ?>
            </div>
           	<div class='margen_der'>
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
           	<ul class='mostrador large-block-grid-3 small-block-grid-1'>
            <?php do { ?>
				<li>
					<div class='producto'>
					<?php
					echo "<div class='cont_imagen'>";
					if(!empty($row_fabricante['Fotobaja']))
						echo "<img src='images/fotosbaja/".$row_fabricante['Fotobaja']."' class='imagen'/>";
					else if(!empty($row_fabricante['Logo']))
						echo "<img src='images/fabricantes/".$row_fabricante['Logo']."' class='imagen'/>";
					else
						echo "<img src='images/nodisponible.jpg' class='imagen'/>";
					echo "</div>";
					echo "<div class='precio'>";
					echo $row_fabricante['Precio']." €";
					echo "</div>";
					?>
                    <form id='comparar<?php echo $row_fabricante['CodigoProducto'];?>' action='anadir_comparar.php' method='POST'>
                    	<input type='hidden' name='prod' value='<?php echo $row_fabricante['CodigoProducto'];?>'/>
                    	<button id='comp<?php echo $row_fabricante['CodigoProducto'];?>' class='comparar'>+Comparar</button>
                    </form>
                    <script type='text/javascript'>
					$('#comp<?php echo $row_fabricante['CodigoProducto'];?>').click(function(){
						$.post( $('#comparar<?php echo $row_fabricante['CodigoProducto']; ?>').attr('action'),
								$('#comparar<?php echo $row_fabricante['CodigoProducto']; ?> :input').serializeArray(),
								function(data) {
									res = tiene_numeros(data);
									if(res){
										alert("Solo se pueden comparar tres productos a la vez!");
									}
								});
							$('#comparar<?php echo $row_fabricante['CodigoProducto']; ?>').submit( function(e) {
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
					echo "<div class='cont_nombre'>";
					echo "<div class='nombre'><a href='detalles.php?producto=".$row_fabricante['CodigoProducto']."'>".$row_fabricante['NombreProducto']."</a></div>";
					echo "</div>";
					
					?>
					    <form id='comprar<?php echo $row_fabricante['CodigoProducto'];?>' action='cantidad_mostrador.php' method='POST'>
                    	<input type='hidden' name='producto' value='<?php echo $row_fabricante['CodigoProducto'];?>'/>
                        <button id='comprar_submit<?php echo $row_fabricante['CodigoProducto'];?>' class='boton_compra'><img src="images/carro.gif"/>Comprar</button>
                       </form>
                    <script type='text/javascript'>
					$('#comprar_submit<?php echo $row_fabricante['CodigoProducto'];?>').click(function(){
						$.post( $('#comprar<?php echo $row_fabricante['CodigoProducto']; ?>').attr('action'),
								$('#comprar<?php echo $row_fabricante['CodigoProducto']; ?> :input').serializeArray());
							$('#comprar<?php echo $row_fabricante['CodigoProducto']; ?>').submit( function(e) {
								e.stopPropagation();
								e.preventDefault();
							});
					});
                    </script>
					</div><!--producto -->
				</li>
                <?php
				} while ($row_fabricante = mysql_fetch_assoc($fabricante)); ?>
                </ul>
            <?php
            if($totalPages_fabricante > 1)
			{
			?>
            <div class='paginacion'>
            <ul>
            <div class='flechas'>
            <li><a href="<?php printf("%s?pageNum_fabricante=%d%s", $currentPage, max(0, $pageNum_fabricante - 1), $queryString_fabricante); ?>">&laquo;</a></li>
            </div>
            <?php
			if($pageNum_fabricante == 0)
			{
				echo "<div class='actual'>";//actual
			}
			?>
            <li><a href="<?php printf("%s?pageNum_fabricante=%d%s", $currentPage, min($totalPages_fabricante, 0), $queryString_fabricante); ?>"><?php echo "1";?></a></li>
			<?php
            if($pageNum_fabricante == 0)
			{
				echo "</div>";
			}
			if($pageNum_fabricante > 3)
			{
				echo "<li>...</li>";
			} 
				for($i = $pageNum_fabricante -1; $i <= $pageNum_fabricante + 3; $i++)
				{
						if($i > 1 && $i < $totalPages_fabricante)
						{
							if($i == ($pageNum_fabricante + 1))
							{
								echo "<div class='actual'>";//actual
							}
					?>
					<li><a href="<?php printf("%s?pageNum_fabricante=%d%s", $currentPage, min($totalPages_fabricante, $i -1), $queryString_fabricante); ?>"><?php echo $i;?></a></li>
           <?php 
							if($i == ($pageNum_fabricante + 1))
							{
								echo "</div>";
							}
						}
				}	
			if($pageNum_fabricante < $totalPages_fabricante-3)
			{
				echo "<li>...</li>";
			}	
			if($pageNum_fabricante == ($totalPages_fabricante-1))
			{
				echo "<div class='actual'>";
			}
			?>
            <li><a href="<?php printf("%s?pageNum_fabricante=%d%s", $currentPage, min($totalPages_fabricante, $totalPages_fabricante -1), $queryString_fabricante); ?>"><?php echo $totalPages_fabricante;?></a></li>
			<?php
            if($pageNum_fabricante == ($totalPages_fabricante-1))
			{
				echo "</div>";
			}
			if(($pageNum_fabricante+1) < $totalPages_fabricante)
			{
			?>
            <div class='flechas'>
            <li><a href="<?php printf("%s?pageNum_fabricante=%d%s", $currentPage, min($totalPages_fabricante, $pageNum_fabricante + 1), $queryString_fabricante); ?>">&raquo;</a></li>
            </div>
			<?php
			}
			else{
			?>
            <div class='flechas'>
            <li><a href="<?php printf("%s?pageNum_fabricante=%d%s", $currentPage, min($totalPages_fabricante, $pageNum_fabricante), $queryString_fabricante); ?>">&raquo;</a></li>
			</div>
			<?php
			}
			?>
            </ul>
            </div>
            <?php
			}
			?>
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
mysql_free_result($fabricante);
?>
