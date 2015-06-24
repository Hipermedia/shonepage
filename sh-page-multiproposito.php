<?php
/**
 * Template Name: Multipropósito
 * Description: Permite crear una página de resumen de categoría obteniéndola vía ACF
 *
 * @package WordPress
 * @subpackage SH_Base
 * @since SH Base 1.0
 */
get_header(); ?>

<?php if(get_field('bloquesMulti')) : ?>
    <section class="content">
        
        <?php while (has_sub_field('bloquesMulti')) : ?>

            <!--  Obtengo tema -->
            <?php if (get_sub_field('tema') == 'claro') { 
                    $clasesBloque = 'claro '; 
                } else { 
                    $clasesBloque = 'oscuro '; 
            } ?>
            
            <!-- tipo de bloque: Texto con imagen de fondo -->
            <?php if (get_sub_field('tipo') == 'textoFondo') : ?>
            
                <!-- tipo de alineación del texto -->
                <?php if (get_sub_field('alineacionHor') == 'izquierda') { 
                        $clasesBloque .= 'izquierda '; 
                    } else { 
                        $clasesBloque .= 'derecha '; 
                    } 
                    
                    if (get_sub_field('alineacionVer') == 'arriba') { 
                        $clasesBloque .= 'arriba '; 
                    } else { 
                        $clasesBloque .= 'abajo '; 
                } ?>

                <?php 
                    $anchoTexto = get_sub_field('anchoTexto');
                ?>
                <article class="texto-fondo <?php print $clasesBloque ?>">
                    <?php while (has_sub_field('media')) : ?>
                        <figure class="media">
                            <figcaption class="caption" style="width: <?php print $anchoTexto; ?>%">
                                <h2 class="titulo"><?php the_sub_field('titulo'); ?></h2>
                                <div class="descripcion">   
                                    <?php the_sub_field('texto'); ?>
                                </div>
                            </figcaption>
                            <img class="imagen" src="<?php the_sub_field('imagen'); ?>" alt="<?php the_sub_field('titulo'); ?>">
                            <a class="boton" href="<?php the_sub_field('url'); ?>">
                                <?php the_sub_field('boton'); ?>
                            </a>
                        </figure>            
                    <?php endwhile; ?>
                </article>

           <?php endif; ?>

            <!-- tipo de bloque: Sólo texto enriquecido -->
            <?php if (get_sub_field('tipo') == 'soloTexto') : ?>

                <article class="solo-texto <?php print $clasesBloque ?>">                
                        <?php the_sub_field('texto'); ?>
                </article>

           <?php endif; ?>

            <!-- tipo de bloque: Texto y media -->
            <?php if (get_sub_field('tipo') == 'textoMedia') { ?>

                <!-- tipo de alineación del texto -->
                <?php if (get_sub_field('alineacionHor') == 'izquierda') { 
                        $clasesBloque .= 'izquierda '; 
                    } else { 
                        $clasesBloque .= 'derecha '; 
                } ?>
            <?php 
                $anchoMedia = get_sub_field('anchoMedia');
            ?>
            <article class="texto-media <?php print $clasesBloque ?>">
                <div class="texto" style="width: <?php the_sub_field('anchoTexto'); ?>%">
                    <?php the_sub_field('texto'); ?>
                </div>
                <?php while (has_sub_field('media')) : ?>
                    <figure class="media" style="width:<?php print $anchoMedia; ?>%">
                        <h2 class="titulo"><?php the_sub_field('titulo'); ?></h2>
                        <div class="texto">
                            <?php the_sub_field('texto'); ?>
                        </div>
                        <img class="imagen" src="<?php the_sub_field('imagen'); ?>" alt="<?php the_sub_field('titulo'); ?>">
                        <a class="boton" href="<?php the_sub_field('url'); ?>">
                            <?php the_sub_field('boton'); ?>
                        </a>
                    </figure>            
                <?php endwhile; ?>
            </article>
           <?php } ?>

           <!-- tipo de bloque: Carrusel -->
            <?php if (get_sub_field('tipo') == 'carrusel') { ?>

            <article class="carrusel <?php print $clasesBloque ?>">
                <?php while (has_sub_field('media')) : ?>
                    <figure class="media">
                        <h2 class="titulo"><?php the_sub_field('titulo'); ?></h2>
                        <div class="texto">
                            <?php the_sub_field('texto'); ?>
                        </div>
                        <img class="imagen" src="<?php the_sub_field('imagen'); ?>" alt="<?php the_sub_field('titulo'); ?>">
                        <a class="boton" href="<?php the_sub_field('url'); ?>">
                            <?php the_sub_field('boton'); ?>
                        </a>
                    </figure>            
                <?php endwhile; ?>
            </article>

           <?php } ?>

        <?php endwhile; ?>

    </section><!-- .content -->
<?php endif; ?>

<?php get_footer(); ?>
