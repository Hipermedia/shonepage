<?php 
/** Bloques de contenido. Estilo PRIMAL
------------------------------------------------------------------- */ 
?>
<!-- PrimalBloques -->
<section class="PrimalBlocks">
	<!-- Contenedor -->
	<div class="PrimalBlocks-contenido u-contenedor">
		<!-- Títulos de la sección -->
		<h1 class="PrimalBlocks-titulo"><?php the_field('tituloBloques', 'option'); ?></h1>
		<h2 class="PrimalBlocks-subtitulo">
			<?php the_field('subtituloBloques', 'option'); ?>
		</h2>
		
		<?php if( have_rows('bloquesBloques', 'option') ): ?>
			<?php while( have_rows('bloquesBloques', 'option') ): the_row(); ?>
				
				<!-- bloque -->
				<div class="PrimalBlocks-block">
					<figure class="PrimalBlocks-blockFigure">
						<img src="<?php the_sub_field('imagen'); ?>" alt="<?php the_sub_field('titulo'); ?>">
					</figure>
					<h3 class="PrimalBlocks-blockTitulo"><?php the_sub_field('titulo'); ?></h3>
					<h4 class="PrimalBlocks-blockSubtitulo"><?php the_sub_field('subtitulo'); ?></h4>
					<p class="PrimalBlocks-blockDescripcion">
						<?php the_sub_field('descripcion'); ?>
					</p>
					<a href="" class="PrimalBlocks-blockAction btn btn-default btn-raised">
						<i class="fa fa-plus"></i>
						 <?php the_sub_field('accion'); ?>
					</a>
				</div>

			<?php endwhile; ?>
		<?php endif; ?>
	</div>
</section>