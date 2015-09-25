<section class="MeteoroContact u-contenedor-completo">
    <div class="MeteoroContact-mapa"> 
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3760.231565114685!2d-96.89147209999997!3d19.531669500000007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85db32270aade5ef%3A0x7a7a804a52710b4e!2sChopin%2C+Indeco+Animas%2C+91190+Xalapa+Enr%C3%ADquez%2C+Ver.!5e0!3m2!1ses-419!2smx!4v1443036826093" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>                                              
    </div>  
    
    <div class="MeteoroContact-contenido u-contenedor">
        <div class="MeteoroContact-formulario">
            <?php echo do_shortcode('[contact-form-7 id="73" title="Default CF"]'); ?>
        </div>  
        
        <div class="MeteoroContact-datos">
            <h2>meteoroContact</h2>
            <p><i class="fa fa-map-marker"></i><?php the_field('direccionContacto', 'option'); ?></p>
            <p><i class="fa fa-mobile"></i><?php the_field('movilContacto', 'option'); ?></p>
            <p><i class="fa fa-phone"></i><?php the_field('telefonoContacto', 'option'); ?></p>
            <p><i class="fa fa-envelope"></i><?php the_field('correoContacto', 'option'); ?></p>
        </div>
    </div>
</section>