<?php
/**
 * Template Name: Paso 1
 */


//Iniciar sesion
 if (!session_id()) {
         session_start();
        }

get_header(); ?>



<?php $wp_redirect = get_option('home'); ?>

<section class="u-contenedor">

    <?php while ( have_posts() ) : the_post(); ?>
       
        <article class="Page u-contenido">  
            
            <!-- Imágen destacada -->
            <?php if ( has_post_thumbnail() ) : ?>
                <figure class="Page-featuredImage">
                    <?php the_post_thumbnail( 'large' ); ?>
                </figure>
            <?php else : ?>
                <figure class="Page-featuredImage">
                    <img src="<?php the_field('thumbPersonalizada', 'option'); ?>" alt="">
                </figure>
            <?php endif; ?>
            <!-- Título del artículo -->
            <h1 class="Page-title"><?php the_title(); ?></h1>
            <!-- Contenido -->
            <?php the_content(); ?> 
            <div id="content">

                <ul id="breadcrumbs">
                    <li><a class="activo" href="#">Paso 1 - Ingresa tus datos</a></li>
                    <li><a href="#">Paso 2 - Revisión de compra</a></li>
                    <li><a href="#">Paso 3 - Realiza tu pago</a></li>
                    <li><a href="#">Paso 4 - Finalizar</a></li>
                </ul>

                <h1 class="page-name">Paso 1 - Ingresa tus datos</h1>

                <?php //Se reciben y asignan variables

                if ( isset($_POST['boton']) ) {

                    $boton = true;
                    $concepto = $_POST['concepto'];
                    $importe = $_POST['importe'];
                    $descripcionformapago = $_POST['descripcionformapago'];
                    $parcialidades = '';

                    if ( isset( $_POST['parcialidades_guardadas'] ) ) {
                        $parcialidades_guardadas = unserialize( $_POST['parcialidades_guardadas'] );
                    }
                }
                
                if ( isset($_GET['boton']) ) {

                    $boton = true;
                    $concepto = $_GET['concepto'];
                    $importe = $_GET['importe'];
                    $descripcionformapago = $_GET['descripcionformapago'];
                    $parcialidades = '';

                    if ( isset( $_GET['parcialidades_guardadas'] ) ) {
                        $parcialidades_guardadas = unserialize( rawurldecode( $_GET['parcialidades_guardadas'] ) );
                    }
                }

                if ( $boton ) {
                    //Bloque de seguridad (en progreso)
                    //$_SESSION['security_code_2j7hFmd9']  = true;
                ?>


                
                <form action="<?php echo $wp_redirect.'/pago/paso2'; ?>" method="post" class="psh-form form-box round-corner">
                    <div class="column-left">   
                        <h2 class="seccion-name">Detalles de tu pedido</h2>

                        <fieldset>
                            <p>Concepto a pagar: <strong><?php echo $concepto; ?></strong></p>

                            <?php if ( !isset( $_POST['parcialidades_guardadas'] ) OR !isset( $_GET['parcialidades_guardadas'] ) ) { ?>

                                <p>Importe: <strong>$<?php echo $importe; ?> MXN </strong></p>
                                <p class="help"><?php echo $descripcionformapago; ?></p>

                           <?php }?>

                        </fieldset> 
                    </div>

                    <div class="column-right">
                        <h2 class="seccion-name">Ingresa tus datos</h2>
                        <label for="nombre">Nombre(s)</label>
                        <input type="text" name="nombre" placeholder="Escribe tu nombre" value="" required />
                        <label for="apellido">Apellido(s)</label>
                        <input type="text" name="apellido" placeholder="Escribe tu apellido" value="" required/>
                        <label for="correo">Correo electrónico</label>
                        <input type="email" name="correo" placeholder="ejemplo@ejemplo.com" value="" required/>
                    </div>
                        
                    <?php if ( isset( $_POST['parcialidades_guardadas'] ) OR isset( $_GET['parcialidades_guardadas'] )) { ?>
                        
                        <div class="spacer"></div><!-- división -->
                        <h2 class="seccion-name">¿Cómo te gustaría pagar?</h2>
                        <label>
                            <input type="radio" name="formapago" value="contado" required /><strong>De contado: $<?php echo $importe; ?></strong>
                        </label>
                        <p class="psh-descripcion"><?php echo $descripcionformapago; ?></p>

                        <h3>Pago en parcialidades</h3>

                        <?php $contador = 1 ; ?>
                        
                        <?php foreach ( $parcialidades_guardadas as $parcialidad) {

                            $parcialidadserializada = serialize( $parcialidad );
                        ?>
                        
                        <label>
                            <input type="radio" name="formapago" value='<?php echo $parcialidadserializada; ?>' /><?php echo $parcialidad['parcialidades']; ?><strong> pagos de $<?php echo $parcialidad['importeparcialidad']; ?></strong>
                        </label>
                        
                        <p class="psh-descripcion">
                        <?php echo $parcialidad['parcialidades']; ?> pagos de $<?php echo $parcialidad['importeparcialidad']; ?> MXN cada <?php echo $parcialidad['periodicidad'] . ' ' . $parcialidad['periodicidad2']; ?><br />
                        <?php echo $parcialidad['descripcionformapagoparcial']; ?>
                        </p>
                                
                    <?php } ?>
                    
                <?php } ?>

                    <!--El número de transacción ayudará a asegurar el proceso de pago guardandolo en una sesión y comparandolo en siguiente paso con el valor recuperado del post-->
                    <input type="hidden" name="concepto" value="<?php echo $concepto; ?>">
                    <input type="hidden" name="importe" value="<?php echo $importe; ?>">
                    <input type="hidden" name="descripcionformapago" value="<?php echo $descripcionformapago; ?>">
                    <?php if ( !isset( $_POST['parcialidades_guardadas'] ) && !isset( $_GET['parcialidades_guardadas'] ) ) { ?>
                        <input type="hidden" name="formapago" value="contado">
                    <?php } ?>
                    <input type="hidden" name="transaccion" value="">
                            
                    <div class="spacer"></div><!-- división -->
                    <input type="submit" name="boton" value="Continuar">
                
                </form>
                
                
                <?php
                    } else {
                ?>
                
                        No deberías de estar aquí. Si llegaste directamente aquí por error, te sugerimos que regreses al <a href="<?php echo $GLOBALS['url_principal']; ?>">inicio de nuestro sitio web</a>
                
                <?php } ?>

            </div><!-- #psh-general-container -->
            </div><!-- #psh-content -->
            <!-- Compartir en redes sociales -->
            <?php anliSocialShare(); ?>
       
        </article>
    <?php endwhile; // end of the loop. ?>

</section>


<?php get_footer(); ?>

