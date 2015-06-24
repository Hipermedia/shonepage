    <!-- Galería en portada en filmstrip -->
	<?php pretty_photo_sh(); ?>
          
	<?php $galeria_medios = get_ot( 'galeria_medios_portada', array() ); ?>
    <?php if (  !empty ($galeria_medios) ) {   ?>
	    <script type="text/javascript" charset="utf-8">
               jQuery(document).ready(function($) {                  
                      <!-- ROTATORIO REGULAR -->
                      $(window).load(function() {
                          $('#galeria-medios').flexslider({
          
                              //FLEXSLIDER SETTINGS
                              animation: "slide",              //String: Select your animation type, "fade" or "slide"
                              direction: "horizontal",        //String: Select the sliding direction, "horizontal" or "vertical"
                              reverse: false,                 //{NEW} Boolean: Reverse the animation direction
                              animationLoop: false,             //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
                              smoothHeight: false,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode  
                              startAt: 0,                     //Integer: The slide that the slider should start on. Array notation (0 = first slide)
                              slideshow: false,                //Boolean: Animate slider automatically
                              slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
                              animationSpeed: 500,            //Integer: Set the speed of animations, in milliseconds
                              initDelay: 0,                   //{NEW} Integer: Set an initialization delay, in milliseconds
                              randomize: false,               //Boolean: Randomize slide order
                              
                              // Usability features
                              pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
                              pauseOnHover: true,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
                              useCSS: true,                   //{NEW} Boolean: Slider will use CSS3 transitions if available
                              touch: true,                    //{NEW} Boolean: Allow touch swipe navigation of the slider on touch-enabled devices
                              video: false,                   //{NEW} Boolean: If using video in the slider, will prevent CSS3 3D Transforms to avoid graphical glitches
                              
                              // Primary Controls
                              controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
                              directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
                              prevText: "Previous",           //String: Set the text for the "previous" directionNav item
                              nextText: "Next",               //String: Set the text for the "next" directionNav item
                              
                              // Secondary Navigation
                              keyboard: true,                 //Boolean: Allow slider navigating via keyboard left/right keys
                              multipleKeyboard: false,        //{NEW} Boolean: Allow keyboard navigation to affect multiple sliders. Default behavior cuts out keyboard navigation with more than one slider present.
                              mousewheel: false,              //{UPDATED} Boolean: Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider navigating via mousewheel
                              pausePlay: false,               //Boolean: Create pause/play dynamic element
                              pauseText: 'Pause',             //String: Set the text for the "pause" pausePlay item
                              playText: 'Play',               //String: Set the text for the "play" pausePlay item
						itemWidth: 210,
						itemMargin: 5
          
                          });
                      });
          
                  });
              </script>
              <div id="galeria-medios" class="flexslider group">
                  <ul class="slides gallery clearfix">
                      <?php foreach ( $galeria_medios as $galeria ) { ?>
                          <li>
                          <?php if ( $galeria['tipo_medio_galeria'] == 'video' ) { ?>
                              <a href="<?php echo $galeria['yt_video_url']; ?>" rel="prettyPhoto[mixed]" title="<?php echo $galeria['title']; ?>">
                          <?php } else if ( $galeria['tipo_medio_galeria'] == 'imagen' ){ ?>
                              <a href="<?php echo $galeria['imagen_galeria']; ?>" rel="prettyPhoto[mixed]" title="<?php echo $galeria['title']; ?>">
                          <?php }?>
                                  <img src="<?php echo $galeria['imagen_galeria']; ?>" alt="<?php echo $galeria['title']; ?>" />
                                  <p><?php echo $galeria['title']; ?></p>
                              </a>
                          </li>
                      <?php } ?>
                  </ul>
              </div>
          <?php } ?>