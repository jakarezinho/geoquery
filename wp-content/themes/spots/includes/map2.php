<?php 
			////;
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
?>
 <style type="text/css">
#map{
	width:70%;
	height:100%;
	float: left;
}
#map div h3{
	font-weight: bold;
	margin: 0px;
	padding: 0px;
}
#sidebar2{
	font-family: Arial, Helvetica, sans-serif;
	float: right;
	width: 30%;
	overflow-y:scroll;
	height:100%;
}
.sb_blue button {
	cursor:pointer;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	text-align: left;
	background-image: none;
	font-size: 15px;
	background-color: #F8F8F8;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	margin-top: 5px;
	margin-bottom: 5px;
	font-family: Arial, Helvetica, sans-serif;
	padding: 10px;
}
.sidebar_item  h3{
	font-weight: bold;
	margin: 0px;
	padding-top: 5px;
}
.sb_blue .ou {
	font-size: 11px;
	font-style: italic;
}
.sb_blue :focus {
	background-color: #FFC;
}
.sb_blue :hover {
	background-color: #EBEBEB;
}
.mini {
	float: left;
	margin-right: 10px;
}
.mini img {
	height: auto;
	width: 100%;	
}
.infow{
	width: 100px;
	height: auto;
}
.infow .autor{
	position: absolute;
	
}
.autor img {
	border-radius: 50%;
	height: 30px;
	width: 30px;	
	}

 </style>
  <?php if ($the_query-> have_posts() ) : ?>
  <?php $current_post = $post->ID;?>

   <div id="map"> loading...</div>
 
 <div id="sidebar2" class="sb_blue"></div>
<div  class="clearfix"> </div>
<script>

var mapOpts = {
  mapTypeId: google.maps.MapTypeId.ROADMAP,
  scaleControl: true,
  scrollwheel: false
}
var map = new google.maps.Map(document.getElementById("map"), mapOpts);
//  We set zoom and center later by fitBounds()

var infoWindow = new google.maps.InfoWindow({maxWidth: 300});
var markerBounds = new google.maps.LatLngBounds();
var markerArray = [];
 
function makeMarker(options){
  var pushPin = new google.maps.Marker({map:map,
  icon: "http://www.pequeno.eu/blog/images/marker_single.png",});
  pushPin.setOptions(options);
  google.maps.event.addListener(pushPin, "click", function(){
    infoWindow.setOptions(options);
    infoWindow.open(map, pushPin);
    if(this.sidebarButton)this.sidebarButton.button.focus();
  });
  var idleIcon = pushPin.getIcon();
  if(options.sidebarItem){
    pushPin.sidebarButton = new SidebarItem(pushPin, options);
    pushPin.sidebarButton.addIn("sidebar2");
  }
  markerBounds.extend(options.position);
  markerArray.push(pushPin);
  return pushPin;
}

google.maps.event.addListener(map, "click", function(){
  infoWindow.close();
});

function SidebarItem(marker, opts){
  var tag = opts.sidebarItemType || "button";
  var row = document.createElement(tag);
  row.innerHTML = opts.sidebarItem;
  row.className = opts.sidebarItemClassName || "sidebar_item";  
  row.style.display = "block";
  row.style.width = opts.sidebarItemWidth || "100%";
  row.onclick = function(){
    google.maps.event.trigger(marker, 'click');
  }
  row.onmouseover = function(){
    google.maps.event.trigger(marker, 'mouseover');
  }
  row.onmouseout = function(){
    google.maps.event.trigger(marker, 'mouseout');
  }
  this.button = row;
}
// adds a sidebar item to a <div>
SidebarItem.prototype.addIn = function(block){
  if(block && block.nodeType == 1)this.div = block;
  else
    this.div = document.getElementById(block)
    || document.getElementById("sidebar2")
    || document.getElementsByTagName("body")[0];
  this.div.appendChild(this.button);
}
// deletes a sidebar item
SidebarItem.prototype.remove = function(){
  if(!this.div) return false;
  this.div.removeChild(this.button);
  return true;
}
jQuery(document).ready(function($) {
map.fitBounds(markerBounds);
}); 
</script>

<script>
 <?php while ($the_query-> have_posts() ) : $the_query->the_post();?>

 <?php 
 $link = get_permalink( $post->ID );
  $desc = excerpt (20);
   $thumbnail= get_the_post_thumbnail( $post->ID, 'thumbnail' ); 
   $mini= get_the_post_thumbnail( $post->ID, 'mini' ); 
   $name= get_the_title($post->ID); 
   $lat= get_post_meta($post->ID, 'custom_lat', true);
   $lng= get_post_meta($post->ID, 'custom_lng', true);
   $local= get_post_meta($post->ID, 'custom_local', true);
    $rating = get_post_meta($post->ID, 'social', true); 
   //avatar
$author_id = $post->post_author;  $fb = get_user_meta($author_id, '_fbid', true); $author = get_the_author();
		   $av = get_avatar($author_id,30);
   $avatar = "<img src=".teste_image($av).">";
   ///
   ?>
makeMarker({
  position: new google.maps.LatLng(<?= $lat;?>, <?=$lng;?>),
  title: '<?php echo $name; ?>',
  sidebarItem: '<?php echo "<div class=\"mini\">" .$thumbnail. "</div><h3>" .$name."</h3> <span class=\"ou\">" .$local."</span><p class=\"autor \"> ".$avatar."</p>";?>',
  content: '<?php echo "<div class=\"infow\"><p>". $name. "</p> <p><a href=".$link.">".$mini."</a></p> Share ".$rating."</div>"; ?>'
});   
 <?php endwhile;?>
</script>
<div class="nav_cat">
  <?php
$big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $the_query->max_num_pages
) );
?>
</div>
<?php endif;?>
         <?php wp_reset_postdata(); ?>
