<?php
	require_once('admin/includes/config.php');
	require_once('admin/includes/functions.php');

if ( comprobar_sesion() ) {
	header("Location: " . $GLOBALS['url_instalacion'] . '/');
} ?>