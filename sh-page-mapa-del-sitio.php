<?php
/**
 * Template Name: Mapa del sitio
 * Description: Permite crear un mapa de sitio vía ACF.
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
                
                <section class="entry-mapa-del-sitio">
                
                    <!-- MAPA DEL SITIO -->
                    <?php if(get_field('mapa_del_sitio')): ?>
                    <div id="mapa-del-sitio">
                        <?php while(has_sub_field('mapa_del_sitio')): ?>
            
                            <a href="<?php the_sub_field('enlace_de_la_seccion'); ?>">
                                <h2><?php the_sub_field('nombre_de_la_seccion'); ?></h2>
                            </a>
            
                            <?php if(get_sub_field('subseccion')): ?>
                                <?php while(has_sub_field('subseccion')): ?>
                                <div id="mapa-del-sitio-subseccion">
                                    <a href="<?php the_sub_field('enlace_de_la_subseccion'); ?>">
                                        <h3><?php the_sub_field('nombre_de_la_subseccion'); ?></h3>
                                    </a>
                                    <div id="mapa-del-sitio-mas-enlaces"><?php the_sub_field('enlaces_dentro_de_la_subseccion'); ?></div>
                                </div><!-- #mapa-del-sitio-sub-seccion -->
                                <?php endwhile; ?>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div><!-- #mapa-del-sitio -->
                    <?php endif; ?>
                    <!-- /MAPA DEL SITIO -->

			</section><!-- .entry-documentos -->

                <footer class="entry-footer">
					<?php the_social_share(); ?>
            	</footer><!-- .entry-footer -->	
                
         	</article><!-- #post-<?php the_ID(); ?> -->	
          
		  <?php endwhile; // end of the loop. ?>
            
    </div><!-- #content -->
</div><!-- #primary -->


<?php get_footer(); ?>