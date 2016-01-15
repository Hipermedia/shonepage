<?php
require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'ssl://email-smtp.us-east-1.amazonaws.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'AKIAJBXYW7RMDRWVXDBA';                 // SMTP username
$mail->Password = 'AnchG5JB7zM4H4DKcUhFbN3ORYo7kpZGK+alqjV3jIVt';                           // SMTP password
$mail->SMTPSecure = 'ssl';                           	// Enable encryption, 'ssl' or 'tls' also accepted
$mail->Port = '465';									//Select port to stablish connection , 'ssl' (465) or 'tls' (587).

$mail->From = 'servicio.de.correo@solucioneshipermedia.com';
$mail->FromName = 'Soluciones Hipermedia';
$mail->addAddress('soporte@metrorama.mx', 'Hibam Iru SH');     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('info@solucioneshipermedia.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Asunto del mensaje - Ñú';
$mail->Body    = 'Cuerpo del mensaje <b>¡Ñú!</b>';
$mail->AltBody = 'Cuerpo del mensaje ¡Ñú!';
//$mail->Encoding = 'base64';
$mail->CharSet = 'utf8';								//Defines charset to utf8 to display latin characters

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}