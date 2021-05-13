<?php
   if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
     add_image_size( 'mini',80, 80, true );
	// WordPress 4.1 and above.
  add_theme_support( 'title-tag' );
  
    ////MENUS///
	register_nav_menus( array(
	'menu_user' => __( 'Menu_user' ),
	'menu_bas' => __( 'Menu_bas' ),
	) );

    add_theme_support( 'menus' );
}///theme suport

	   // REMOVE MENUS O ADMIN // 
if (!current_user_can('manage_options')) {
    add_filter('show_admin_bar', '__return_false');
}
//////remove verdion wp /////////
remove_action( 'wp_head', 'wp_generator');

	/// POST TYPE SLIDE   ///////

function slide_init() {
	$labels = array(
    'name' => 'slide',
    'singular_name' => 'slide',
    'add_new' => 'Nova imagem',
    'add_new_item' => 'Adicionar nova imagem',
    'edit_item' => 'Edit imagem slide',
    'new_item' => 'Nova imagem',
    'all_items' => 'Todas as imagens',
    'view_item' => 'Ver imagens',
    'search_items' => 'Perquisar imagens',
    'not_found' =>  'Sem imagem',
    'not_found_in_trash' => 'No image found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => 'slide'
  );
	 $args = array(
	 'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
			'show_in_menu'=> true,
			'show_in_nav_menus'=> false,
			'exclude_from_search' => true,
            'rewrite' => array(
              'slug' => 'slide'),  // Novo aliás para o Rewrite
            'supports' => array(
                    'title',
                    'thumbnail',
					'editor',
					'excerpt'));

	register_post_type( 'slide', $args ); 
}
add_action( 'init', 'slide_init' );
////end slide///
// EXPERT //
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
///IMAGE DE FOND//
   
function teste_image($html) {

  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $html, $matches);
  $first_img = $matches [1] [0];
 
  return $first_img;
}
// IMAGE ARCHIVE//
function image_archive ($image) {
	if(has_post_thumbnail()) {
        $image_img_tag = get_the_post_thumbnail( $post->ID, $image);
        }elseif(!has_post_thumbnail()){
			global $post;
		$a = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', ) );
	             $b = array_shift( $a );
	             $image_img_tag = wp_get_attachment_image( $b->ID, $image );
		}else { $image_img_tag = "";}
       $image_archive= teste_image($image_img_tag);
	return  $image_archive;
	}
//PINTEREST//
function pinterest_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];
 
  if(empty($first_img)){ //Defines a default image
    $first_img = "/images/default.jpg";
  }
  return $first_img;
}

/////INFINISCROLL////
function register_ajaxLoop_script() {
    wp_register_script(
       'ajaxLoop',
        get_stylesheet_directory_uri() . '/js/ajaxLoop.js',
        array('jquery'),
        NULL
    );
    wp_enqueue_script('ajaxLoop');
}
add_action('wp_enqueue_scripts', 'register_ajaxLoop_script');

//// TAGS CATEGORY /////

function get_category_tags($cat){
	

$all_tags_arr = array();
query_posts('cat='.$cat);
if (have_posts()) : while (have_posts()) : the_post();
    $posttags = get_the_tags();
    if ($posttags) {
        foreach($posttags as $tag) {
            $all_tags_arr[] = $tag -> term_id;
        }
    }
endwhile; endif; 

$tags_arr = array_unique($all_tags_arr);

$tagcloud_args = array(
    'include'   =>  implode(',',$tags_arr),
	'smallest'  => 12, 
	'largest'  => 20,
	'separator' =>',  ',
);

wp_tag_cloud( $tagcloud_args ); 
wp_reset_query();
}

/////AUTOR TAG 
function get_tags_aut($autd){

	$all_tags_arr = array();
query_posts("showposts=-1&author=".$autd);
if (have_posts()) : while (have_posts()) : the_post();
    $posttags = get_the_tags();
    if ($posttags) {
        foreach($posttags as $tag) {
            $all_tags_arr[] = $tag -> term_id;
        }
    }
endwhile; endif; 

$tags_arr = array_unique($all_tags_arr);

$tagcloud_args = array(
    'include'   =>  implode(',',$tags_arr),
	'smallest'  => 12, 
	'largest'  => 20,
	'separator' =>',  ',
);

wp_tag_cloud( $tagcloud_args ); 
wp_reset_query();
	}


////ERROR///
function comment_validation_init() {
if(is_single() && comments_open() ) {
	wp_enqueue_script('validate','https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js');
    wp_enqueue_script('comments', get_bloginfo('template_url') . '/js/comments.js', array('jquery'));

}
}
add_action('wp_footer', 'comment_validation_init');

///////////COMMMENTS LISTE///////

function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
     <?php  $id = get_comment(get_comment_ID())->user_id;?>
    <?php  $fbc =  get_user_meta($id, '_fbid', true);
		if ($fbc){ echo "<img src='https://graph.facebook.com/$fbc/picture' /> "; }else {echo get_avatar($id,50);}
		?> 
         <?php  comment_author( $comment_ID ); ?> 
 
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>
 
      <div class="comment-meta commentmetadata">
          <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
              <?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?>
          </a>
          <?php edit_comment_link(__('(Edit)'),'  ','') ?>
      </div>
 
      <?php comment_text() ?>
 
      <div class="reply">
   <?php if ( !is_user_logged_in() ) : ?>
      <p> (Inicie a sess&atilde;o para responder sasasasasa)</p>
<?php else : ?>
  <?php comment_reply_link(array_merge( $args, array('depth' => $depth,'max_depth' => $args['max_depth']))) ?>
<?php endif ?>  

      </div>
     </div>
<?php
        }
/////////////  EXCLUDE PAGES ///////////
add_filter( 'pre_get_posts', 'exclude_pages_search_when_logged_in' );
function exclude_pages_search_when_logged_in($query) {
    if ( $query->is_search && is_user_logged_in() )
        $query->set( 'post__not_in', array(1501, 2240 ) ); 

    return $query;
}

/////////////SOCIAL SHARES ///
function social_shares() {
	try {
	$id = get_the_ID();
	$meta_count = get_post_meta($id, "social", false); 
    $url = get_permalink($id);
	///fb likes ///
	function shinra_fb_count( $url) {
		
$api = file_get_contents('https://graph.facebook.com/?id='.$url);

    $count = json_decode( $api,true );
  
$s  = $count ['share'] ['share_count'];
return $s;
}
	
	
$pinfo = json_decode(preg_replace('/^receiveCount\((.*)\)$/', "\\1",file_get_contents('https://api.pinterest.com/v1/urls/count.json?url=http://www.'.$url.+"/")));
$pinfo = json_decode(preg_replace('/^receiveCount\((.*)\)$/', "\\1",file_get_contents('https://api.pinterest.com/v1/urls/count.json?url='.$url)));

$facebook = shinra_fb_count($url);

$pinterest = isset($pinfo->count) ? $pinfo->count : NULL;

$a = array ("$pinterest","$facebook",);
	$total = array_sum($a);
	 update_post_meta($id, "social", $total);
 echo '<p class="social" id="conta"> | Facebook -<span> '.$facebook.'</span> | Pinterest - <span>'.$pinterest. '</spam>> | Total - <span>'.$total. '</spam></p>';
	} catch (Exception $e) {
  echo " sem dados: ";
}

}

//////////////// DATAS //////////////////
/// datas longa ///


function modar_mes_int ($mes, $final) {
	   $mes = date("M", strtotime($final));
	   
	   switch ($mes){
		   
	case $mes =='Jan':
    $message = "Janeiro";
    break;
	case $mes =='Feb':
    $message = "Fevereiro";
    break;
	case $mes =='Mar':
    $message = "Mar&ccedil;o";
    break;
	case $mes =='Apr':
    $message = "Abril";
    break;
	case $mes =='May':
    $message = "Maio";
    break;
	case $mes =='Jun':
    $message = "Junho";
    break;
	case $mes =='Jul':
    $message = "Julho";
    break;
	case $mes =='Aug':
    $message = "Agosto";
    break;
	case $mes =='Sep':
    $message = "Setembro";
    break;
	case $mes =='Oct':
    $message = "Outubro";
    break;
	case $mes =='Nov':
    $message = "Novembro";
    break;
	case $mes =='Dec':
    $message = "Dezembro";
    break;
	
	 

		   }
	   	return $message;
	   }
	  
	   ///data curta 
	   function modar_mes ($mes, $final) {
	   $mes = date("M", strtotime($final));
	   
	   switch ($mes){
		   
	case $mes =='Jan':
    $message = "Jan";
    break;
	case $mes =='Feb':
    $message = "Fev";
    break;
	case $mes =='Mar':
    $message = "Mar";
    break;
	case $mes =='Apr':
    $message = "Abr";
    break;
	case $mes =='May':
    $message = "Maio";
    break;
	case $mes =='Jun':
    $message = "Jun";
    break;
	case $mes =='Jul':
    $message = "Jul";
    break;
	case $mes =='Aug':
    $message = "Ago";
    break;
	case $mes =='Sep':
    $message = "Set";
    break;
	case $mes =='Oct':
    $message = "Out";
    break;
	case $mes =='Nov':
    $message = "Nov";
    break;
	case $mes =='Dec':
    $message = "Dez";
    break;
	
	 

		   }
	   	return $message;
	   }
	   ////////////////DATA EVENTO em PT ///////////
	   
	   function datas_pt($mes) {
	   
	   switch ($mes){
		   
	case $mes =='January':
    $message = "Janeiro";
    break;
	case $mes =='February':
    $message = "Fevereiro";
    break;
	case $mes =='March':
    $message = "Mar&ccedil;o";
    break;
	case $mes =='April':
    $message = "Abril";
    break;
	case $mes =='May':
    $message = "Maio";
    break;
	case $mes =='June':
    $message = "Junho";
    break;
	case $mes =='July':
    $message = "Julho";
    break;
	case $mes =='August':
    $message = "Agosto";
    break;
	case $mes =='September':
    $message = "Setembro";
    break;
	case $mes =='October':
    $message = "Outubro";
    break;
	case $mes =='November':
    $message = "Novembro";
    break;
	case $mes =='December':
    $message = "Dezembro";
    break;
	
	 

		   }
	   	return $message;
	   }
////////////FEED//////
add_action('init', 'customRSS');
function customRSS(){
        add_feed('agenda', 'customRSSFunc');
}
function customRSSFunc(){
	global $wp_rewrite;
$wp_rewrite->flush_rules();
        get_template_part('rss', 'agenda');
}

/////////////////POST META  IN REST API 

add_action( 'rest_api_init', 'create_api_posts_meta_field' );

function create_api_posts_meta_field() {

 // register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema() )
 register_rest_field( array('post','location'), 'post_meta', array(
 'get_callback' => 'get_post_meta_for_api',
 'schema' => null,
 )
 );
}

function get_post_meta_for_api( $object ) {
 //get the id of the post object arrayS
 $post_id = $object['id'];

 //return the post meta

 //return $mapa['0']['lat'];
//$mapa = get_post_meta( $post_id,'mapa',false );
//return $mapa['0'];
 return get_post_meta( $post_id);
}
///////////////////// GET IMAGE POST REST API

add_action('rest_api_init', 'register_rest_images' );

function register_rest_images(){
    register_rest_field( array('post','location'),
        'post_img',
        array(
            'get_callback'    => 'get_rest_featured_image',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function get_rest_featured_image( $object, $field_name, $request ) {
    if( $object['featured_media'] ){
        $img = wp_get_attachment_image_src( $object['featured_media'], 'thumbnail' );
        return $img[0];
    }
    return false;
}

//////////////////// GEO QUERY REST API 
add_filter( 'rest_query_vars', function ( $valid_vars ) {
	return array_merge( $valid_vars, [ 'geo_location' ] );
} );

add_filter( 'rest_post_query', function( $args, $request ) {
	$geo = json_decode( $request->get_param( 'geo_location' ) );
	if ( isset( $geo->lat, $geo->lng ) ) {
		$args['geo_query'] = [
			'lat'                =>  (float) $geo->lat,
			'lng'                =>  (float) $geo->lng,
			'lat_meta_key'       =>  'rest_lat',
			'lng_meta_key'       =>  'rest_lng',
			'radius'             =>  ($geo->radius) ? (float) $geo->radius : 50,
		];
	}
	return $args;
}, 10, 2 );

/*

$query = new WP_Query(array(
    // ... include other query arguments as usual
    'post_type'  => 'location', 
    'geo_query' => array(
        'lat_field' => 'rest_lat',  // this is the name of the meta field storing latitude
        'lng_field' => 'rest_lng', // this is the name of the meta field storing longitude 
        'latitude'  => 41.159818,    // this is the latitude of the point we are getting distance from
        'longitude' => -8.6110616999999,   // this is the longitude of the point we are getting distance from
        'distance'  => 20,           // this is the maximum distance to search
        'units'     => 'kilometers'       // this supports options: miles, mi, kilometers, km
    ),
    'orderby' => 'distance', // this tells WP Query to sort by distance
    'order'   => 'ASC'
));
*/
$args = [
    'post_type'           => 'post',    
    'posts_per_page'      => 10,
    'ignore_sticky_posts' => true,
    'orderby'             => [ 'title' => 'DESC' ],
    'geo_query'           => [
        'lat'                =>  41.159818,                                // Latitude point
        'lng'                =>  -8.6110616999999,                               // Longitude point
        'lat_meta_key'       =>  'rest_lat',                         // Meta-key for the latitude data
        'lng_meta_key'       =>  'rest_lng',                         // Meta-key for the longitude data 
        'radius'             =>  20,                               // Find locations within a given radius (km)
        'order'              =>  'DESC',                            // Order by distance
        'distance_unit'      =>  111.045,                           // Default distance unit (km per degree). Use 69.0 for statute miles per degree.
        'context'            => '\\Birgir\\Geo\\GeoQueryHaversine', // Default implementation, you can use your own here instead.
    ],
];

$query = new WP_Query( $args );


var_dump($query->post_count);


