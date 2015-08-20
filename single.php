<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

<section class="u-contenedor contenido Post">

	<?php while ( have_posts() ) : the_post(); ?>
	    <article>				
			<h1 class="title"><?php the_title(); ?></h1>
			
			<?php the_content(); ?>	
			    
			<?php anliSocialShare(); ?>
	   
		</article>
	<?php endwhile; // end of the loop. ?>
	
	<?php // get_sidebar(); ?>

</section>

<?php get_footer(); ?>