<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

<section class="content">

	<?php while ( have_posts() ) : the_post(); ?>
	     	<article class="single">
				
				<h1 class="title"><?php the_title(); ?></h1>
			
				<?php the_content(); ?>	
			    
				<?php anliSocialShare(); ?>
	   
		</article><!-- .single ?> -->
	<?php endwhile; // end of the loop. ?>
	
	<?php get_sidebar(); ?>

</section><!-- .content -->

<?php get_footer(); ?>