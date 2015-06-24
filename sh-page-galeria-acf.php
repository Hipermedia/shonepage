<?php
/**
 * Template Name: Galería
 * Description: Crea la portada de un conjunto de galerías vía ACF.
 *
 * @package WordPress
 * @subpackage SH_Base
 * @since SH Base 1.0
 */

get_header(); ?>

<section class="content">
<?php get_template_part( 'content', 'submenu-acf' ); ?>
    <div id="content" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

            <article>
                <header class="page-header">
                	<h1 class="page-title"><?php the_title(); ?></h1>
                </header><!-- .entry-header -->
                
                <section class="entry-content">
                	<?php the_content(); ?>
                </section><!-- .entry-content -->	
               
                <section class="entry-galeria-medios2 group">
                    
                    <!-- PORTADAS DE GALERÍA DE MEDIOS-->
                    <?php if(get_field('galeria')): ?>
                    	
                        <?php while(has_sub_field('galeria')): ?>
                     
							    <a class="bloque-galeria-medios2" href="<?php the_sub_field('url'); ?>">
                                    <div class="tipo-medio">
                                        <i class="fa <?php echo $tipo; ?> fa-2x"></i>
                                    </div>
                                    <h3><?php the_sub_field('titulo'); ?></h3>
                                    <img src="<?php the_sub_field('imagen'); ?>" />      
                                </a>
						
						<?php endwhile; ?>
                    <?php endif; ?>

				</section>
    			
                <footer class="entry-footer">
					<?php the_social_share(); ?>
            	</footer><!-- .entry-footer -->	
                
         	</article><!-- #post-<?php the_ID(); ?> -->	
          
		  <?php endwhile; // end of the loop. ?>
            

</section><!-- .content -->

<?php get_footer(); ?>