<?php
 //escribir texto para el mensaje
$mensaje = 'Hola 

Te estoy enviando un mensaje de prueba

Saludos
Alex';

//envio del mensaje
if(mail("alexis.bedoya@hotmail.es", "Probando enviar un correo desde php", $mensaje)){
	echo "email enviado exitoso";
}else{
	echo "fallo del envio del mensaje";
}

?>