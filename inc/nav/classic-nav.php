<?php 
/** Menu de navegación clásico de WP
------------------------------------------------------------------- */ 
?>
<nav id="header-main-nav" class="mainNav" role="navigation">
    <!-- Icono de menú para versión adaptativa -->
    <a class="toggle-nav" href="#">MENU DE NAVEGACIÓN</a>
    <!-- Menu WordPress -->
    <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => '', 'menu_class' => 'activo', 'menu_id' => 'header-menu') ); ?>
</nav>