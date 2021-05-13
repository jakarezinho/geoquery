<script>
var $ = jQuery.noConflict();
function initialize() {		 
//var pos = new google.maps.LatLng(38.7252993, -9.150036399999976);
var bounds = new google.maps.LatLngBounds();
var myOptions = {
    zoom: 10,
    //center: pos,
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

};


var map = new google.maps.Map(document.getElementById('map'), myOptions);
///
mapcenter = map.getCenter();
map.setCenter(mapcenter);
////
 var infowindow = new google.maps.InfoWindow({
      maxWidth: 300,
	  pixelOffset:  new google.maps.Size(0,-80)
    });

    var marker, i;

 var markers = [];
for (var i = 0; i < locations.length; i++) {
	var latLng = new google.maps.LatLng(locations[i][1],locations[i][2]);
	 //var image = locations[i][3];
	var marker = new RichMarker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
          map: map,
          content: locations[i][3]});
	bounds.extend(latLng);
    markers.push(marker);
	
	
	 google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]); infowindow.open(map, marker);}})(marker, i));
}//fim for
 
//var markerCluster = new MarkerClusterer(map, markers);
 //
map.fitBounds(bounds);


zomm =  document.getElementById('volta');

google.maps.event.addDomListener(zomm, 'click', function() {
    map.setZoom(10);
  });
///comando mapa//
$('#mapa_command').addClass("haut");
var mapWindowHeight = jQuery(window).height();
var mapTabState = "open";
$('#mapa_command').click(function(event){
		event.preventDefault();
		if (mapTabState !="full") {
			mapcenter = map.getCenter();
			$('#mapa_command').removeClass('haut').addClass('bas');
			$('#map').animate({height: mapWindowHeight}, mapWindowHeight, function() {
				google.maps.event.trigger(map, 'resize');
				map.setCenter(mapcenter);
				var zoom1 = map.getZoom();
				map.setZoom(zoom1+1)
				map.fitBounds(bounds);
				mapTabState = "full";
			});
			
		} else {
		
			//$('#map-tab-icon').removeClass('icon-down-open').addClass('icon-cancel');
			mapcenter = map.getCenter();
			$('#mapa_command').removeClass('bas').addClass('haut');
			$('#map').animate({height: 300}, 600, function() {
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

	}///fin inicialize

google.maps.event.addDomListener(window, 'load', initialize);
</script>

<?php 
if (is_tag()) {
$the_query = new WP_Query( array(
  'post_type' => 'post',
  'tag'=> $tag,
  'paged' => get_query_var('paged'),
  //'category__not_in' => array( 14,),
  'posts_per_page' => 8,
  //'orderby'       => 'rand',
   'order'         => 'DESC'
));}

if (is_category()) {
$the_query = new WP_Query( array(
  'post_type' => 'post',
  'cat' => $cat,
  'paged' => get_query_var('paged'),
  //'category__not_in' => array( 14,),
  'posts_per_page' =>8,
  //'orderby'       => 'rand',
   'order'         => 'DESC'
));}


if (is_author()) {
$the_query = new WP_Query( array(
  'post_type' => 'post',
 'author' =>  $autd,
  'paged' => get_query_var('paged'),
  //'category__not_in' => array( 14,),
  'posts_per_page' =>8,
  //'orderby'       => 'rand',
   'order'         => 'DESC'
));}

if (is_tax()) {
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' )  ); 
$the_query = new WP_Query( array(
  'post_type' => 'post',
 'tax_query' => array(
		array(
			'taxonomy' => $term->taxonomy, 'field'=> 'slug','terms'=>$term->name ,),
		),
  'paged' => get_query_var('paged'),
  //'category__not_in' => array( 14,),
  'posts_per_page' =>8,
  //'orderby'       => 'rand',
   'order'         => 'DESC'
));}



?>
<?php if ($the_query-> have_posts() ) : ?>
  <?php $current_post = $post->ID; ?>

  <script>
     // Define your locations: HTML content for the info window, latitude, longitude
     var locations = [
     <?php  while ($the_query-> have_posts() ) : $the_query->the_post();?>

      <?php  $link = get_permalink( $post->ID );
  //$desc = excerpt (20);
      $thumbnail= get_the_post_thumbnail( $post->ID, 'thumbnail' );
      $mini = get_the_post_thumbnail( $post->ID, 'mini');
//avatar
      $author_id = $post->post_author;  $fb = get_user_meta($author_id, '_fbid', true); $author = get_the_author();
      if ($fb){ $av= '<img src="https://graph.facebook.com/'.$fb.'/picture"/>';}else{ $av = get_avatar($author_id,50);}
      $avatar =  teste_image($av);

      $name= get_the_title($post->ID);

      $lat= get_post_meta($post->ID, 'custom_lat', true);
      $lng= get_post_meta($post->ID, 'custom_lng', true);
      $local= get_post_meta($post->ID, 'custom_local', true);
      $post_like_count = get_post_meta( $post->ID, "social", true ); $post_like_count ? $likes = $post_like_count : $likes = 0; 
       $count_posts = $the_query->current_post + 1; //counts posts in loop
      ?>
    
      ['<?php echo '<div class="div_map"><p><a href="'.$link.'"><strong>'.$name.'</strong></a><br>By - '.$author.' <br><img class="avat" src="'.$avatar.'"></p> <p>Shares : <span> '.$likes.'</span></p></div>';?>', <?= $lat;?>, <?=$lng;?>,'<div class="markeri"> <?=$mini;?> </div>'],

    <?php endwhile;?>
    ]; 
  <?php endif;?>
  <?php wp_reset_postdata(); ?>
</script>
<button id="volta" class="reset hidden-xs"> Reset Zoom</button>
<div id="map" class="mapa hidden-xs">Loading ... </div>
<div class="sombra"> </div> 
<div id="map-controls"><div id="mapa_command"></div></div>
 
          