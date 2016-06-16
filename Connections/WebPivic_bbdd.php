<?php
if(!isset($_SESSION))
{
	session_start();	
}

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_WebPivic_bbdd = "localhost";
$database_WebPivic_bbdd = "victor";
$username_WebPivic_bbdd = "root";
$password_WebPivic_bbdd = "";
$WebPivic_bbdd = mysql_pconnect($hostname_WebPivic_bbdd, $username_WebPivic_bbdd, $password_WebPivic_bbdd) or trigger_error(mysql_error(),E_USER_ERROR); 
?>