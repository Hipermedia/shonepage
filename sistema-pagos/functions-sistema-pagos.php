<?php

function paypalButtonSH() {
  get_template_part( 'sistema-pagos/button');
}


// Agrego custom post type para botones de pago
add_action( 'init', 'cpt_botones_pago' );
function cpt_botones_pago() {
  register_post_type( 'botones-pago-cpt',
    array(
      'labels' => array(
        'name' => __( 'Botones de pago' ),
        'singular_name' => __( 'Botones de pago' )
      ),
      'public' => true,
      'has_archive' => true,
      'menu_icon'   => 'dashicons-tickets-alt',
    )
  );
}


