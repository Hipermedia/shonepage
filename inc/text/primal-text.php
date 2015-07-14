<?php 
/** Sección de texto. Estilo PRIMAL
------------------------------------------------------------------- */ 
?>

<!-- PrimalBloques -->
<section class="PrimalText">
	<!-- Contenedor -->
	<div class="PrimalText-contenido u-contenedor">
		
		<!-- Títulos de la sección -->
		<h1 class="PrimalText-titulo">
			<?php the_field('tituloTexto', 'option'); ?>
		</h1>
		<h2 class="PrimalText-subtitulo">
			<?php the_field('subtituloTexto', 'option'); ?>
		</h2>

		<!-- Texto wysiwyg -->
		<div class="PrimalText-texto">
			<?php the_field('contenidoTexto', 'option'); ?>
		</div>		

	</div>
</section>