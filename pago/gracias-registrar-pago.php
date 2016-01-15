<?php require_once('header.php'); ?>
<?php //echo '<pre style="display:block;">'; print_r($_FILES); echo '</pre>'; // PRINT_R ?>
<div id="content">

<h1 class="page-name">Gracias por registrar tu depósito</h1>

<?php //Se reciben y asignan variables
	$nombre = ''; $apellido = ''; $correo = ''; $concepto = ''; $importe = ''; $sucursal = ''; $fecha = ''; $hora = ''; $minutos = ''; $autorizacion = ''; $boucher = '';
	if ( isset($_POST['boton']) ) {
		if ( isset($_POST['nombre']) ) { $nombre = $_POST['nombre']; };
		if ( isset($_POST['apellido']) ) { $apellido = $_POST['apellido']; };
		if ( isset($_POST['correo']) ) { $correo = $_POST['correo']; };
		if ( isset($_POST['concepto']) ) { $concepto = $_POST['concepto']; };
		if ( isset($_POST['importe']) ) { $importe = $_POST['importe']; };
		if ( isset($_POST['descripcionformapago']) ) { $descripcionformapago = $_POST['descripcionformapago']; };
        if ( isset($_POST['sucursal']) ) { $sucursal = $_POST['sucursal']; };
        if ( isset($_POST['fecha']) ) { $fecha = $_POST['fecha']; };
        if ( isset($_POST['hora']) ) { $hora = $_POST['hora']; };
        if ( isset($_POST['minutos']) ) { $minutos = $_POST['minutos']; };
        if ( isset($_POST['autorizacion']) ) { $autorizacion = $_POST['autorizacion']; };
		if ( isset($_FILES) ) { $boucher = $_FILES['boucher']['tmp_name']; };
		
		$cuerpo_mensaje = '<table style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#403732;" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tbody>
        
            <!-- Encabezado del mail -->
            <tr>
                <td style="background-color:#F4F3ED;" align="center" valign="top">
                    <img src="' . $GLOBALS['url_instalacion'] . '/pago/admin/img/encabezado-correo.jpg" style="display: block;" height="160" width="600">
                </td>
            </tr>
        
            <!-- Mensaje para el vendedor -->
            <tr>
                <td style="background-color:#F4F3ED;" align="left" valign="top">
                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                    <tbody>
        
                        <tr>
                            <td align="left" valign="top">
                                <h2>Un nuevo cliente registro su pago en efectivo</h2>
                                
                                <h2>DATOS DEL CLIENTE</h2>
                                <p>
                                    <strong>Nombre: </strong>' . $nombre . '<br />
                                    <strong>Apellido: </strong>' . $apellido . '<br />
                                    <strong>Correo: </strong>' . $correo . '<br />
                                </p>
								
                                <h2>DATOS DE SU PEDIDO</h2>
                                <p>
                                    <strong>Concepto: </strong>' . $concepto . '<br />
                                    <strong>Importe: </strong>$' . $importe . ' MXN<br />
                                </p>

                                <h2>DATOS DE SU DEPÓSITO</h2>
                                <p>
                                    <strong>Sucursal: </strong>' . $sucursal . '<br />
                                    <strong>Fecha: </strong>' . $fecha . ' (día/mes/año)<br />
                                    <strong>Hora: </strong>' . $hora . ':' . $minutos . '<br />
                                    <strong>Número de autorización: </strong>' . $autorizacion . '<br />
                                </p>

                            </td>
                        </tr>
        
                    </tbody>
                    </table>
                </td>
            </tr>
        
            <!-- Pié de página del correo -->
            <tr>
                <td style="background-color:#3F3631; color:#fff" align="left" valign="top">
                    <table border="0" cellpadding="15" cellspacing="0" width="100%">
                    <tbody>
                    <tr>
                        <td style="color:#fff;" align="left" valign="top">
                            <strong><span>' . $GLOBALS['nombre_comercio'] . '</span><br>
                            <span>' . $GLOBALS['direccion_comercio'] . '</span><br>
                            <span>Email: <a style="color:#fff; text-decoration: none;" href="mailto:' . $GLOBALS['correo_contacto_comercio'] . '" style="color: #fff; text-decoration: none;">' . $GLOBALS['correo_contacto_comercio'] . '</a></span><br>
                            <span>Website: <a style="color:#fff; text-decoration: none;" href="http://' . $GLOBALS['sitio_comercio'] . '/" target="_blank" style="color: #fff; text-decoration: none;">' . $GLOBALS['sitio_comercio'] . '</a></span></strong>
                        </td>
                        <td style="color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:13px;" align="right" valign="top">
                            <p>
                                 <strong>Visitanos en Facebook</strong>
                            </p>
                             <a href="' . $GLOBALS['fb_fanpage_comercio'] . '"><img src="' . $GLOBALS['url_instalacion'] . '/pago/admin/img/logo-facebook.png"></a>
                        </td>
                    </tr>
                    </tbody>
                    </table>
                </td>
            </tr>
        
        </tbody>
        </table>';
		
		
		require 'PHPMailer/PHPMailerAutoload.php';
		
		$mail = new PHPMailer;
		
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'ssl://email-smtp.us-east-1.amazonaws.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $GLOBALS['ses_smtp_username'];                 // SMTP username
		$mail->Password = $GLOBALS['ses_smtp_password'];                           // SMTP password
		$mail->SMTPSecure = 'ssl';                           	// Enable encryption, 'ssl' or 'tls' also accepted
		$mail->Port = '465';									//Select port to stablish connection , 'ssl' (465) or 'tls' (587).
		
		$mail->From = $GLOBALS['ses_verified_sender'];
		$mail->FromName = 'Sistema de pagos';
		$mail->addAddress($GLOBALS['correo_contacto_comercio']);     // Add a recipient
		//$mail->addAddress('soporte@metrorama.mx');               // Name is optional
		$mail->addReplyTo($correo);
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');
		
		//$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->addAttachment($boucher, 'boucher.jpg');         // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		//$mail->AddAttachment("admin/img/encabezado-correo.jpg");      // attachment
		$mail->isHTML(true);                                  // Set email format to HTML
		
		$mail->Subject = 'Nuevo registro de pago en efectivo';
		$mail->Body    = $cuerpo_mensaje;
		//$mail->AltBody = 'Cuerpo del mensaje ¡Ñú!';
		//$mail->Encoding = 'base64';
		$mail->CharSet = 'utf8';								//Defines charset to utf8 to display latin characters
		
		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			//echo $boucher;
		}
		
	}
?>
<div id="content">
        <h1 class="page-name">Gracias por tu pago</h1>
    		<div class="psh-form form-box round-corner">
				<p>Gracias por registrar tu pago, revisaremos tus datos de pago y responderemos a la brevedad posible. Por favor espera nuestra confirmación. Gracias.</p>
            <p>&nbsp;</p>
			</div>
</div>

</div><!-- #psh-content -->
<?php
require_once('footer.php');
?>