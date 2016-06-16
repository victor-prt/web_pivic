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

$varSesion_update_user = "-1";
if (isset($_SESSION['MM_IdUsuario'])) {
  $varSesion_update_user = $_SESSION['MM_IdUsuario'];
}
mysql_select_db($database_WebPivic_bbdd, $WebPivic_bbdd);
$query_update_user = sprintf("SELECT usuario.Nombre, usuario.Apellidos, usuario.Email FROM usuario WHERE usuario.IdUsuario = %s", GetSQLValueString($varSesion_update_user, "int"));
$update_user = mysql_query($query_update_user, $WebPivic_bbdd) or die(mysql_error());
$row_update_user = mysql_fetch_assoc($update_user);
$totalRows_update_user = mysql_num_rows($update_user);
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
            <div class='contenedor_registro large-10 small-12 large-offset-1'>
                <form id='update_form' action="actualizar_registro.php" method='POST'>
					<h1 class='acceder_cuenta'>Ajustes de cuenta</h1>
                    <label>NOMBRE</label>
      				<input type='text' name='nombre' id='info_update' readonly value='<?php echo $row_update_user['Nombre']; ?>'>
                    <label>APELLIDOS</label>
                    <input type='text' name='apellidos' id='info_update' readonly value='<?php echo $row_update_user['Apellidos']; ?>'>
                    <label>EMAIL ACTUAL</label>
                    <input type='text' name='mail' id='info_update_mail' readonly value='<?php echo $row_update_user['Email']; ?>'>
                    <a href='...' class='cambiar_email'>Cambiar email</a><br>
                    <div class='email_nuevo'>
                    <label>NUEVO EMAIL</label>
                    <input type='text' name='mail2' id='mail2'>
                    <label >CONFIRMAR NUEVO EMAIL</label>
                    <input type='text' name='mail3' id='mail3'>
                    </div>
                    <a href='...' class='cambiar_pass'>Cambiar contraseña</a><br>
                    <div class='pass_nuevo'>
                    <label>CONTRASE&Ntilde;A ACTUAL</label>                    
                    <input type='password' name='pass' id='pass'>
                    <label>CONTRASE&Ntilde;A NUEVA</label>
                    <input type='password' name='pass2' id='pass2'>
                    <label>CONFIRME CONTRASE&Ntilde;A</label>
                    <input type='password' name='pass3' id='pass3'>
                    </div>                     
                    <button id='modify_submit'>Guardar cambios</button>
                </form>
                <div id='modify_ack'></div>
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
?>