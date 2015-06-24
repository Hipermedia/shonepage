<?php
/**
 * Template Name: Catálogo
 * Description: Crea la portada de un conjunto de galerías vía ACF.
 */

get_header(); ?>
<section class="content">
    
    <?php while ( have_posts() ) : the_post(); ?>
        
        <article class="catalog">

            <h1 class="title"><?php the_title(); ?></h1>
            
            <?php the_content(); ?>

            <div class="items group">
                <?php if(get_field('catalogo')): ?>
                    <?php while(has_sub_field('catalogo')): ?>

                        <div class="item">
                            
                            <?php if( get_sub_field('url') ) {?>
                                <a class="group" href="<?php the_sub_field('url'); ?>">
                                    <img src="<?php the_sub_field('portada'); ?>" />
                                    <h2><?php the_sub_field('titulo'); ?></h2>                    
                                    <h3><?php the_sub_field('subtitulo'); ?></h3>
                                    <p><?php the_sub_field('descripcion'); ?></p>
                                </a>
                            <?php } else { ?>
                                <img src="<?php the_sub_field('portada'); ?>" />
                                <h2><?php the_sub_field('titulo'); ?></h2>
                                <h3><?php the_sub_field('subtitulo'); ?></h3>
                                <p><?php the_sub_field('descripcion'); ?></p>
                            <?php } ?>
                            
                        </div>
                    
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
			
	        <?php the_social_share(); ?>
	
            
     	</article><!-- #post-<?php the_ID(); ?> -->	
      
    <?php endwhile; // end of the loop. ?>
        
</section><!-- .content -->

<?php get_footer(); ?>