<?php
/**
 * Template Name: Botón
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage SH_Base
 */


if ( isset($_POST['boton']) ) {
	
	//Asignación de variables de botón de pago
	$concepto = $_POST['concepto'];
	$importe = $_POST['importe'];
	$descripcionformapago = $_POST['descripcionformapago'];
	$urlimagendeboton = $_POST['urlimagendeboton'];
	
	if ( isset( $_POST['parcialidades'] ) ) {
		
		//Asignación de variables de botón de suscripción
		$periodicidad = $_POST['periodicidad'];
		$periodicidad2 = $_POST['periodicidad2'];
		$parcialidades = $_POST['parcialidades'];
		$importeparcialidad = $_POST['importeparcialidad'];
		$descripcionformapagoparcial = $_POST['descripcionformapagoparcial'];

		//Recuperación de parcialidades guardadas
		$parcialidades_guardadas = array();
		if ( isset( $_SESSION['parcialidades_guardadas'] ) ) {
			$parcialidades_guardadas = $_SESSION['parcialidades_guardadas'];
		}
		
		//Construcción del array de parcialidad
		$parcialidad = array (
			'periodicidad' => $periodicidad,
			'periodicidad2' => $periodicidad2,
			'parcialidades' => $parcialidades,
			'importeparcialidad' => $importeparcialidad,
			'descripcionformapagoparcial' => $descripcionformapagoparcial,
		);
		
		//Construcción de array de parcialidades guardadas
		array_push($parcialidades_guardadas, $parcialidad);
		$_SESSION['parcialidades_guardadas'] = $parcialidades_guardadas;

	}
	
	$parcialidades_guardadas = '';

	//Serializa y concatena las parcialidades guardadas
	if ( isset($_POST['parcialidades']) ) {
		$parcialidades_guardadas = '<input type="hidden" name="parcialidades_guardadas" value=\'' . serialize( $_SESSION['parcialidades_guardadas'] ) . '\'>';
	}
}
get_header(); ?>

<?php $wp_redirect = get_option('home'); ?>

<section class="u-contenedor">

	<?php while ( have_posts() ) : the_post(); ?>
	   
	    <article class="Page u-contenido">	
			
			<!-- Imágen destacada -->
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="Page-featuredImage">
					<?php the_post_thumbnail( 'large' ); ?>
				</figure>
			<?php else : ?>
				<figure class="Page-featuredImage">
					<img src="<?php the_field('thumbPersonalizada', 'option'); ?>" alt="">
				</figure>
			<?php endif; ?>
			<!-- Título del artículo -->
			<h1 class="Page-title"><?php the_title(); ?></h1>
			<!-- Contenido -->
			<?php the_content(); ?>	

				<div id="content">
			    	<h1 class="page-name">Botón generado con éxito</h1>
			       	<div class="form-box round-corner group">
			            <!-- Muestra el código del botón generado -->
			            <div id="codigo-boton" class="psh-form">
			            	<h2 class="seccion-name group">Copia el código del botón y pégalo donde desees.</h2>
			            
			           		<?php // Se agregan los estilos para la apariencia del botón
			           		if ($urlimagendeboton == '' ) {	
			           		 	$urlimagendeboton = get_plantilla_url().'/images/pago-default.png'; 
			           		}

			            	list($width_img, $height_img, $imgtype, $imgattr) = getimagesize($urlimagendeboton);

			            	$estilo_boton = 'style="background: none; ' .
			            	$estilo_boton = 'background-image: url('.$urlimagendeboton.'); ' .
			            	$estilo_boton =				'background-repeat: no-repeat; ' .
			            	$estilo_boton =				'width: '.$width_img.'px; ' .
			            	$estilo_boton =				'height: '.$height_img.'px; ' .
			            	$estilo_boton =				'margin: 20px auto;"';	
			            	?>
			            
			            	<?php 

			            	$boton = 
			            	'<form action="'.$wp_redirect.'/pago/paso1" method="post"> ' .
			            		'<input type="submit" name="boton" value="" '. $estilo_boton .'> ' .
			            		'<input type="hidden" name="concepto" value="' . $concepto . '"> ' .
			            		'<input type="hidden" name="importe" value="' . $importe . '"> ' .
			            		'<input type="hidden" name="descripcionformapago" value="' . $descripcionformapago . '"> ' . $parcialidades_guardadas .
			            		'<p style="font-weight: bold; text-align: center; font-size: .9em;">Si ya realizaste tu dep&oacute;sito, reg&iacute;stralo <a href="'.$wp_redirect.'/pago/registrar-pago.php">aqu&iacute;</a></p>'.
			           		'</form>';
			            
			            	$boton_mail = 
			            	'<form action="'.$wp_redirect.'/pago/admin/boton-mail.php" method="post">' .
			            		'<label>Agrega las direcciones de correo que desees separadas por coma.</label>' .
			            		'<input type="text" placeholder="ejemplo@dominio.com, ejemplo2@dominio.com" name="correos" />' .
			            		'<label>Agrega un mensaje personalizado.</label>' .
			            		'<textarea placeholder="Escribe tu mensaje" name="mensaje_p" rows="6"></textarea>' .
			            		'<input type="submit" name="boton" value="Enviar botón" />' .
			            		'<input type="hidden" name="concepto" value="' . $concepto . '"> ' .
			            		'<input type="hidden" name="importe" value="' . $importe . '"> ' .
			            		'<input type="hidden" name="descripcionformapago" value="' . $descripcionformapago . '"> ' . $parcialidades_guardadas .
			            	'</form>';
			    			?>
			            
			            	<div id="codigo-boton">
			            	    <textarea name="texto-boton" cols="" rows="10"><?php echo htmlentities(utf8_decode($boton)); ?></textarea><br />
			            	    <p class="description">Luego de copiar el código puedes probar el botón.</p>
			            	    <?php echo $boton; ?>
			            	</div>

			            	<div class="spacer"></div><!-- división -->

			            	<div id="codigo-boton">
			                	<h2 class="seccion-name group">También puedes enviar el botón por correo.</h2>
			                	<?php echo $boton_mail; ?>
			            	</div>
			            </div>
			        </div>
			     </div>
			<!-- Compartir en redes sociales -->
			<?php anliSocialShare(); ?>
	   
		</article>
	<?php endwhile; // end of the loop. ?>

</section>

<?php get_footer(); ?>