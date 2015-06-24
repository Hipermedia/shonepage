<?php
/**
 * The template used for displaying Pestañas via ACF
 *
 * @package WordPress
 * @subpackage SH_Base
 * @since SH Base 1.0
 */
?>

<?php if(get_field('pestanas')): ?>
	<div id="wrapper-tabs">
		<div class="smoothTabs">

			<ul class="option-tabs group">
				<?php while(has_sub_field('pestanas')): ?>
					<li class="title-sh-tabs"><?php the_sub_field('titulo'); ?></li>
				<?php endwhile; ?>
			</ul>

			<?php while(has_sub_field('pestanas')): ?>
				<div class="content-sh-tabs entry-content">
					<?php the_sub_field('contenido'); ?>
				</div>
			<?php endwhile; ?>

		</div>
	</div>
	<?php smooth_tabs(); ?>
<?php endif; ?>