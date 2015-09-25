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
	<?php primalCover(); // Cover con imágen de fondo, imagen principal y títulos ?>

	<?php newsSlider(); ?>

	<?php sauteBlocks();  //  Bloques de contenido salteados ?>

	<?php videoSlider(); ?>

	<?php starchiQuote(); ?>

	<?php filmstripSlider(); ?>
	
	<!-- Bloques -->
	<?php primalBlocks(); //  Bloques de contenido primordiales ?>
	
	<?php primalSlider(); ?>

	<?php primalTabs(); ?>

	<!-- Texto -->
	<?php primalText(); //  Bloques de contenido primordiales ?>
	
	<!-- Testimonios -->
	<?php primalTestimony(); //  Bloques de contenido primordiales ?>

	<?php gallerySlider(); ?>

	<?php primalContact(); ?>

	<?php completeContact(); ?>

	<?php primalGallery(); ?>

	<?php primalPricing(); ?>

	<?php meteoroContact(); ?>

<?php get_footer(); ?>