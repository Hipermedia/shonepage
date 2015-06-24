<?php
/**
 * The template used to display Tag Archive pages
 *
 * @package WordPress
 * @subpackage SH_Base
 * @since SH Base 1.0
 */

get_header(); ?>

<section class="content">

	<?php if ( have_posts() ) : ?>

		<!-- Título -->
		<h1 class="titulo">
			<?php printf( __( 'Tag Archives: %s', 'shbase' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?>
		</h1>
		
		<!-- Descripción -->
		<?php $tag_description = tag_description();
			if ( ! empty( $tag_description ) )
				echo apply_filters( 'tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>' );	?>	
		
		<!-- Loop principal -->
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; ?>
        
        <?php the_numbered_nav(); ?>
	
	<?php else : ?>

		<article id="post-0" class="post no-results not-found">
			<h1 class="titulo"><?php _e( 'Nothing Found', 'shbase' ); ?></h1>
			
			<div class="entry-content">
				<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'shbase' ); ?></p>
				<?php get_search_form(); ?>				
			</div><!-- .entry-content -->
		</article><!-- #post-0 -->
	<?php endif; ?>

</section><!-- .content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
