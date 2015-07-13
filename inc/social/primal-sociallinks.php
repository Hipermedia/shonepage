<?php 
/** Botones de compartir en redes sociales. Estilo CLASSIC.
------------------------------------------------------------------- */ 
?>

<div id="header-social" class="social">
    <!-- Facebook -->
    <?php if (get_field('facebookContacto', 'option') != '') { ?>
        <a href="<?php the_field('facebookContacto', 'option'); ?>" title="Facebook" target="_blank"><i class="fa fa-facebook-square fa-3x"></i></a>
    <?php }  ?>
    <!-- Twitter -->
    <?php if (get_field('twitterContacto', 'option') != '') { ?>
        <a href="<?php get_field('twitterContacto', 'option'); ?>"title="Twitter" target="_blank"><i class="fa fa-twitter-square fa-3x"></i></a>
    <?php }  ?>
    <!-- Youtube -->
    <?php if (get_field('youtubeContacto', 'option') != '') { ?>
        <a href="<?php get_field('youtubeContacto', 'option'); ?>" title="Youtube" target="_blank"><i class="fa fa-youtube-square fa-3x"></i></a>
    <?php }  ?>
    <!-- Google Plus -->
    <?php if (get_field('googleContacto', 'option') != '') { ?>
        <a href="<?php get_field('googleContacto', 'option'); ?>" title="Google Plus" target="_blank"><i class="fa fa-google-plus-square fa-3x"></i></a>
    <?php }  ?>      
</div><!-- #social -->