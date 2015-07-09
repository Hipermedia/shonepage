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

<section>
    <h2>Portada SH One Page Dev</h2>

    <a href="javascript:void(0)" class="btn btn-default">Default</a>
	<a href="javascript:void(0)" class="btn btn-primary">Primary</a>
	<a href="javascript:void(0)" class="btn btn-success">Success</a>
	<a href="javascript:void(0)" class="btn btn-info">Info</a>
	<a href="javascript:void(0)" class="btn btn-warning">Warning</a>
	<a href="javascript:void(0)" class="btn btn-danger">Danger</a>
	</section>

<?php get_footer(); ?>