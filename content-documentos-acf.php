<?php
/**
 * The template used for displaying Documentos via ACF
 *
 * @package WordPress
 * @subpackage SH_Base
 * @since SH Base 1.0
 */
?>
<?php if(get_field('documentos')): ?>
  
	<?php  while ( have_rows('documentos') ) : the_row(); ?>
		<div class="bloque-documento">	
        	
            <?php // elige el icono para el tipo de documento 
			$doc = get_sub_field('tipo'); 
			switch ($doc) {
				case 'texto': 
					$tipo = 'fa-file-text';
					break;
				case 'pdf':
					$tipo = 'fa-file-text';	
					break;
				case 'audio':
					$tipo = 'fa-volume-down';	
					break;
				default:
					$tipo = ' fa-file';
			} ?>
            <a class="link-documento" href="<?php the_sub_field('archivo'); ?>" rel="<?php the_sub_field('titulo'); ?>">
            	<div class="tipo-documento"><i class="fa <?php echo $tipo; ?>"></i></div>
            	<h3><?php the_sub_field('titulo'); ?></h3>
            </a>
            <p class="descripcion-documento">Descripción: <?php the_sub_field('descripcion'); ?></p>
            <a class="descargar-documento" href="<?php the_sub_field('archivo'); ?>" rel="<?php the_sub_field('titulo'); ?>"><i class="fa fa-cloud-download fa-2x"></i>
            <br />Descargar</a>            
        </div>
	
	<?php endwhile; ?>
  
<?php endif; ?>