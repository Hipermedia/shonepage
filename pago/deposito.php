<?php
/**
 * Template Name: Depósito
 */

get_header(); ?>

<div id="content">

<ul id="breadcrumbs">
	<li><a href="#">Paso 1 - Ingresa tus datos</a></li>
	<li><a href="#">Paso 2 - Revisión de compra</a></li>
	<li><a class="activo" href="#">Paso 3 - Realiza tu pago</a></li>
	<li><a href="#">Paso 4 - Finalizar</a></li>
</ul>

<h1 class="page-name">Paso 3 - Realiza tu depósito</h1>

<?php //Se rompe el corazón de los crackers

// if ($_SESSION['security_code_2j7hFmd9']) {

	//Se reciben y asignan variables

	if ( isset($_GET) ) {
		$concepto = $_GET['concepto'];
		$importe = $_GET['importe'];
		$descripcionformapago = $_GET['descripcionformapago'];
		$id_compra = $_GET['idcompra'];
	} ?>

<div class="psh-form form-box round-corner">
<div class="column-left">
	<h2 class="seccion-name">Datos de depósito</h2>
	<fieldset>
    	<p>BANCO: <strong><?php echo $banco; ?></strong></p>
		<p>CUENTA: <strong><?php echo $cuenta; ?></strong></p>
		<p>CLABE: <strong><?php echo $clabe; ?></strong></p>
		<p>TITULAR: <strong><?php echo $titular; ?></strong></p>
	</fieldset>
    </div>
   <div class="column-right">
	<h2 class="seccion-name">Detalles de tu pedido</h2>
   <fieldset>
	    <p>Concepto a pagar: <strong><?php echo $concepto; ?></strong></p>
	    <p>ID de compra: <strong><?php echo $id_compra; ?></strong></p>
	    <p><strong>Tu pagó será de contado</strong></p>
        <p>Importe:<strong> $<?php echo $importe; ?> MNX</strong></p>
        <p class="help">Nota: <?php echo $descripcionformapago; ?></p>
   </fieldset>
    </div>

	<a class="btn-ficha" href="javascript:window.print()">IMPRIMIR</a>


<?php //session_destroy();
	
// } else { ?>

	<!-- No deberías de estar aquí. Si llegaste por error, te sugerimos que regreses al <a href="<?php echo $GLOBALS['url_principal']; ?>">inicio de nuestro sitio web</a> -->

<?php //} ?>
</div><!-- #psh-general-container -->
</div><!-- #psh-content -->

<?php
	if ( isset($_GET['print']) ) { ?>
		<script type="text/javascript">
        <!--
        window.onload = function() { window.print(); }
        //-->
        </script>
	<?php }
?>

<?php get_footer(); ?>
