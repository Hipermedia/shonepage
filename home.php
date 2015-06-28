<?php
/**
 * The main template file.
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

get_header(); ?>

<section role="main" class="portada">

	<!-- Flexslider vía OT -->
    <?php get_template_part( 'content', 'flexslider-ot' ); ?>
    

    <!-- Button trigger modal -->
<!--     <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
      Launch demo modal
    </button> -->

    <!-- Modal -->
    <section>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
              </div>
              <div class="modal-body">
                Ventanilla modal :D
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
    </section>

   <!-- CAMPOS OT DE ONE PAGE -->
   <section class="landing">
   <?php while ( have_posts() ) : the_post(); ?>
    <section class="bloque primero">
        <div class="wrapper">
            <div class="texto">
                <?php echo get_ot('texto_primera',''); ?>
                <a href="<?php echo get_ot('url_btn1_primera',''); ?>" class="boton" data-toggle="modal" data-target="#myModal"><?php echo get_ot('boton1_primera',''); ?></a>
                <a href="<?php echo get_ot('url_btn2_primera',''); ?>" class="boton"><?php echo get_ot('boton2_primera',''); ?></a>
            </div>
            <figure class="imagen">
                <img src="<?php echo get_ot('imagen_primera',''); ?>" alt="">
            </figure>
        </div>
    </section>
    
    <section class="bloque segundo">
        <div class="wrapper">
            <h2><?php echo get_ot('encabezado_segunda',''); ?></h2>
            <?php $bloques_segunda = get_ot('imagen_texto_segunda', array()); ?>
            <?php foreach ($bloques_segunda as $bloque) { ?>
                <div class="contenido">
                    <figure class="imagen">
                        <img src="<?php echo $bloque['imagen']; ?>" alt="">
                    </figure>
                    <h3><?php echo $bloque['title']; ?></h3>
                    <p><?php echo $bloque['texto']; ?></p>
                </div>
            <?php } ?>
        </div>
    </section>
    
    <?php $bloques_pemarte = get_ot('bloques_tercera', array()); ?>
    <?php foreach ($bloques_pemarte as $bloque ) { ?>
    <section class="bloque pemarte">
        <div class="wrapper">
            <div class="texto">
                <h2><?php echo $bloque['title']; ?></h2>
                <p><?php echo $bloque['texto']; ?></p>
                <a href="<?php echo $bloque['url']; ?>" class="boton"><?php echo $bloque['boton']; ?></a>
            </div>
        </div>
        <figure class="imagen">
            <img src="<?php echo $bloque['imagen']; ?>" alt="">
        </figure>
    </section>
    <?php } ?>
    
    <!-- hacer función para que se imprima sólo si hay contenido -->
    <!-- <section class="bloque final">
        <div class="wrapper">
            <figure class="imagen">
                <img src="<?php echo get_ot('imagen_cuarta'); ?>" alt="">
            </figure>
            <div class="texto">
                <?php echo get_ot('texto_cuarta'); ?>
                <a href="<?php echo get_ot('url_btn_cuarta',''); ?>" class="boton"><?php echo get_ot('boton_cuarta',''); ?></a>
            </div>
        </div>
    </section> -->
    
   <?php endwhile; // end of the loop. ?>
   </section>

    <!-- Galería en portafa (Formato filmstrip) -->
    <?php get_template_part( 'inc/content', 'galeria-filmstrip-slider' ); ?>
          
</section><!-- .portada -->

<?php get_footer(); ?>