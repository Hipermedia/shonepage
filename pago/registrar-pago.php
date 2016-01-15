<?php require_once('header.php'); ?>

<div id="content">

<h1 class="page-name">Regista tu depósito en efectivo</h1>

<?php //Se reciben y asignan variables
	$nombre = ''; $apellido = ''; $correo = ''; $concepto = ''; $importe = '';;
	if ( isset($_GET) ) {
		if ( isset($_GET['nombre']) ) { $nombre = $_GET['nombre']; };
		if ( isset($_GET['apellido']) ) { $apellido = $_GET['apellido']; };
		if ( isset($_GET['correo']) ) { $correo = $_GET['correo']; };
		if ( isset($_GET['concepto']) ) { $concepto = $_GET['concepto']; };
		if ( isset($_GET['importe']) ) { $importe = $_GET['importe']; };
	}
?>
    
    <form action="<?php echo $GLOBALS['url_instalacion']; ?>/pago/gracias-registrar-pago.php" method="post" enctype="multipart/form-data" class="psh-form form-box round-corner">
<script>
$().ready(function() {

	// validate signup form on keyup and submit
	$(".psh-form").validate({
		rules: {
			nombre: "required",
			apellido: "required",
			email: "required",
			concepto: "required",
			importe: "required",
			sucursal: "required",
			fecha: "required",
			hora: "required",
			minutos: "required",
			autorizacion: "required",
		},
		messages: {
			nombre: "Ingresa tu nombre",
			apellido: "Ingresa tu apellido",
			email: "Ingresa tu dirección de correo",
			concepto: "Agrega el concepto",
			importe: "Agrega el importe con números",
			sucursal: "Número de sucursal",
			fecha: "Elige la fecha de tu comprobante",
			hora: "Agregar la hora",
			minutos: "Agrega los minutos",
			autorizacion: "Número de autorización",
		}
	});
});
</script><!-- Ignorar este error, es de DW -->
        <div class="column-left"> 
        <h2 class="seccion-name">Ingresa tus datos</h2>
            <label for="nombre">Nombre(s)</label>
            <input type="text" name="nombre" placeholder="Escribe tu nombre" value="<?php echo $nombre; ?>" <?php echo $nombre!=''?'disabled':''; ?> required />
            <label for="apellido">Apellido(s)</label>
            <input type="text" name="apellido" placeholder="Escribe tu apellido" value="<?php echo $apellido; ?>" <?php echo $apellido!=''?'disabled':''; ?> required/>
            <label for="correo">Correo electrónico</label>
            <input type="email" name="correo" placeholder="ejemplo@ejemplo.com" value="<?php echo $correo; ?>" <?php echo $correo!=''?'disabled':''; ?> required/>
		</div>
        <div class="column-right">
        <h2 class="seccion-name">Datos de tu pago</h2>
            <label for="concepto">Concepto</label>
            <input type="text" name="concepto" placeholder="Escribe el motivo de tu pago" value="<?php echo $concepto; ?>" <?php echo $concepto!=''?'disabled':''; ?> required />
            <label for="importe">Importe (solo números)</label>
            <input type="text" name="importe" placeholder="100" value="<?php echo $importe; ?>" <?php echo $importe!=''?'disabled':''; ?> required/>
		</div>
        <div class="spacer"></div><!-- división -->
        <h2 class="seccion-name">Datos de tu ficha</h2>
        
        <div class="column-left">
         <label for="sucursal">Sucursal</label>
        <input type="text" name="sucursal" />
        <label for="autorizacion">Folio o número de autorización</label>
        <input type="text" name="autorizacion" required/>
        <label for="boucher">Sube tu comprobante</label>
        <input type="file" name="boucher"/>
		
      </div>
      <div class="column-right">
      <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
		<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
		<script src="<?php echo $GLOBALS['url_instalacion']; ?>/pago/admin/includes/jquery.ui.datepicker-es.js"></script>
		

		<script>
			$(function () {
				$.datepicker.setDefaults($.datepicker.regional["es"]);
				$("#datepicker").datepicker({
					firstDay: 1
				});
			});
		</script>


		<label for="fecha">Fecha</label>
		<input type="text" name="fecha" id="datepicker" required/>
        <label for="hora">Hora</label>
        <select name="hora">
			<?php ?>
			<option value=""></option>
			<?php for ($i=00; $i <= 23; $i++) {
                $j = sprintf("%02s", $i);
                echo '<option value="' . $j . '">' . $j . '</option>';
            } ?>
		</select>
        <label for="minutos">Minutos</label>
        <select name="minutos">
			<?php ?>
			<option value=""></option>
			<?php for ($i=00; $i <= 59; $i++) {
                $j = sprintf("%02s", $i);
                echo '<option value="' . $j . '">' . $j . '</option>';
            } ?>
		</select>
       
        
     </div>   
        <div class="spacer"></div><!-- división -->
        <input type="submit" name="boton" value="Enviar datos de depósito">
    
    </form>    

</div><!-- #psh-content -->
<?php
require_once('footer.php');
?>