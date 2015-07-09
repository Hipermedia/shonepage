<?php
/**
 * The template for displaying all pages.
 * This is the template that displays all pages by default.
 */

get_header(); ?>

<section class="content">

	<?php while ( have_posts() ) : the_post(); ?>

		<article class="default-page">
			
			<h1 class="title"><?php the_title(); ?></h1>
			
			<?php the_content(); ?>	
		    
			<?php anliSocialShare(); ?>
		   
		</article><!-- .default-page ?> -->

	<?php endwhile; // end of the loop. ?>

</section><!-- .content -->

<?php get_footer(); ?>