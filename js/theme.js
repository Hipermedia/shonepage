jQuery(document).ready(function($) {


	// Reduce el header al hacer scrolldown; la animación se realiza con CSS
	$(window).on("scroll touchmove", function () {
		$('#header').toggleClass('Header--tiny', $(document).scrollTop() > 0);
		$('#header-logo img').toggleClass('tiny', $(document).scrollTop() > 0);
		$('#header-social').toggleClass('u-remove', $(document).scrollTop() > 0);
		$('#header #searchform').toggleClass('u-remove', $(document).scrollTop() > 0);
		$('#header-main-nav').toggleClass('tiny', $(document).scrollTop() > 0);	
	});
	
	// Versión responsive del menú; oculta la navegación y en su defecto aparece un botón para mostrar u ocultarl la navegación
	$('.toggle-nav').click(function(e) {
        $(this).toggleClass('activo');
        $('#header-main-nav ul').toggleClass('activo'); 
        e.preventDefault();
    });

	// Pone la clase .active a cualquier link que haya en el documento que corresponda con el url actual
	var url = window.location.href;
	$('a[href="'+url+'"]').addClass('active');


	//Agrega una animación al hacer scroll al llegar a un elemento gracias a waypoints

	$('.titulo').waypoint(function(direction) {
	  $('.titulo').addClass( 'fadeInUp animated' );
	},{
	  offset:'20%'
	});

});