<?php
/**
 * Template Name: Usuario registrado
 * Description: Muestra el contenido si el usuario está registrado, de lo contrario lo redirige
 *
 * @package WordPress
 * @subpackage SH_Base
 * @since SH Base 1.0
 */
soloUsuarioRegistrado(); 
get_header(); ?>

<section class="content">

    <?php while ( have_posts() ) : the_post(); ?>

        <article class="default-page">
            
            <h1 class="title"><?php the_title(); ?></h1>
            
            <?php the_content(); ?> 
            
            <?php the_social_share(); ?>
           
        </article><!-- .default-page ?> -->

    <?php endwhile; // end of the loop. ?>

</section><!-- .content -->

<?php get_footer(); ?>