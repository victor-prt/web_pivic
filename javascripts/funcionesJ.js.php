<script type="text/Javascript">
/**efecto deslizante menu**/
$(document).ready(function(){
	$('.fam li').hover(function(){
		$(this).find('>.subfam1').stop(true,true).slideDown("fast");
	}, function(){
		$(this).find('>.subfam1').stop(true,true).slideUp("fast");
	});
	$('.fam li').hover(function(){
		$(this).find('>.subfam2').stop(true,true).slideDown("fast");
	}, function(){
		$(this).find('>.subfam2').stop(true,true).slideUp("fast");
	});
	$('.fam li').hover(function(){
		$(this).find('>.subfam3').stop(true,true).slideDown("fast");
	}, function(){
		$(this).find('>.subfam3').stop(true,true).slideUp("fast");
	});
});
/**adaptar columnas menu al ancho de la pagina**/
$(document).ready(function(){
	$('.subfam3').hover(function(){
		var tam = $('.subfam3 > li').size();
		for(var i = 0; i < tam; i = i + 3){
			$('.subfam3 > li:nth-child(' + i + ') > .fab').css(
					'left','-114px'
				);
			$('.subfam3 > li:nth-child(' + i + ') > .fab1').css(
					'left','-228px'
				);
		}
		for(var i = 2; i < tam; i = i + 3)
		{
			$('.subfam3 > li:nth-child('+ i + ') > .fab1').css('width','180px');
		}
	});
	$('.subfam2').hover(function(){
		var tam =$('.subfam2 > li').size();
		for(var i = 0; i < tam; i = i + 2)
		{
			$('.subfam2 > li:nth-child(' + i +') > .fab1').css('width','180px');
		}
	});
});
/* Vertical Image Allign */
$(window).load(function(){
	var cant = $('.contenido  li').size();
	var alto = $('.cont_imagen').height();
	for(var i = 1; i <= cant;i++)
	{
		var alto_imagen = $('.contenido li:nth-child('+i+') .cont_imagen > .imagen' ).height();
		var margen_superior = (alto - alto_imagen)/2;

		$('.contenido li:nth-child('+i+') .cont_imagen > .imagen').css('top', margen_superior);
	}
});
/**********desplegar registro pag grande***********/
var mouse_is_inside = false;

$(document).ready(function() {
    $(".login_btn").click(function() {
        var loginBox = $("#registro_caja");
        if (loginBox.is(":visible"))
            loginBox.fadeOut("fast");
        else
            loginBox.fadeIn("fast");
        return false;
    });
    
    $("#registro_caja").hover(function(){ 
        mouse_is_inside=true; 
    }, function(){ 
        mouse_is_inside=false; 
    });

    $("body").click(function(){
        if(! mouse_is_inside) $("#registro_caja").fadeOut("fast");
    });
});

/***************Login usuario*******************/
var numeros="0123456789";

function tiene_numeros(texto){
   for(var k=0; k<texto.length; k++){
      if (numeros.indexOf(texto.charAt(k),0)!=-1){
         return 1;
      }
   }
   return 0;
} 

var res = 0;
$('button.login_submit').click(function(){
	if( $('.usuario').val() == '' || $('.password').val() == '' )
		$('div.login_ack').html('Por favor, escriba su e-mail y su contrase&ntildea');
	else
		$.post( $('.login_form').attr('action'),
				$('.login_form :input').serializeArray(),
				function(data) {
					res = tiene_numeros(data);
					if(!res)
						$('div.login_ack').html(data);				
					else if(document.URL == 'http://localhost/pivic_buena/finalizar.php'){//cambiar por la direccion verdadera
						window.location = 'finalizar.php';
					}
					else
						window.location = 'index.php';
				});

			$('.login_form').submit( function() {
					return false;	
				});
	});
/***********Registro usuario************/
function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
 

$('button.register_submit').click(function(){
	var email_correcto = $('.mail').val();
	var largo_password = $('.pass').val();
	if( $('.nombre_usuario').val() == '' || $('.apellidos').val() == '' || $('.mail').val() == '' || $('.mail2').val() == '' || $('.pass').val() == '' || $('.pass2').val() == '' )
		$('div.register_ack').html('Por favor, rellene todos los campos del formulario');
	else if($('.mail').val() != $('.mail2').val())
		$('div.register_ack').html('Los valores de e-mail no coinciden');
	else if($('.pass').val() != $('.pass2').val())
		$('div.register_ack').html('Los valores de contrase&ntildea no coinciden');
	else if(!validateEmail(email_correcto))
		$('div.register_ack').html('Direcci&oacuten de e-mail no v&aacutelida');
	else{
		$.post( $('.register_form').attr('action'),
				$('.register_form :input').serializeArray(),
				function(data) {
					res = tiene_numeros(data);
					if(!res)
						$('div.register_ack').html(data);
					else
						window.location = 'index.php';	
				});
		}
			$('.register_form').submit( function() {
					return false;	
				});
	});

/*******mostrar formulario registro-acceso********/
$(document).ready(function() {
	$('.abrir_registro').click(function(){
		$('.login_form').hide();
		$('.acceder_cuenta').hide();
		$('.login_ack').hide();
		$('.login_message').hide();
		$('.condiciones').fadeIn();
		$('.register_form').fadeIn();
		$('.register_ack').fadeIn();
		$('.register_message').fadeIn();
		$('.crear_cuenta').fadeIn();
		return false;
	});
	$('.abrir_acceso').click(function(){
		$('.register_form').hide();
		$('.crear_cuenta').hide();
		$('.register_ack').hide();
		$('.condiciones').hide();
		$('.register_message').hide();
		$('.login_form').fadeIn();
		$('.acceder_cuenta').fadeIn();
		$('.login_ack').fadeIn();
		$('.login_message').fadeIn();
		return false;
	});

});
/************cambiar contraseña-email***************/
$(document).ready(function(){
	$('.cambiar_email').click(function(){
		if($('.email_nuevo').is(':visible'))
			$('.email_nuevo').fadeOut();
		else
			$('.email_nuevo').fadeIn();
		return false;
	});
	$('.cambiar_pass').click(function(){
		if($('.pass_nuevo').is(':visible'))
			$('.pass_nuevo').fadeOut();
		else
			$('.pass_nuevo').fadeIn();
		return false;
	});
	$('.unregistered .registrar_boton').addClass('pestana_actual');
	$('.comprador_boton').addClass('pestana_actual');
	$('.unregistered .comprador_boton').removeClass('pestana_actual');

});

/******Modificar datos*******/
function ClearInput(){
	$('#mail2').each(function(){
		$(this).val('');
	});
	$('#mail3').each(function(){
		$(this).val('');
	});
	$('#pass').each(function(){
		$(this).val('');
	});
	$('#pass2').each(function(){
		$(this).val('');
	});
	$('#pass3').each(function(){
		$(this).val('');
	});
}
$('button#modify_submit').click(function(){
	if( $('#mail2').val() == '' && $('#pass2').val() == '' )
		$('div#modify_ack').html('No ha modificado nada de su cuenta');
	else if( $('#mail2').val() != $('#mail3').val() )
		$('div#modify_ack').html('Los valores de email no coinciden');
	else if( $('#mail2').val() != ''  && (!validateEmail($('#mail2').val())))
		$('div#modify_ack').html('Direcci&oacuten de e-mail no v&aacutelida');
	else if($('#pass2').val() != $('#pass3').val())
		$('div#modify_ack').html('los valores de contrase&ntildea no coinciden');
	else
		$.post( $('#update_form').attr('action'),
				$('#update_form :input').serializeArray(),
				function(data) {
					res = tiene_numeros(data);
					if(!res){
						alert(data);
						window.location = 'modificar.php';
					}
					else
						$('div#modify_ack').html(data);
				});
			$('#update_form').submit( function() {
					return false;	
				});

	});
/*********efecto eliminar del carrito*********/
$('.eliminar_button').click(function(){
	$(this).parent().parent().fadeOut();
	window.location = 'carrito.php';
});

/************registrar al finalizar compra*************/
function justNumbers(e)
{
var keynum = window.event ? window.event.keyCode : e.which;
if ((keynum == 8) || (keynum == 46) || (keynum == 09))
return true;
 
return /\d/.test(String.fromCharCode(keynum));
}

$('.registermin_submit').click(function(){
	if( $('.mail').val() == '')
		$('.register_ack').html('Por favor introduzca un e-mail');
	else if (!validateEmail($('.mail').val()))
		$('.register_ack').html('Direcci&oacuten de e-mail no v&aacutelida');
	else{
		$.post( $('.registermin_form').attr('action'),
				$('.registermin_form :input').serializeArray(),
				function(data) {
					res = tiene_numeros(data);
					if(!res){
						$('.register_ack').html(data);
					}
					else{
						$('.finalizar_registro').hide();
						$('.finalizar_acceso').hide();
						$('.unregistered_form').fadeIn();
						$('.unregistered_form #mail').val($('.mail').val());
						$('.finish_ack').fadeIn();
						$('.condiciones').fadeIn();
						$('.unregistered').fadeIn();
					}
				});
		}
			$('.registermin_form').submit( function() {
					return false;	
			});
	});
$('.finish_submit').click(function(){
	if($('.nombre_usuario').val() == '' || $('.apellidos').val() == '' || $('#mail').val() =='' || $('.mail2').val() == '' || $('.pass').val() == '' || $('.pass2').val() == '')
	{
		$('.pago_registro').fadeIn();
		$('.pago_forma').hide();
		$('.pago_boton').removeClass('pestana_actual');
		$('.registrar_boton').addClass('pestana_actual');
		$('.finish_ack').html("Por favor, rellene todos los campos del formulario");
	}
	else if($('.NIF').val() == '' || $('.direccion').val() == '' || $('.CP').val() == '' || $('.poblacion').val() == '' || $('.provincia').val() == '' || $('.fijo').val() == '' || $('.movil').val() == '')
	{
		$('.pago_forma').hide();
		$('.pago_comprador').fadeIn();
		$('.pago_boton').removeClass('pestana_actual');
		$('.comprador_boton').addClass('pestana_actual');
		$('.finish_ack').html("Por favor, rellene todos los campos del formulario");
	}
	else if($('.nombree').val() == '' || $('.provinciae').val() == '' || $('.apellidose').val() == '' || $('.direccione').val() == '' || $('.poblacione').val() == '' || $('.CPe').val() == '' || $('.tele').val() == '')
	{
		$('.pago_forma').hide();
		$('.pago_envio').fadeIn();
		$('.finish_ack').html("Por favor, rellene todos los campos del formulario");
		$('.pago_boton').removeClass('pestana_actual');
		$('.envio_boton').addClass('pestana_actual');
	}
	else if(!validateEmail($('#mail').val()))
	{
		$('.pago_forma').hide();
		$('.pago_registro').fadeIn();
		$('.pago_boton').removeClass('pestana_actual');
		$('.registrar_boton').addClass('pestana_actual');
		$('.finish_ack').html('Direcci&oacuten de e-mail no v&aacutelida');
	}
	else if($('#mail').val() != $('.mail2').val())
	{
		$('.pago_registro').fadeIn();
		$('.pago_forma').hide();
		$('.registrar_boton').addClass('pestana_actual');
		$('.pago_boton').removeClass('pestana_actual');
		$('.finish_ack').html('Los valores de e-mail no coinciden');
	}
	else if($('.pass').val() != $('.pass2').val())
	{
		$('.pago_registro').fadeIn();
		$('.pago_forma').hide();
		$('.registrar_boton').addClass('pestana_actual');
		$('.pago_boton').removeClass('pestana_actual');
		$('.finish_ack').html('Los valores de contrase&ntildea no coinciden');
	}
	else{
		$.post( $('.unregistered_form').attr('action'),
				$('.unregistered_form :input').serializeArray(),
				function(data) {
					res = tiene_numeros(data);
					if(!res){
						$('.login_ack').html(data);
					}
					else{
						window.location = 'index.php';
					}
				});
		}
	$('.unregistered_form').submit(function(){
		return false;
	});
});
function mail(email){
	$('#mail').val(email);
}
/************acceso al finalizar la compra*************/
$('#compra_submit').click(function(){
	if($('.NIF').val() == '' || $('.direccion').val() =='' || $('.CP').val() == '' || $('.poblacion').val() =='' || $('.provincia').val() == '' || $('.fijo').val() == '' || $('.movil').val() == '')
	{
		$('.finish_ack').fadeIn();
		$('.pago_forma').hide();
		$('.pago_comprador').fadeIn();
		$('.pago_boton').removeClass('pestana_actual');
		$('.comprador_boton').addClass('pestana_actual');
		$('.finish_ack').html('Por favor, rellene todos los campos del formulario');
	}
	else if( $('.nombree').val() == '' || $('.apellidose').val() == '' || $('.direccione').val() == '' || $('.poblacione').val() == '' || $('.CPe').val() == '' || $('.provinciae').val() == '' || $('.tele').val() == '')
	{
		$('.finish_ack').fadeIn();
		$('.pago_envio').fadeIn();
		$('.pago_forma').hide();
		$('.pago_boton').removeClass('pestana_actual');
		$('.envio_boton').addClass('pestana_actual');
		$('.finish_ack').html('Por favor, rellene todos los campos del formulario');
	}
	else{
		$.post( $('#compra_form').attr('action'),
				$('#compra_form :input').serializeArray(),
				function(data) {
					res = tiene_numeros(data);
					if(!res){
						$('.finish_ack').html(data);
					}
					else{
						window.location = 'index.php';
					}
				});
		}
	$('#compra_form').submit(function(){
		return false;
	});
});
/*******************pestañas pago*********************/
$('.comprador_boton').click(function(){
	if($('.pago_registro').is(":visible") || $('.pago_envio').is(":visible") || $('.pago_forma').is(":visible"))
	{
		$('.pago_registro, .pago_forma, .pago_envio').hide();
		$('.pago_comprador').fadeIn();
		$('.registrar_boton, .pago_boton, .envio_boton').removeClass('pestana_actual');
	}
	$(this).addClass('pestana_actual');
	return false;
});
$('.registrar_boton').click(function(){
	if($('.pago_comprador').is(":visible") || $('.pago_envio').is(":visible") || $('.pago_forma').is(":visible"))
	{
		$('.pago_comprador, .pago_forma, .pago_envio').hide();
		$('.pago_registro').fadeIn();
		$('.comprador_boton, .envio_boton, .pago_boton').removeClass('pestana_actual');
	}
	$(this).addClass('pestana_actual');
	return false;
});
$('.envio_boton').click(function(){
	if($('.pago_registro').is(":visible") || $('.pago_comprador').is(":visible") || $('.pago_forma').is(":visible"))
	{
		$('.pago_registro, .pago_forma, .pago_comprador').hide();
		$('.pago_envio').fadeIn();
		$('.comprador_boton, .pago_boton, .registrar_boton').removeClass('pestana_actual');
	}
	$(this).addClass('pestana_actual');
	return false;
});
$('.pago_boton').click(function(){
	if($('.pago_comprador').is(":visible") || $('.pago_envio').is(":visible") || $('.pago_registro').is(":visible"))
	{
		$('.pago_registro, .pago_comprador, .pago_envio').hide();
		$('.pago_forma').fadeIn();
		$('.registrar_boton, .comprador_boton, .envio_boton').removeClass('pestana_actual');
	}
	$(this).addClass('pestana_actual');
	return false;
});
/***********pestaña actual**********/

/*********tipo de pago***********/
function handleSelect(form_pago){
	var selIndex = form_pago.optionList.selectedIndex;
	if(selIndex == 0)
	{
		$('#paypal, #transferencia').hide();
		$('#visa').fadeIn();
	}
	else if(selIndex == 1)
	{
		$('#paypal').fadeIn();
		$('#visa, #transferencia').hide();
	}
	else if(selIndex == 2)
	{
		$('#transferencia').fadeIn();
		$('#visa, #paypal').hide();
	}	
}
/**********deslizante menu usuario***********/
$(document).ready(function(){
$('.options').click(function(){
	if($('.menu_usuario').is(':visible'))
	{
		$('.menu_usuario').animate({left: '0px'}, 750).fadeOut();
		//$('.options').animate({left: '-=80%'},750);
		//$('.contenedor').animate({left: '-=90%'},750);
		//$('.cabecera').animate({left: '-=90%'},750);
		//$('.pie').animate({left: '-=90%'},750);
	}
	else{
		//if($('body').width() <= '485')
		//{
			$('.menu_usuario').fadeIn();//css('display','block');
			//$('.options').animate({left: '+=80%'},750);
			//$('.cabecera').animate({left: '+=90%'}, 750);
			//$('.contenedor').animate({left: '+=90%'},750);
			//$('.pie').animate({left: '+=90%'},750);
			$('.menu_usuario').animate({left: '+=100%'},750).css('position','fixed');
		/*}
		else{
			$('.menu_usuario').css('display','none')
		}*/
	}
	return false;
});
$(".menu_usuario").hover(function(){ 
        mouse_is_inside=true; 
    }, function(){ 
        mouse_is_inside=false; 
    });
$("body").click(function(){
    if(! mouse_is_inside) 
    	$(".menu_usuario").animate({left: '-=100%'},750).fadeOut();
   });
});
/**********menu movil*********/
$(document).ready(function() {
    //$(".movil").accordion({collapsible: true, active: false});
});
/**********Eliminar todos comparar***********/
$('.deleteall_submit').click(function(){
		$.post( $('.delete_all').attr('action'),
		$('.delete_all :input').serializeArray());						
		$('.delete_all').submit( function(e) {
			return false;
		});
		$('.mostrar_comparar').load('mostrar_comparar.php');
});

/**********envio formulario cantidades***********/
$('#submit_comprar_detalles').click(function(){
		$.post( $('#comprar_detalles').attr('action'),
		$('#comprar_detalles :input').serializeArray());						
		$('#comprar_detalles').submit( function(e) {
			e.stopPropagation();
			e.preventDefault();
		});
});
/****************Compra detalles versión movil*******************/
$('#submit_comprar_detalles_min').click(function(){
	$.post( $('#comprar_detalles_min').attr('action'),
	$('#comprar_detalles_min :input').serializeArray());
	$('#comprar_detalles_min').submit(function(e){
		e.stopPropagation();
		e.preventDefault();
	});
});
/********mantener scroll****/
/*
window.onload=function(){
var pos=window.name || 0;
window.scrollTo(0,pos);
}
window.onunload=function(){
window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
}*/
</script>