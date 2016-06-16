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
            <?php
				if(!isset($_SESSION['MM_IdUsuario'])){
			?>                <div class='finalizar_registro'>
                    <h2>Crear Cuenta/Nuevos clientes</h2>
                    <h3>Introduzca su email</h3>
                    <form class='registermin_form' action="comprobar_mail.php" method='POST'>
                        <input type='text' name='mail' class='mail' placeholder='EMAIL'/>
                        <button class='registermin_submit'>Crear cuenta</button>     
                    </form>
                    <div class='register_ack'></div>
               </div>
            	<div class='finalizar_acceso'>
                    <h2>Acceda a su cuenta</h2>
                    <form class='login_form' action='acceso.php' method='POST'>
                        <input type='text' name='usuario' class='usuario' placeholder='EMAIL'/>
                        <input type='password' name='password' class='password' placeholder='CONTRASEÑA'/>
                        <button class='login_submit'>Acceder</button>
                    </form> 
                    <div class='login_ack'></div>
                </div>

               <div class='unregistered'>
               	   <div class='pestana_compra'>
                        <div class='contenedor_boton'><a href='...' class='registrar_boton'>Registro</a></div>
                        <div class='contenedor_boton'><a href='...' class='comprador_boton'>Datos<br/>Comprador</a></div>
                        <div class='contenedor_boton'><a href='...' class='envio_boton'>Datos env&iacute;o</a></div>
                        <div class='contenedor_boton'><a href='...' class='pago_boton'>Datos de<br />Pago</a></div>
                   </div>
                </div>
                   <form class='unregistered_form' action="datos_compra.php" method='POST'>
                        <div class='pago_registro'>
                        	<p>Datos de registro de usuario:</p>
                            <input type='text' name='nombre' class='nombre_usuario' placeholder='NOMBRE'/>
                            <input type='text' name='apellidos' class='apellidos' placeholder='APELLIDOS'/>
                            <input type='text' name='mail' id='mail' placeholder='EMAIL' onChange="mail(document.getElementById('mail'))"/>
                            <input type='text' name='mail2' class='mail2' placeholder='CONFIRMAR EMAIL'/>
                            <input type='password' name='pass' class='pass' placeholder='CONTRASEÑA'/>
                            <input type='password' name='pass2' class='pass2' placeholder='CONFIRMAR CONTRASEÑA'/>                    	<div class='condiciones'>
                                Al registrarse en Pivic acepta nuestras condiciones de uso y nuestro aviso de privacidad.
                            </div>
                        </div>
                        <div class='pago_comprador'>
                        	<p>Información del comprador:</p>
                            <input type='text' name='NIF' class='NIF' placeholder='NIF' maxlength='10'/>
                            <input type='text' name='direccion' class='direccion' placeholder='DIRECCIÓN'/>
                            <input type='text' name='CP' class='CP' placeholder='CÓDIGO POSTAL' maxlength='5' onkeypress='return justnumbers(event);'/>
                            <input type='text' name='poblacion' class='poblacion' placeholder='POBLACIÓN' />
                            <input type='text' name='provincia' class='provincia' placeholder='PROVINCIA' />
                            <input type='tel' name='fijo' class='fijo' placeholder='TELÉFONO' maxlength='10' onkeypress='return justNumbers(event);'/>
                            <input type='tel' name='movil' class='movil' placeholder='MÓVIL' maxlength='9' onkeypress="return justNumbers(event);"/>
                        </div>
                        <div class='pago_envio'>
                        	<p>Dirección de envío:</p>                        
                            <input type='text' name='nombree' class='nombree' placeholder='NOMBRE DESTINATARIO' />
                            <input type='text' name='apellidose' class='apellidose' placeholder='APELLIDOS' />
                            <input type='text' name='direccione' class='direccione' placeholder='DIRECCIÓN'/>
                            <input type='text' name='poblacione' class='poblacione' placeholder='POBLACIÓN'/>
                            <input type='text' name='CPe' class='CPe' placeholder='CÓDIGO POSTAL' maxlength='10' onKeyPress='return justNumbers(event);' />
                            <input type='text' name='provinciae' class='provinciae' placeholder='PROVINCIA' />
                            <input type='tel' name='tele' class='tele' placeholder='TELÉFONO' maxlength='10' onKeyPress='return justNumbers(event);' />                  
                        </div>
                        <div class='pago_forma'>
                        	<p>Datos de forma de pago:</p>
                            <select name='optionList' id='optionList' onchange='handleSelect(this.form);'>
                            	<option  value='1' selected>Visa</option>
                                <option  value='2'>PayPal</option>
                                <option  value='3'>Transferencia</option>
                            </select>
                            	<div id='visa'>
                                	<input type='text' name='numero_tarjeta' id='numero_tarjeta' placeholder='NÚMERO DE TARJETA'/>
                                    <input type='text' name='caducidad' id='caducidad' placeholder='CADUCIDAD'/>
                                    <input type='text' name='cvc' id='cvc' placeholder='CVC'/>
                                </div>
                                <div id='paypal'>
                                	paypal	
                                </div>
                                <div id='transferencia'>
                                	transferencia
                                </div>
                            <button class='finish_submit'>Finalizar compra</button>     
                        </div>
                   </form>              
               <div class='finish_ack'></div>
            <?php
				}
				else{
			?>
            <div class='pestana_compra'>
            	<div class='contenedor_boton_grande'><a href='...' class='comprador_boton'>Datos</br>Comprador</a></div>
				<div class='contenedor_boton_grande'><a href='...' class='envio_boton'>Datos envío</a></div>
                <div class='contenedor_boton_grande'><a href='...' class='pago_boton'>Datos de</br>Pago</a></div>
            </div>
            <form id='compra_form' action='finalizar_registrado.php' method='POST'>
						<div class='pago_comprador'>
                        	<p>Información del comprador:</p>
                            <input type='text' name='NIF' class='NIF' placeholder='NIF' maxlength='10'/>
                            <input type='text' name='direccion' class='direccion' placeholder='DIRECCIÓN'/>
                            <input type='text' name='CP' class='CP' placeholder='CÓDIGO POSTAL' maxlength='5' onkeypress='return justnumbers(event);'/>
                            <input type='text' name='poblacion' class='poblacion' placeholder='POBLACIÓN' />
                            <input type='text' name='provincia' class='provincia' placeholder='PROVINCIA' />
                            <input type='tel' name='fijo' class='fijo' placeholder='TELÉFONO' maxlength='10' onkeypress='return justNumbers(event);'/>
                            <input type='tel' name='movil' class='movil' placeholder='MÓVIL' maxlength='9' onkeypress="return justNumbers(event);"/>
                        </div>
                        <div class='pago_envio'>
                        	<p>Dirección de envío:</p>                        
                            <input type='text' name='nombree' class='nombree' placeholder='NOMBRE DESTINATARIO' />
                            <input type='text' name='apellidose' class='apellidose' placeholder='APELLIDOS' />
                            <input type='text' name='direccione' class='direccione' placeholder='DIRECCIÓN'/>
                            <input type='text' name='poblacione' class='poblacione' placeholder='POBLACIÓN'/>
                            <input type='text' name='CPe' class='CPe' placeholder='CÓDIGO POSTAL' maxlength='10' onKeyPress='return justNumbers(event);' />
                            <input type='text' name='provinciae' class='provinciae' placeholder='PROVINCIA' />
                            <input type='tel' name='tele' class='tele' placeholder='TELÉFONO' maxlength='10' onKeyPress='return justNumbers(event);' />                  
                        </div>
                         <div class='pago_forma'>
                        	<p>Datos de forma de pago:</p>
                            <select name='optionList' id='optionList' onchange='handleSelect(this.form);'>
                            	<option  value='1' selected>Visa</option>
                                <option  value='2'>PayPal</option>
                                <option  value='3'>Transferencia</option>
                            </select>
                            	<div id='visa'>
                                	<input type='text' name='numero_tarjeta' id='numero_tarjeta' placeholder='NÚMERO DE TARJETA'/>
                                    <input type='text' name='caducidad' id='caducidad' placeholder='CADUCIDAD'/>
                                    <input type='text' name='cvc' id='cvc' placeholder='CVC'/>
                                </div>
                                <div id='paypal'>
                                	paypal	
                                </div>
                                <div id='transferencia'>
                                	Le mandaremos un correo electrónico con los datos pertinentes para realizar la transferencia. En cuanto realice dicha transferencia se procederá al envío de su compra en un plazo máximo de 24 horas.
                                </div>
                                <button id='compra_submit'>Finalizar Compra</button>
                                </div>
           </form>
           <div class='finish_ack'></div>
               <?php
				}
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