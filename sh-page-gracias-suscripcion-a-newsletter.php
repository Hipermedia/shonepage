<?php
/**
 * Template Name: Gracias suscripción a newsletter
 * Description: Página personalizada de ejemplo
 *
 * @package WordPress
 * @subpackage SH_Base
 * @since SH Base 1.0
 */
//echo '<pre style="display:block;">'; print_r($_POST); echo '</pre>'; // PRINT_R

$procesado = 'no';
if ( isset( $_POST['submit'] ) ) {

	$name = '';
	$email = '';

	/* Se validan datos del usuario */
	if ( isset( $_POST['nombre'] ) ) { $name = $_POST['nombre']; }
	if ( isset( $_POST['email'] ) ) { $email = $_POST['email']; }

	/* Se graba en sendy la información */
	if ($name && $email) {
		
		$procesado = 'si';

		/* Se asignan variables de la lista de suscripción */
		$list = $_POST['list'];
		$Dominio = $_POST['Dominio'];
		$Fechadeingreso = $_POST['Fechadeingreso'];
		$urltopost = "http://www.solucioneshipermedia.com/sendy/subscribe"; //The url where you want to post your data to
		$datatopost = array (
		'name' => $name,
		'email' => $email,
		'list' => $list,
		'Dominio' => $Dominio,
		'Fechadeingreso' => $Fechadeingreso,
		'submit' => true,
		); //The post data as an associative array. The keys are the post variables
		
		$ch = curl_init ($urltopost); //Initializes cURL
		curl_setopt ($ch, CURLOPT_POST, true); //Tells cURL that we want to send post data
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost); //Tells cURL what are post data is
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true); //Tells cURL to return the output of the post
		$returndata = curl_exec ($ch); //Executes the cURL and saves theoutput in $returndata
		//echo $returndata;

	}
}

get_header(); ?>

<div id="primary-full">
    <div id="content" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

            <article>
                <header class="entry-header">
                	<h1 class="entry-title"><?php the_title(); ?></h1>
                </header><!-- .entry-header -->
                
                <section class="entry-content">
                	<?php the_content(); ?>
                </section><!-- .entry-content -->
                
                <section>
                	<?php if ( $procesado == 'si' )  { ?>
						<?php echo $name; ?>, gracias por suscribirte a nuestra lista de correos. Tú dirección <?php echo $email; ?> se guardó con éxito.
                	<?php } ?>
				</section>

                <footer class="entry-footer">
					<?php the_social_share(); ?>
            	</footer><!-- .entry-footer -->	
                
         	</article><!-- #post-<?php the_ID(); ?> -->	
          
		  <?php endwhile; // end of the loop. ?>
            
    </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>