<?php
	require_once('admin/includes/config.php');
	require_once('admin/includes/functions.php');
?>
<?php require_once('header.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php echo $GLOBALS['url']; ?>/pago/pagos.css" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700' rel='stylesheet' type='text/css' />
<title>Gracias por tu pago</title>
</head>

<body>

<?php //require_once('header.php');
//Se rompe el corazón de los cracker
//$ok = true;
if ( isset( $_POST['txn_type'] ) ) {
//if ( $ok ) {
   // Send an empty HTTP 200 OK response to acknowledge receipt of the notification 
   //header('HTTP/1.1 200 OK'); 

	//imprime_array($_POST);
	//Se reciben y asignan variables comunes de paypal
	//Referencia de variables paypal: https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNandPDTVariables/
	$apellido = $last_name = $_POST['last_name'];
	$nombre = $first_name = $_POST['first_name'];
	$correo = $payer_email = $_POST['payer_email'];
	$concepto = $item_name = $_POST['item_name'];
	$id_compra = $item_number = $_POST['item_number'];
	$mc_currency = $_POST['mc_currency'];
	$id_compra = $custom = $_POST['custom'];
	$tipopago = $txn_type = $_POST['txn_type'];

	if ($tipopago == 'web_accept') {
		$tipopago = 'contado';
		$mc_fee = $_POST['mc_fee']; //Comisión que cobra paypal
		$importe = $mc_gross = $_POST['mc_gross']; //Total enviado al momento de pagar (sin descontar comisiones)
	
	} else { //	if ($tipopago == 'subscr_signup') {
		
		$tipopago = 'parcialidades';
		$parcialidades = $recur_times = $_POST['recur_times']; //Número de veces que se realizará el cobro
		$period3 = $_POST['period3']; //Periodicidad del cobro
		$importe = $mc_amount3 = $_POST['mc_amount3']; //Cantidad que se cobrará cada ciclo independientemente de la moneda		
		
		$periodicidades = explode(' ', $period3);;
		$periodicidad = $periodicidades[0];
		$periodicidad2 = $periodicidades[1];

		switch ($periodicidad2) {
			case 'D' : $t3 = 'dia(as)';
			break;
			case 'W' : $t3 = 'semana(s)';
			break;
			case 'M' : $t3 = 'mes(es)';
			break;
			case 'Y' : $t3 = 'año(s)';
			break;
		}
	}
        
	if ($tipopago == 'contado') {
		
		//Componemos el cuerpo del mensaje que se enviará al VENDEDOR
		
		$mensaje_vendedor = '<table style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#403732;" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tbody>
        
            <!-- Encabezado del mail -->
            <tr>
                <td style="background-color:#fff;" align="center" valign="top">
                    <img src="' . $GLOBALS['url_instalacion'] . '/pago/admin/img/encabezado-correo.jpg" style="display: block;" height="160" width="600">
                </td>
            </tr>
        
            <!-- Mensaje para el vendedor -->
            <tr>
                <td style="background-color:#fff;" align="left" valign="top">
                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                    <tbody>
        
                        <tr>
                            <td align="left" valign="top">
                                <h2>Pago realizado de un producto o servicio</h2>
        
                                <p>Un cliente completo su proceso de compra, debajo encontrarás los datos de la transacción.</p>
                                
                                <h2>DATOS DEL CLIENTE</h2>
                                <p>
                                    <strong>Nombre: </strong>' . $nombre . '<br />
                                    <strong>Apellido: </strong>' . $apellido . '<br />
                                    <strong>Correo con el que pagó usando paypal: </strong>' . $correo . '
                                </p>
                                
                                <h2>DATOS DE SU PEDIDO</h2>
                                <p>
                                    <strong>Concepto: </strong>' . $concepto . '<br />
                                    <strong>Tipo de pago: </strong>' . $tipopago . '<br />
                                    <strong>Importe: </strong> $' . $importe . ' MXN<br />
                                    <strong>Número de orden: </strong> ' . $id_compra . '<br />
                                </p>
                                
                                <p></p>
                            </td>
                        </tr>
        
                    </tbody>
                    </table>
                </td>
            </tr>
        
            <!-- Pié de página del correo -->
            <tr>
                <td style="background-color:#000;" align="left" valign="top">
                    <table border="0" cellpadding="15" cellspacing="0" width="100%">
                    <tbody>
                    <tr>
                        <td style="color:#ffffff;" align="left" valign="top">
                            <strong><span>' . $GLOBALS['nombre_comercio'] . '</span><br>
                            <span>' . $GLOBALS['direccion_comercio'] . '</span><br>
                            <span>Teléfono: </span>' . $GLOBALS['telefono_comercio'] . '<br>
                            <span>Email: <a href="mailto:' . $GLOBALS['correo_contacto_comercio'] . '" style="color: rgb(255, 255, 255); text-decoration: none;">' . $GLOBALS['correo_contacto_comercio'] . '</a></span><br>
                            <span>Website: <a href="http://' . $GLOBALS['sitio_comercio'] . '/" target="_blank" style="color: rgb(255, 255, 255); text-decoration: none;">' . $GLOBALS['sitio_comercio'] . '</a></span></strong>
                        </td>
                        <td style="color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:13px;" align="right" valign="top">
                            <p>
                                 <strong>Visitanos en Facebook</strong>
                            </p>
                             <a href="' . $GLOBALS['fb_fanpage_comercio'] . '"><img src="' .  $GLOBALS['url_instalacion'] . '/pago/admin/img/logo-facebook.png"></a>
                        </td>
                    </tr>
                    </tbody>
                    </table>
                </td>
            </tr>
        
        </tbody>
        </table>';
		
		//Componemos el cuerpo del mensaje que se enviará al COMPRADOR
		
		$mensaje_comprador = '<table style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#403732;" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tbody>
        
            <!-- Encabezado del mail -->
            <tr>
                <td style="background-color:#F4F3ED;" align="center" valign="top">
                    <img src="' . $GLOBALS['url_instalacion'] . '/pago/admin/img/encabezado-correo.jpg" style="display: block;" height="160" width="600">
                </td>
            </tr>
        
            <!-- Mensaje para el comprador -->
            <tr>
                <td style="background-color:#F4F3ED;" align="left" valign="top">
                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                    <tbody>
        
                        <tr>
                            <td align="left" valign="top">
                                <h2>Hola ' . $nombre . '</h2>
        
                                <p>Gracias por realizar tu pago. Te informamos que hemos recibido tu solicitud satisfactoriamente y debajo encontrarás los detalles de la misma. Si tienes alguna duda por favor contáctanos respondiendo a este mensaje.<br />¡Recibe un saludo afectuoso!</p>
                                
                                <h2>TUS DATOS</h2>
                                <p>
                                    <strong>Nombre: </strong>' . $nombre . '<br />
                                    <strong>Apellido: </strong>' . $apellido . '<br />
                                    <strong>Correo con el que pagaste usando paypal: </strong>' . $correo . '
                                </p>
                                
                                <h2>DATOS DE TU PEDIDO</h2>
                                <p>
                                    <strong>Concepto: </strong>' . $concepto . '<br />
                                    <strong>Tipo de pago: </strong>' . $tipopago . '<br />
                                    <strong>Importe: </strong> $' . $importe . ' MXN<br />
                                    <strong>Número de orden: </strong> ' . $id_compra . '<br />
                                </p>
                                
                                <p></p>
                            </td>
                        </tr>
        
                    </tbody>
                    </table>
                </td>
            </tr>
        
            <!-- Pié de página del correo -->
            <tr>
                <td style="background-color:#000;" align="left" valign="top">
                    <table border="0" cellpadding="15" cellspacing="0" width="100%">
                    <tbody>
                    <tr>
                        <td style="color:#ffffff;" align="left" valign="top">
                            <strong><span>' . $GLOBALS['nombre_comercio'] . '</span><br>
                            <span>' . $GLOBALS['direccion_comercio'] . '</span><br>
                            <span>Teléfono: </span>' . $GLOBALS['telefono_comercio'] . '<br>
                            <span>Email: <a href="mailto:' . $GLOBALS['correo_contacto_comercio'] . '" style="color: rgb(255, 255, 255); text-decoration: none;">' . $GLOBALS['correo_contacto_comercio'] . '</a></span><br>
                            <span>Website: <a href="http://' . $GLOBALS['sitio_comercio'] . '/" target="_blank" style="color: rgb(255, 255, 255); text-decoration: none;">' . $GLOBALS['sitio_comercio'] . '</a></span></strong>
                        </td>
                        <td style="color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:13px;" align="right" valign="top">
                            <p>
                                 <strong>Visitanos en Facebook</strong>
                            </p>
                             <a href="' . $GLOBALS['fb_fanpage_comercio'] . '"><img src="' .  $GLOBALS['url_instalacion'] . '/pago/admin/img/logo-facebook.png"></a>
                        </td>
                    </tr>
                    </tbody>
                    </table>
                </td>
            </tr>
        
        </tbody>
        </table>';

	
	} else { //if ($tipopago == 'subscr_signup') {
		
		//Componemos el cuerpo del mensaje que se enviará al VENDEDOR
		
		$tipopago = 'parcialidades';
		$mensaje_vendedor = '<table style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333;" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
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
                                <h2>Pago realizado de un producto o servicio</h2>
        
                                <p>Un cliente completo su proceso de compra, debajo encontrarás los datos de la transacción.</p>
                                
                                <h2>DATOS DEL CLIENTE</h2>
                                <p>
                                    <strong>Nombre: </strong>'  . $nombre . '<br />
                                    <strong>Apellido: </strong>' . $apellido . '<br />
                                    <strong>Correo con el que pagó usando paypal: </strong>' . $correo . '
                                </p>
                                
                                <h2>DATOS DE SU PEDIDO</h2>
                                <p>
                                    <strong>Concepto: </strong>' . $concepto . '<br />
                                    <strong>Tipo de pago: </strong>' . $tipopago . '<br />
                                    <strong>Número de orden: </strong> ' . $id_compra . '<br />
                                </p>
                                
                                <h2>DETALLES DEL PAGO EN PARCIALIDADES</h2>
                                <p>                        
									
									<strong>Detalles de las parcialidades:</strong> El cliente realizará ' . $parcialidades . ' pagos de $' . $importe . ' cada ' . $periodicidad . ' ' . $periodicidad2 . '<br />
                                    <strong>Total que se pagará: </strong> $' . $importe * $parcialidades . ' MXN<br />
									
                                    <strong>Primer pago recibido por:</strong> $'. $importe . '<br />

                                </p>
                                
                                <p></p>
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
		
		//Componemos el cuerpo del mensaje que se enviará al COMPRADOR
		
		$mensaje_comprador = '<table style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333;" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tbody>
        
            <!-- Encabezado del mail -->
            <tr>
                <td style="background-color:#fff;" align="center" valign="top">
                    <img src="' . $GLOBALS['url_instalacion'] . '/pago/admin/img/encabezado-correo.jpg" style="display: block;" height="160" width="600">
                </td>
            </tr>
        
            <!-- Mensaje para el vendedor -->
            <tr>
                <td style="background-color:#fff;" align="left" valign="top">
                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                    <tbody>
        
                        <tr>
                            <td align="left" valign="top">
                                <h2>Hola ' . $nombre . '</h2>
        
                                <p>Gracias por realizar tu pago. Te informamos que hemos recibido tu solicitud satisfactoriamente y debajo encontrarás los detalles de la misma. Si tienes alguna duda por favor contáctanos respondiendo a este mensaje.<br />¡Recibe un saludo afectuoso!</p>
                                
                                <h2>TUS DATOS</h2>
                                <p>
                                    <strong>Nombre: </strong>'  . $nombre . '<br />
                                    <strong>Apellido: </strong>' . $apellido . '<br />
                                    <strong>Correo con el que pagó usando paypal: </strong>' . $correo . '
                                </p>
                                
                                <h2>DATOS DE TU PEDIDO</h2>
                                <p>
                                    <strong>Concepto: </strong>' . $concepto . '<br />
                                    <strong>Tipo de pago: </strong>' . $tipopago . '<br />
                                    <strong>Número de orden: </strong> ' . $id_compra . '<br />
                                </p>
                                
                                <h2>DETALLES DEL PAGO EN PARCIALIDADES</h2>
                                <p>                        
									
									<strong>Detalles de las parcialidades:</strong> Realizarás ' . $parcialidades . ' pagos de $' . $importe . ' cada ' . $periodicidad . ' ' . $periodicidad2 . '<br />
                                    <strong>Total que se pagará: </strong> $' . $importe * $parcialidades . ' MXN<br />
                                    <strong>Primer pago recibido por:</strong> $'. $importe . '<br />

                                </p>
                                
                                <p></p>
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
		
 
	};
	
	//if ( isset($_POST['boton']) ) {
	if ( isset($_POST['txn_type']) ) {
		
		//PREPARACIÓN DEL ENVIO DE MENSAJE AL VENDEDOR
		//error_reporting(E_ALL ^ E_STRICT); //Deshabilita los errores estrictos
		//error_reporting(E_ALL & ~E_STRICT); //Deshabilita los errores estrictos
		error_reporting(0); //Deshabilita todos los errores (Se actualizará la clase Mail porque está quedando obsoleta para php5)
		
		//Asignación de variables comunes para el mensaje
		$to = $GLOBALS['correo_contacto_comercio'];
		$message = $mensaje_vendedor;

		//Configuración SMTP
		require_once "mail-test.php"; // calls pear mail packages

		//Creación del array para los headers del correo
		$from = 'Sistema de pagos <' . $GLOBALS['ses_verified_sender'] . '>';
		$subject = base64_encode( 'Nuevo pago realizado via sistema de pagos - ' . $id_compra );
		$headers = array (
			'From' => $from,
			'To' => $to,
			'Subject' => "=?UTF-8?B?" . $subject . "?=",
			'MIME-Version' => '1.0',
			'Content-Type' => 'text/html; charset=utf-8',
			'Reply-To' => $GLOBALS['correo_contacto_comercio'],
		);
		
		//Credenciales Amazon SES
		$host = "ssl://email-smtp.us-east-1.amazonaws.com";
		$port = "465";
		$username = $GLOBALS['ses_smtp_username'];
		$password = $GLOBALS['ses_smtp_password'];
		
		$smtp = Mail::factory('smtp', //prepares smtp vars
		array ('host' => $host,
		 'port' => $port,
		 'auth' => true,
		 'username' => $username,
		 'password' => $password));
		
		//SE ENVIA EL MENSAJE
		$mail = $smtp->send($to, $headers, $message);
		
		//SE COMPRUEBA QUE NO HAYA ERRORES
		if (PEAR::isError($mail)) {
			echo("<p>" . $mail->getMessage() . "</p>");
		} else {
			//echo("<p>Message successfully sent!</p>");
			//echo $message;
		}
		
		
		
		
		//PREPARACIÓN DEL ENVIO DE MENSAJE AL COMPRADOR
		//error_reporting(E_ALL ^ E_STRICT);
		
		//Asignación de variables comunes para el mensaje
		$to = $correo;
		$message = $mensaje_comprador;

		//Configuración SMTP
		require_once "mail-test.php"; // calls pear mail packages

		//Creación del array para los headers del correo
		$from = $GLOBALS['nombre_comercio'] . '<' . $GLOBALS['ses_verified_sender'] . '>';
		$subject = base64_encode( "Comfirmación de pago recibido - " . $id_compra );
		$headers = array (
			'From' => $from,
			'To' => $to,
			'Subject' => "=?UTF-8?B?" . $subject . "?=",
			'MIME-Version' => '1.0',
			'Content-Type' => 'text/html; charset=utf-8',
			'Reply-To' => $GLOBALS['correo_contacto_comercio'],
		);
		
		//Credenciales Amazon SES
		$host = "ssl://email-smtp.us-east-1.amazonaws.com";
		$port = "465";
		$username = $GLOBALS['ses_smtp_username'];
		$password = $GLOBALS['ses_smtp_password'];
		
		$smtp = Mail::factory('smtp', //prepares smtp vars
		array ('host' => $host,
		 'port' => $port,
		 'auth' => true,
		 'username' => $username,
		 'password' => $password));
		
		//SE ENVIA EL MENSAJE
		$mail = $smtp->send($to, $headers, $message);
		
		//SE COMPRUEBA QUE NO HAYA ERRORES
		if (PEAR::isError($mail)) {
			echo("<p>" . $mail->getMessage() . "</p>");
		} else {
			//echo("<p>Message successfully sent!</p>");
			//echo $message;
		}

		
		
		//VÍA SERVIDOR DEL CLIENTE
		/*
		$headers = 'From: Sistema de pagos <' . $GLOBALS['correo_contacto_comercio'] . '>\r\n';
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";*/

		//mail($to, $subject, $message, $headers);
?>

    <!-- DAMOS LAS GRACIAS AL COMPRADOR -->
    <div id="content">
    <h1 class="page-name">Gracias por tu pago</h1>
    	<div class="psh-form form-box round-corner">
            <p>Hola <?php echo $nombre; ?>, hemos recibido tu pago te enviamos los detalles a <strong><?php echo $correo; ?><strong>. Revisa tu bandeja de entrada o correo no deseado y asegurate de marcarlo como correo seguro para no perder ninguna notificación en el futuro. ¡Gracias!</p>
		</div>
<?php }
	
} else {
	//session_destroy();
?>

    <!-- DAMOS LAS GRACIAS AL COMPRADOR -->
    <div id="content">
        <h1 class="page-name">Gracias por tu pago</h1>
    		<div class="psh-form form-box round-corner">
        <p>¡Muchas gracias por completar tu proceso de pago! Por el momento eso es todo, revisaremos la transacción manualmente y de ser necesario nos pondremos en contacto contigo. Guarda el correo de confirmación de paypal para cualquier aclaración.</p>
        <p>&nbsp;</p>
			</div>
    </div>
<?php }
require_once('footer.php');
?>