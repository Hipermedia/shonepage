<?php
/**
 * Template Name: Landing Page
 * Description: Página de aterrizaje para hacer una conversión de un producto o servicio
 *
 * @package WordPress
 * @subpackage SH_Base
 * @since SH Base 1.1
 */

get_header(); ?>

<main class="landing-page" role="main">

    <?php while ( have_posts() ) : the_post(); ?>

          	<h1 class="entry-title"><?php the_title(); ?></h1>
            
        <section class="entry-content">
            <figure>
                <?php if ( get_field('lp_media_video') ) { ?>
                    <a href="<?php echo get_field('lp_media_video') ?>" rel="wp-video-lightbox">
                        <img src="<?php echo get_field('lp_media_imagen'); ?>" alt="<?php echo get_field('lp_media_titulo'); ?>">
                    </a>
                <?php } else { ?>
                    <img src="<?php echo get_field('lp_media_imagen'); ?>" alt="<?php echo get_field('lp_media_titulo'); ?>">
                <?php }?>    
            </figure/>
            <?php the_content(); ?>
        </section>
        
        <section class="entry-form">
            <?php echo do_shortcode(get_field('lp_form')); ?>
        </section><!-- .entry-content -->
         
        <?php if(get_field('lp_bloque_adicional')): ?>
            <section class="entry-bloques">
                <?php while(has_sub_field('lp_bloque_adicional')): ?>
                    <section class="bloque-personalizado">
                        <figure class="imagen">
                            <img src="<?php the_sub_field('imagen'); ?>" alt="<?php the_sub_field('titulo'); ?>">
                        </figure>
                        <h2 class="titulo"><?php the_sub_field('titulo'); ?></h2>
                        <div class="contenido">
                            <?php the_sub_field('contenido'); ?>
                        </div>
                    </section>
                <?php endwhile; ?>
            </section><!-- .entry-content -->
		<?php endif; ?>

        <footer class="entry-footer">
            <?php the_social_share(); ?>
        </footer><!-- .entry-footer -->	
          
    <?php endwhile; // end of the loop. ?>
            
</main><!-- main content -->

<?php get_footer(); ?>