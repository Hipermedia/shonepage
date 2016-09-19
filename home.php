<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage SH_Base
 */

get_header(); ?>

	<!-- Cover -->
	<?php primalCover(); // Cover con imagen de fondo, imagen principal y títulos ?>
	
	<!-- Bloques comunes -->
	<?php primalBlocks(); //  Bloques de contenido primordiales ?>
	
	<?php primalTabs(); // Bloque de pestañas ?>
	
	<?php sauteBlocks(); //  Bloques de contenido salteados ?>

	<?php primalText(); //  Bloques de contenido primordiales ?>

	<?php starchiQuote(); // Bloque a fullwidth para frase con imagen de fondo parallax ?>


	<!-- Sliders -->
	<?php newsSlider(); // Slider con formato para mostrar nosticias ?>

	<?php videoSlider(); // Rotatorio de videos ?>

	<?php filmstripSlider(); // Slider en formato filmstrip ?>

	<?php textSlider(); // Slider básico de texto ?>

	<?php primalSlider(); // Slider tradicional ?>

	<?php gallerySlider(); // Slider para galerías ?>
	

	<!-- Testimonios -->
	<?php cardsTestimony(); // Bloque de testimonios con efecto rollover ?>

	<?php primalTestimony(); //  Bloques de contenido primordiales ?>


	<!-- Galerías -->
	<?php primalGallery(); // Bloque para galerías ?>

	<?php imgridPortfolio(); // Fotos con plugin Imgrid ?>


	<!-- Bloques para contacto -->
	<?php meteoroContact(); // Bloque de contacto con mapa de fondo ?>
	
	<?php primalContact(); // Bloque de contacto con imagen de fondo ?>

	<?php completeContact(); // Bloque de contacto con todos los datos, formulario y mapa ?>

	
	<!-- Bloques misceláneos -->
	<?php primalDocs(); // Bloque para presentar documentos ?>

	<?php primalPricing(); // Bloques de precios ?>

	<?php backgroundVideo(); // Bloque con video de fondo ?>


	<!-- Footer en columnas -->
	<?php primalFooter(); // Footer con formato en columnas ?>

<?php get_footer(); ?>
