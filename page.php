<?php
/**
 * The template for displaying all pages.
 * This is the template that displays all pages by default.
 */

get_header(); ?>

<section class="u-contenedor">

	<?php while ( have_posts() ) : the_post(); ?>
	   
	    <article class="Page u-contenido">	
			
			<!-- Imágen destacada -->
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="Page-featuredImage">
					<?php the_post_thumbnail( 'large' ); ?>
				</figure>
			<?php endif; ?>
			<!-- Título del artículo -->
			<h1 class="Page-title"><?php the_title(); ?></h1>
			<!-- Contenido -->
			<?php the_content(); ?>	
			<!-- Compartir en redes sociales -->
			<?php anliSocialShare(); ?>
	   
		</article>
	<?php endwhile; // end of the loop. ?>

</section>

<?php get_footer(); ?>