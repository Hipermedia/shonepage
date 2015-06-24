<?php
/** Archivo de funciones SH Base */

/**
 * Funciones personalizadas de Soluciones Hipermedia
 */

//Enable errors
function show_errors($array=array()) {
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
}

/* Redirige a la portada si el usuario no está logeado 
* ------------------------------------------------------------- */
 function soloUsuarioRegistrado() 
 {
	 if (!is_user_logged_in()) 
	 {
	   wp_redirect( home_url(), 302 ); exit;
	 } 
 }
/* Oculta la barra de administrador si no es usuario 
 * ------------------------------------------------------------- */
function remueveBarraAdmin() 
{
	if (!current_user_can('administrator') && !is_admin()) 
	{
	  show_admin_bar(false);
	}
}
add_action('after_setup_theme', 'remueveBarraAdmin');

 /* Redirige a no administradores al home del sitio  
 * ------------------------------------------------------------- */
function sh_login_redirect( $redirect_to, $request, $user  ) 
{
	return ( is_array( $user->roles ) && in_array( 'administrator', $user->roles ) ) ? admin_url() : site_url();
}
add_filter( 'login_redirect', 'sh_login_redirect', 10, 3 );


/** Imprime una variable de OT; valida que exista la función y permite 
 * imprimir un valor por defecto si el campo está vacio  
 */
function print_ot($variable, $defecto) { 
  if (function_exists ('ot_get_option')) {
        	if (ot_get_option ($variable) != '') { echo ot_get_option ($variable); } else { echo $defecto; } 
  } else { echo 'No esta activado OT'; }
}
/** Regresa una variable de OT; valida que exista la función y permite
 * imprimir un valor por defecto si el campo está vacio  
 */
function get_ot($variable) { 
  if (function_exists ('ot_get_option')) {
        	if (ot_get_option ($variable) != '') { return ot_get_option ($variable); } else { return ''; } 
  } 
}
/** Imprime el url del home  */
function inicio_url() {
	print get_home_url();
}
/** Envía el valor del url del home  */
function get_inicio_url() {
	return get_home_url();
}
/** Envía el valor del url del tema en uso  */
function plantilla_url() {
	echo get_bloginfo( 'template_url' );
}
/** Envía el valor del url del tema en uso  */
function get_plantilla_url() {
	return get_bloginfo( 'template_url' );
}
function the_social_share() {
	get_template_part( 'socialshare');
}
function the_custom_meta() {
  print 'Publicado por <strong>' . get_the_author() .'</strong>'
  		. ' el ' . get_the_time('j \d\e\ F \d\e\ Y') 
  		. ' a las ' . get_the_time('g:i a');
}

/**
 * Pide a WP que corra shbase_setup() cuando el hook 'after_setup_theme' se está ejecutando
 */
add_action( 'after_setup_theme', 'shbase_setup' );

if ( ! function_exists( 'shbase_setup' ) ):
/**
 * Establece y activa varias de las capacidades de WordPress para el tema y desactiva otras
 *
 */
function shbase_setup() {

	/* Permite traducir el tema
	 * la traducción se agrega en el directorio /languages/ 
	 */
	load_theme_textdomain( 'shbase', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'shbase' ) );

	// Add support for custom backgrounds.
	add_theme_support( 'custom-background', array(
		// Let WordPress know what our default background color is.
		// This is dependent on our current color scheme.
		'default-color' => $default_background_color,
	) );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

	
	// Elimina algunas opciones del menu de administración de WP
	add_action( 'admin_menu', 'my_remove_menus', 999 );

	function my_remove_menus() {

		// provide a list of usernames who can edit all menues here
		$admins = array( 
			'admin',
			'hipermedia',
		);
	 
		// get the current user
		$current_user = wp_get_current_user();
	 
		// match and remove if needed
		if( !in_array( $current_user->user_login, $admins ) )
		{
			//TOP MENUES
			//remove_menu_page( 'index.php' );                  //Dashboard
			//remove_menu_page( 'edit.php' );                   //Posts
			//remove_menu_page( 'upload.php' );                 //Media
			//remove_menu_page( 'edit.php?post_type=page' );    //Pages
			remove_menu_page( 'edit-comments.php' );          //Comments
			//remove_menu_page( 'themes.php' );                 //Appearance
			remove_menu_page( 'users.php' );                  //Users
			remove_menu_page( 'options-general.php' );        //Settings
			remove_menu_page( 'tools.php' );					//Tools
			remove_menu_page( 'plugins.php' );					//Plugins
			remove_menu_page( 'ot-settings' );					//OT Settings
			remove_menu_page('edit.php?post_type=acf');			//ACF Settings
			remove_menu_page( 'wpcf7' );
			
			//SUBMENUES
			remove_submenu_page( 'index.php', 'update-core.php' );
			remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
			remove_submenu_page( 'admin.php', '?page=wpcf7' );
			remove_submenu_page( 'themes.php', 'themes.php' );					//Theme changer
			remove_submenu_page( 'themes.php', 'widgets.php' );
			remove_submenu_page( 'themes.php', 'customize.php?return=%2Fwp-admin%2Findex.php' );						//Theme Customizer
			remove_submenu_page( 'themes.php', 'theme-editor.php' );					//Theme Editor
			remove_submenu_page( 'themes.php', 'custom-background' );
			remove_submenu_page( 'themes.php', 'slb_options' );
			remove_submenu_page( 'options-general.php', 'options-permalink.php' );		//Permalinks option
		}	 
	}
	
}
endif; // shbase_setup

/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function shbase_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'shbase_excerpt_length' );

if ( ! function_exists( 'shbase_continue_reading_link' ) ) :
/**
 * Returns a "Continue Reading" link for excerpts
 */
function shbase_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continuar leyendo <span class=\"meta-nav\"></span>', 'shbase' ) . '</a>';
}
endif; // shbase_continue_reading_link

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and shbase_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function shbase_auto_excerpt_more( $more ) {
	return ' &hellip;' . shbase_continue_reading_link();
}
add_filter( 'excerpt_more', 'shbase_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function shbase_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= shbase_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'shbase_custom_excerpt_more' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function shbase_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'shbase_page_menu_args' );

/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since SH Base 1.0
 */
function shbase_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'shbase' ),
		'id' => 'sidebar-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'shbase_widgets_init' );

if ( ! function_exists( 'shbase_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function shbase_content_nav( $html_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo esc_attr( $html_id ); ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'shbase' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'shbase' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'shbase' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}
endif; // shbase_content_nav


/**
 * Return the first link from the post content. If none found, the
 * post permalink is used as a fallback.
 *
 * @uses get_url_in_content() to get the first URL from the post content.
 *
 * @return string
 */
function shbase_get_first_url() {
	$content = get_the_content();
	$has_url = function_exists( 'get_url_in_content' ) ? get_url_in_content( $content ) : false;

	if ( ! $has_url )
		$has_url = shbase_url_grabber();

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Return the URL for the first link found in the post content.
 *
 * @since SH Base 1.0
 * @return string|bool URL or false when no link is present.
 */
function shbase_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}

if ( ! function_exists( 'shbase_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own shbase_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since SH Base 1.0
 */
function shbase_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'shbase' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'shbase' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'shbase' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'shbase' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'shbase' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'shbase' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'shbase' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for shbase_comment()

if ( ! function_exists( 'shbase_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own shbase_posted_on to override in a child theme
 *
 * @since SH Base 1.0
 */
function shbase_posted_on() {
	printf( __( '<span class="sep">Publicado el </span><strong><time class="entry-date" datetime="%3$s">%4$s</time></strong><span class="by-author"> <span class="sep"> por </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'shbase' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'Ver todas las publicaciones por %s', 'shbase' ), get_the_author() ) ),
		get_the_author()
	);
}
endif;

/**
 *  Crea los meta tag de Google en nuestro tema de WordPress
 */
function add_google_tags() {
	global $post;
	$image_obt = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
	$image = $image_obt['0'];
	if (!$image)
	$image =  get_bloginfo( 'template_url' ) . '/images/logo.png';
?>

<meta itemprop="name" content="<?php the_title(); ?>">
<meta itemprop="description" content="<?php wp_limit_post(120,'...',true); ?>">
<meta itemprop="image" content="<?php echo $image; ?>">

<?php 
add_action('wp_head', 'add_google_tags',99);
}

/**
 * Retrieves the IDs for images in a gallery.
 *
 * @uses get_post_galleries() first, if available. Falls back to shortcode parsing,
 * then as last option uses a get_posts() call.
 *
 * @since SH Base 1.6.
 *
 * @return array List of image IDs from the post gallery.
 */
function shbase_get_gallery_images() {
	$images = array();

	if ( function_exists( 'get_post_galleries' ) ) {
		$galleries = get_post_galleries( get_the_ID(), false );
		if ( isset( $galleries[0]['ids'] ) )
		 	$images = explode( ',', $galleries[0]['ids'] );
	} else {
		$pattern = get_shortcode_regex();
		preg_match( "/$pattern/s", get_the_content(), $match );
		$atts = shortcode_parse_atts( $match[3] );
		if ( isset( $atts['ids'] ) )
			$images = explode( ',', $atts['ids'] );
	}

	if ( ! $images ) {
		$images = get_posts( array(
			'fields'         => 'ids',
			'numberposts'    => 999,
			'order'          => 'ASC',
			'orderby'        => 'menu_order',
			'post_mime_type' => 'image',
			'post_parent'    => get_the_ID(),
			'post_type'      => 'attachment',
		) );
	}

	return $images;
}

//Fecha en array. Procesa una fecha en formato año, mes, día. El separador es obligatorio y puede ser cualquier símbolo.
function fecha_en_array($fecha_para_array) {
	$fecha_en_array['year'] = substr($fecha_para_array, -10, 4);
	$fecha_en_array['month'] = substr($fecha_para_array, -5, 2);
	$fecha_en_array['day'] = substr($fecha_para_array, -2, 2);
	return $fecha_en_array;
}

//Mes en texto. Convierte un número en formato 00 a el mes correspondiente.
function mes_en_texto($num_mes) { 
  switch ($num_mes) {
	case "01": 	echo "enero"; break;
    case "02": 	echo "febrero"; break;
	case "03": 	echo "marzo"; break;
    case "04": 	echo "abril"; break;
	case "05": 	echo "mayo"; break;
    case "06": 	echo "junio"; break;
	case "07": 	echo "julio"; break;
    case "08": 	echo "agosto"; break;
	case "09": 	echo "septiembre"; break;
    case "10": 	echo "octubre"; break;
	case "11": 	echo "noviembre"; break;
    case "12": 	echo "diciembre"; break;
    }
}

//Paginación
if ( ! function_exists( 'the_numbered_nav' ) ) :
function the_numbered_nav() { ?>
	<?php global $wp_query; ?>
	<nav id="numbered-pagination">
		<?php $big = 999999999; // need an unlikely integer
        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
        ) ); ?>
	</nav>
<?php }
endif; // shbase_numerated_nav

//Paginación personalizada
if ( ! function_exists( 'the_custom_numbered_nav' ) ) :
function the_custom_numbered_nav( $custom_query ) { ?>
	<?php $custom_query; ?>
	<nav id="numbered-pagination">
		<?php $big = 999999999; // need an unlikely integer
        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $custom_query->max_num_pages,
        ) ); ?>
	</nav>
<?php }
endif; // shbase_numerated_nav

//FLEXSLIDER
function flexslider_sh() {
$template_url = get_bloginfo( 'template_url' );

	wp_enqueue_style( 'flexslider-style', $template_url .'/inc/flexslider/flexslider.css', '1' );

	wp_enqueue_script( 'flexslider', $template_url .'/inc/flexslider/jquery.flexslider-min.js', array('jquery'), '1.10.2', 1);
		
	/*wp_enqueue_script( 'methodsvalidate', $template_url .'/js/additional-methods.js', array('jquery'), '1.10.2', 1);*/
	
	wp_enqueue_script( 'config-flexslider', $template_url .'/inc/flexslider/config.js', array('jquery','flexslider'), '', 1);

}

//FLEXSLIDER CUSTOM CONFIG
function flexslider_custom_config_sh() {
$template_url = get_bloginfo( 'template_url' );

	wp_enqueue_style( 'flexslider-style', $template_url .'/inc/flexslider/flexslider.css', '1' );

	wp_enqueue_script( 'flexslider', $template_url .'/inc/flexslider/jquery.flexslider-min.js', array('jquery'), '1.10.2', 1);
}

//SMOOTH TABS
function smooth_tabs() {
$template_url = get_bloginfo( 'template_url' );

	wp_enqueue_style( 'smooth-tabs-style', $template_url .'/inc/tabs/jquery.smooth_tabs.css', '1' );

	wp_enqueue_script( 'smooth-tabs', $template_url .'/inc/tabs/jquery.smooth_tabs.js', array('jquery'), '1.10.2', 1);
	
	wp_enqueue_script( 'config-smooth-tabs', $template_url .'/inc/tabs/smooth_tabs.config.js', array('jquery','smooth-tabs'), '', 1);

}

//PRETTY PHOTO
function pretty_photo_sh() {
$template_url = get_bloginfo( 'template_url' );

	wp_enqueue_style( 'prettyphotho-style', $template_url .'/inc/prettyphoto/css/prettyPhoto.css', '1' );
	wp_enqueue_script( 'prettyphoto', $template_url .'/inc/prettyphoto/js/jquery.prettyPhoto.js', array('jquery'), '1.10.2', 1);
	wp_enqueue_script( 'config-prettyphoto', $template_url .'/inc/prettyphoto/js/config.js', array('jquery','prettyphoto'), '', 1);
}
// WayPoints
function waypoints() {
$template_url = get_bloginfo( 'template_url' );
	wp_enqueue_script( 'waypoints', $template_url .'/js/waypoints/jquery.waypoints.min.js', array('jquery'), '', 1);
}

// Bootstrap
function bootstrap() {
$template_url = get_bloginfo( 'template_url' );
	wp_enqueue_script( 'bootstrap', $template_url .'/js/bootstrap.js', array('jquery'), '', 1);
}


// Scripts del tema
function themejs() {
$template_url = get_bloginfo( 'template_url' );
	wp_enqueue_script( 'themejs', $template_url .'/js/theme.js', array('jquery'), '', 1);
}


