<?php

// Check for empty fields
if(empty($_POST['name'])      ||
   empty($_POST['email'])     ||
   empty($_POST['phone'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	   //echo "No arguments Provided!";
	   $return["error"] = true;
   }
   
$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));
 
require("../PHPMailer-master/PHPMailerAutoload.php");
$mail = new PHPMailer();

//Luego tenemos que iniciar la validación por SMTP:
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
//$mail->Host = "smtp.gmail.com";  
$mail->Host = "p3plcpnl0882.prod.phx3.secureserver.net";  

$mail->Username = "administracion@umgsalud.com"; 
$mail->Password = "administracion2018"; 
//$mail->Username = "digipayargentina@gmail.com";  
//$mail->Password = "digipay2016"; 
$mail->Port = 465;  

$mail->From = "administracion@umgsalud.com "; // Desde donde enviamos (Para mostrar)
$mail->FromName = "Contacto web";

//Estas dos líneas, cumplirían la función de encabezado (En mail() usado de esta forma: “From: Nombre <correo@dominio.com>”) de //correo.
//$mail->AddAddress("nyndecoratuvida@gmail.com ");
//$mail->AddAddress("adrian.magliola@gmail.com");
$mail->AddAddress("administracion@umgsalud.com");
$mail->IsHTML(true); // El correo se envía como HTML
$mail->Subject = "UMG SALUD: Contacto WEB"; // Este es el titulo del email.

$body = "<strong>Nombre: </strong>".$_POST['name']."<br>";
$body .= "<strong>Email: </strong>".$_POST['email']."<br>";

if(isset($_POST['subject']))
	$body .= "<strong>Asunto: </strong>".$_POST['subject']."<br>";

$body .= "<strong>Mensaje: </strong>".$_POST['message']."<br>";


$mail->Body = $body;  
$exito = $mail->Send(); // Envía el correo.

//También podríamos agregar simples verificaciones para saber si se envió:
if($exito){
	//$resultado = "El correo fue enviado correctamente, el mismo será respondido a la brevedad. <br> Muchas gracias por su consulta.";
	$return["error"] = false;
}else{
	//$resultado = "Hubo un inconveniente. Por favor, intentá nuevamente o escribrinos a nuestro email: <b> nyndecoratuvida@gmail.com  </b> <br> Muchas gracias por su consulta.";
	$return["error"] = true;
}
 
print json_encode($return);	
?>