<?php
/**
 * Se utiliza para mostrar el formulario de suscripción a sendy
 *
 * @package WordPress
 * @subpackage SH_Base
 * @since SH Base 1.0
 */
?>

<form class="suscripcion-boletin" action="<?php inicio_url(); ?>/gracias-por-suscribirte/" method="POST" accept-charset="utf-8">
    <!-- ¿Sabias que no puedes mandar la variable name por POST en WP? -->
    <p>Tu Nombre<br/>
    <input type="text" name="nombre" id="nombre" value=""/>
    </p>
    <p>Tu Correo<br/>
    <input type="email" name="email" id="email" value=""/>
    </p>
    <input type="hidden" name="list" value="pQsw4XXnRyQodpFe6nAjGA"/>
    <input type="hidden" name="Dominio" value="<?php inicio_url(); ?>"/>
    <input type="hidden" name="Fechadeingreso" id="Fechadeingreso" value="<?php echo date("Y-m-d"); ?>" />
    <input type="submit" name="submit" id="submit" value="Suscribirse"/>
</form>