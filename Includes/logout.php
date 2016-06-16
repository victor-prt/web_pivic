<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_IdUsuario'] = NULL;
  unset($_SESSION['MM_IdUsuario']);	
  $logoutGoTo = getenv('HTTP_REFERER');
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
echo "<div id='infousuario'><div id='nombreusuario'>Bienvenido/a ".ObtenerNombreUsuario($_SESSION['MM_IdUsuario'])."</div>
<div id='modificarusuario'><img src='images/options.png'><a href='modificar.php' class='signin'>Ajustes de cuenta</a></div>
<div id='logout'><img src='images/desconectar.png'><a href='".$logoutAction."' class='signin'>Desconectar</a></div></div>";
?>

