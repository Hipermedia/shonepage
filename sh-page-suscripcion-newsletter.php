<?php
/**
 * Template Name: Suscripción a newsletter
 * Description: Permite que tus visitantes se suscriban a tu lista de envio de correos.
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
                
                <section>                
                	<?php get_template_part( 'content', 'formulario-sendy' ); ?>
			 	</section>

                <footer class="entry-footer">
					<?php the_social_share(); ?>
            	</footer><!-- .entry-footer -->	
                
         	</article><!-- #post-<?php the_ID(); ?> -->	
          
		  <?php endwhile; // end of the loop. ?>
            
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>