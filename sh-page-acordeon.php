<?php
/**
 * Template Name: Acordeón
 * Description: Crea un acordeón vía ACF.
 *
 * @package WordPress
 * @subpackage SH_Base
 * @since SH Base 1.0
 */

get_header(); ?>

<div id="primary-full">
    <div id="content" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

            <article>
                <header class="entry-header">
                	<h1 class="entry-title"><?php the_title(); ?></h1>
                </header><!-- .entry-header -->
                
                <section class="entry-content">
                	<?php the_content(); ?>
                </section><!-- .entry-content -->	
               
                <section class="entry-acordeon">
					<?php if(get_field('acordeon')): ?>
                        <?php $num_titulo = 1; ?>
                        <?php $num_contenido = 1; ?>
                        <?php while(has_sub_field('acordeon')): ?>
                            <section class="bloque-acordeon">
                                <h3 id="titulo-acordeon<?php echo $num_titulo++; ?>" class="titulo-acordeon fa fa-plus-square"><span><?php the_sub_field('titulo'); ?></span></h3>
                                <div id="contenido-acordeon<?php echo $num_contenido++; ?>" class="contenido-acordeon entry-content"><?php the_sub_field('contenido'); ?></div>
                            </section>
                        <?php endwhile; ?>
                    <?php endif; ?>

                            <script>
                            jQuery(document).ready(function($) {
                                $(".contenido-acordeon").hide();
                                <?php if(get_field('acordeon')): ?>
                                    <?php $cuentita = 1; ?>
                                    <?php while(has_sub_field('acordeon')): ?>
                                        var on<?php echo $cuentita; ?> = false;
                                        $('h3#titulo-acordeon'+<?php echo $cuentita; ?>).click(function () {
                                            $('div#contenido-acordeon'+<?php echo $cuentita; ?>).toggle('slow');
                                            var d = document.getElementById("titulo-acordeon<?php echo $cuentita; ?>");
                                            if(on<?php echo $cuentita; ?>) {
                                                d.className = "titulo-acordeon fa fa-plus-square";
                                                 on<?php echo $cuentita; ?> = false;
                                            } else {
                                                d.className = "titulo-acordeon fa fa-minus-square";
                                                on<?php echo $cuentita; ?> = true;
                                            }
                                        });
                                    <?php $cuentita++; ?>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            });
                            </script>
                </section>
    			
                <footer class="entry-footer">
					<?php the_social_share(); ?>
            	</footer><!-- .entry-footer -->	
                
         	</article><!-- #post-<?php the_ID(); ?> -->	
          
		  <?php endwhile; // end of the loop. ?>
            
    </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>