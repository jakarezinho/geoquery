<?php 
			 $local= get_post_meta($post->ID, 'custom_local', true); 
			 $lat= get_post_meta($post->ID, 'custom_lat', true); $lng= get_post_meta($post->ID, 'custom_lng', true);?>
             
             <?php if ($local):?>
            <!--mapa-->
          <script>
		  var $ = jQuery.noConflict();
function initialize() {
  var myLatlng = new google.maps.LatLng(<?=$lat?>,<?=$lng?>);
  var mapOptions = {
    zoom: 15,
    center: myLatlng,
	scrollwheel: false,
	mapTypeControlOptions: {
     mapTypeId:google.maps.MapTypeId.ROADMAP,
	position: google.maps.ControlPosition. BOTTOM_LEFT //BOTTOM_CENTER 
    },
	zoomControl: true,
    zoomControlOptions: {
      style: google.maps.ZoomControlStyle.SMALL,
	  position: google.maps.ControlPosition.LEFT_CENTER
    },
	panControl: false,
	
	streetViewControl: false,

  }
  var map = new google.maps.Map(document.getElementById('mapa'), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
	  icon: "http://www.pequeno.eu/blog/images/marker_single.png",
      title: 'Hello World!'
  });
  
  //comando mapa//
$('#mapa_command').addClass("haut");
var mapWindowHeight = jQuery(window).height();
var mapTabState = "open";
$('#mapa_command').click(function(event){
		event.preventDefault();
		if (mapTabState !="full") {
			mapcenter = map.getCenter();
			$('#mapa_command').removeClass('haut').addClass('bas');
			$('#mapa').animate({height: mapWindowHeight}, mapWindowHeight, function() {
				google.maps.event.trigger(map, 'resize');
				map.setCenter(mapcenter);
				var zoom1 = map.getZoom();
				map.setZoom(zoom1+1)
				mapTabState = "full";
			});
			
		} else {
		
			//$('#map-tab-icon').removeClass('icon-down-open').addClass('icon-cancel');
			mapcenter = map.getCenter();
			$('#mapa_command').removeClass('bas').addClass('haut');
			$('#mapa').animate({height: 300}, 600, function() {
				google.maps.event.trigger(map, 'resize');
				map.setCenter(mapcenter);
			     var zoom1 = map.getZoom();
				map.setZoom(zoom1-1)
				mapTabState = "open";
				});
		}
	});
//jQuery('#map').css({"height": mapWindowHeight});



/////

}

google.maps.event.addDomListener(window, 'load', initialize);
    </script>
     <div class="mobil_single"> <div id="mapa" class="mapa_single hidden-xs">Loading ... </div></div>
     <div class="sombra"> </div>
     <div id="map-controls"><div id="mapa_command"></div></div>
     <?php endif;?>