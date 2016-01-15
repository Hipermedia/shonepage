<?php require_once('admin/includes/config.php');
require_once('admin/includes/functions.php');
//Bloque de seguridad (en progreso)

//Genera número de orden aleatoreo
$id_compra = rand(10000000, 99999999);

//Se reciben y asignan variables
if ( isset($_POST['boton']) ) {

	//Se rompe el corazón de los crackers
	if (isset($_POST['boton'])) {
		
		//session_destroy(); //Nos evitamos problemas para recibir notificaciones de paypal
		
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$correo = $_POST['correo'];
		$concepto = $_POST['concepto'];
		$tipopago = $_POST['tipopago']; //puede ser contado o suscripcion
		$importe = $_POST['importe'];
		$descripcionformapago = $_POST['descripcionformapago'];
		if ($tipopago == 'suscripcion') {
			$periodicidad = $_POST['periodicidad'];
			$periodicidad2 = $_POST['periodicidad2'];
			$parcialidades = $_POST['parcialidades'];
			
			switch ($periodicidad2) {
				case 'dia(as)' : $t3 = 'D';
				break;
				case 'semana(s)' : $t3 = 'W';
				break;
				case 'mes(es)' : $t3 = 'M';
				break;
				case 'año(s)' : $t3 = 'Y';
				break;	
			}
		}

	}    
        
	if ($tipopago == 'contado') {
		//Concatenamos la url para redirigir a paypal
		$redireccion = utf8_encode(
		//'http://localhost/pago/graciaspago.php?' .
		'https://www.paypal.com/cgi-bin/webscr?business=' . $GLOBALS['customerpaypalemail'] .
		'&cmd=_xclick&item_name=' . $concepto .
		'&amount=' . $importe .
		'&amp;currency_code=MXN' .
		'&image_url=' . $GLOBALS['customerpaypallogo'] .
		'&lc=MX&no_shipping=1&return=' . $GLOBALS['paypalreturnurl'] .
		'&rm=' . $GLOBALS['paypalreturnmethod'] .
		'&cbt=' . $GLOBALS['paypalreturnbuttontext'] .
		'&cancel_return=' .$GLOBALS['paypalcancelreturn'] .
		'&custom=' . $id_compra .
		'&email=' . $correo .
		'&first_name=' . $nombre .
		'&last_name=' . $apellido .
		'&charset=utf-8');
		//'&charset=utf-8&submit.x=64&submit.y=20');

		//Componemos el cuerpo del mensaje que se enviará al vendedor
		
		$cuerpo_mensaje = '<table style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333;" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
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
                                <h2>Nuevo cliente interesado en comprar un producto o servicio</h2>
        
                                <p>Si el cliente no realiza su pago puedes realizar un seguimiento del mismo utilizando la siguiente información.</p>
                                
                                <h2>DATOS DEL CLIENTE</h2>
                                <p>
                                    <strong>Nombre: </strong>' . $nombre . '<br />
                                    <strong>Apellido: </strong>' . $apellido . '<br />
                                    <strong>Correo: </strong>' . $correo . '
                                </p>
                                
                                <h2>DATOS DE SU PEDIDO</h2>
                                <p>
                                    <strong>Concepto: </strong>' . $concepto . '<br />
                                    <strong>Tipo de pago: </strong>' . $tipopago . '<br />
                                    <strong>Importe: </strong> $' . $importe . ' MXN<br />
                                    <strong>Número de orden: </strong>' . $id_compra . '<br />
                                </p>
                                
                                <h2>LIGA DIRECTA PARA REALIZAR SU PEDIDO</h2>
                                <p>
                                    <strong>URL: </strong><a href="' . $redireccion . '">' . $redireccion . '</a><br />
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

		
		//Redirigimos a paypal y enviamos el formulario via GET luego de enviar el correo
		//header( "Location: " . $redireccion );
	
	}
	
	if ($tipopago == 'suscripcion') {

		//Concatenamos la url para redirigir a paypal
		$redireccion = utf8_encode(
		//'http://localhost/pago/graciaspago.php' .
		'https://www.paypal.com/cgi-bin/webscr?business=' . $GLOBALS['customerpaypalemail'] .
		'&cmd=_xclick-subscriptions&item_name=' . $concepto .
		'&item_number=' . $periodicidad2 .
		'&amp;currency_code=MXN&a3=' . $importe .
		'&p3=' .$periodicidad .
		'&t3=' . $t3 .
		'&src=1&srt=' . $parcialidades .
		'&image_url=' . $GLOBALS['customerpaypallogo'] .
		'&lc=MX&no_shipping=1&return=' . $GLOBALS['paypalreturnurl'] .
		'&rm=' . $GLOBALS['paypalreturnmethod'] .
		'&cbt=' . $GLOBALS['paypalreturnbuttontext'] .
		'&cancel_return=' .$GLOBALS['paypalcancelreturn'] .
		'&custom=' . $id_compra .
		'&email=' . $correo .
		'&first_name=' . $nombre .
		'&last_name=' . $apellido .
		'&charset=utf-8');
		//'&charset=utf-8&submit.x=64&submit.y=20');
		
		//Componemos el cuerpo del mensaje que se enviará al vendedor
		
		$cuerpo_mensaje = '<table style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333;" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
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
                                <h2>Nuevo cliente interesado en comprar un producto o servicio</h2>
        
                                <p>Si el cliente no realiza su pago puedes realizar un seguimiento del mismo utilizando la siguiente información.</p>
                                
                                <h2>DATOS DEL CLIENTE</h2>
                                <p>
                                    <strong>Nombre: </strong>'  . $nombre . '<br />
                                    <strong>Apellido: </strong>' . $apellido . '<br />
                                    <strong>Correo: </strong>' . $correo . '
                                </p>
                                
                                <h2>DATOS DE SU PEDIDO</h2>
                                <p>
                                    <strong>Concepto: </strong>' . $concepto . '<br />
                                    <strong>Tipo de pago: </strong>' . $tipopago . '<br />
                                    <strong>Número de orden: </strong>' . $id_compra . '<br />
                                </p>
                                
                                <h2>DETALLES DEL PAGO EN PARCIALIDADES</h2>
                                <p>                        
                                
                                    <strong>Detalles: </strong>' . $parcialidades . ' pagos en total de $' . $importe . ' cada ' . $periodicidad . ' ' . $periodicidad2 . '<br />
                                    <strong>Total: </strong> $' . $importe * $parcialidades . ' MXN<br />
                                </p>
                                
                                <h2>LIGA DIRECTA PARA REALIZAR SU PEDIDO</h2>
                                <p>
                                    <strong>URL :</strong><a href="' . $redireccion . '">' . $redireccion . '</a><br />
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
	
	if ( isset($_POST['boton']) ) {
		
		//DESHABILITA ERRORES 
		//error_reporting(E_ALL ^ E_STRICT); //Deshabilita los errores estrictos
		//error_reporting(E_ALL & ~E_STRICT); //Deshabilita los errores estrictos
		error_reporting(0); //Deshabilita todos los errores (Se actualizará la clase Mail porque está quedando obsoleta para php5)
		
		//PREPARACIÓN DEL ENVIO DE MENSAJE AL VENDEDOR
		
		//Asignación de variables comunes para el mensaje
		$to = $GLOBALS['correo_contacto_comercio'];
		$message = $cuerpo_mensaje;

		//Configuración SMTP
		require_once "mail-test.php"; // calls pear mail packages

		//Creación del array para los headers del correo
		$from = 'Sistema de pagos <' . $GLOBALS['ses_verified_sender'] . '>';
		$subject = base64_encode( 'Datos de nuevo cliente interesado - '. $id_compra );
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
		
		//REDIRIGIMOS A PAYPAL DESPUES DE ENVIAR EL CORREO
		//echo $redireccion;
		$redireccion = html_entity_decode( $redireccion );
		header( "Location: " . $redireccion );
	}

	
} else {
	//session_destroy();
	require_once('header.php'); ?>
	
    No deberías de estar aquí. Si llegaste por error, te sugerimos que regreses al <a href="<?php echo $GLOBALS['url_principal']; ?>">inicio de nuestro sitio web</a>

<?php require_once('footer.php');
} ?>