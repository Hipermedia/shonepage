<?php
	require_once('../../../pago/admin/includes/config.php');
	require_once('../../../pago/admin/includes/functions.php');
	mantener_sesion();
	//Bloque de seguridad (en progreso)
	session_name('security_code_2j7hFmd9');
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="pagos.css" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700' rel='stylesheet' type='text/css' />
<script src="<?php echo $GLOBALS['url_instalacion']; ?>/pago/admin/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo $GLOBALS['url_instalacion']; ?>/pago/admin/includes/jquery-validation/lib/jquery.js"></script>
<script src="<?php echo $GLOBALS['url_instalacion']; ?>/pago/admin/includes/jquery-validation/dist/jquery.validate.js"></script>
<style type="text/css">
.psh-form label.error, .psh-form input.submit {
	margin-left: 280px;
	color: #fff;
	position: absolute;
	margin-top: -32px;
	background-color: #BC3232;
	border-radius: 6px;
	padding: 4px;
	font-size: 16px;
	font-weight: bold;
	
}

.psh-form label.error:before{ /* Este es un truco para crear una flechita */
    content: '';
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
    border-right: 8px solid #BC3232;
    border-left: 8px solid transparent;
    left: -15px;
    position: absolute;
    top: 4px;
}
</style>
<title>Generador de botones de pago</title>
</head>

<body>
<header id="header-wrapper">	
	<div id="header-content">
		<img src="<?php echo $GLOBALS['url_instalacion']; ?>/pago/admin/img/logo.png" width="160" height="90" alt="Logo" id="logo" />
   	<h2>Sistema de pagos ELT Consultants</h2>
   </div>
</header>
