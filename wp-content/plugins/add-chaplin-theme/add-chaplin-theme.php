<?php 
/**
* Plugin Name:  Add theme Chaplin
* Plugin URI: https://www.yourwebsiteurl.com/
* Description: adiciona funções ao thema CHAPLIN
* Version: 1.0
* Author:  Jorge Melo
* Author URI: https://www.pequeno.eu
**/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
function wpb_adding_scripts_locais() {

		wp_enqueue_style( 'style_1', plugins_url( '/css/styles_1.css' , __FILE__ ) );
		
//wp_enqueue_script('google_maps','https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places'); 
	//wp_enqueue_script('geocomplete',plugins_url( '/js/geocomplete.js' , __FILE__ ) , array('jquery'));
	

}

add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts_locais' );  

/////////////////////////////////////////////////////////////////////////
/*-------------------------------------------------------------------
RECENTES POSTS POR CATEGORIA
-------------------------------------------------------------------- */ 
function wpb_postsbycategory($atts, $content = null) {
	
	extract(shortcode_atts(array(
      "name" => 'sem-categoria',
      "nombre" => '3',
	  "height"=> '150',
	  "width"=> '150'
		
    
   ), $atts));
	
	$args = array( 
		'category_name' => $name,
		//'post_type'		=> 'locations',
		'posts_per_page' => $nombre);
  // the query

  $the_query = new WP_Query($args); 
   
  // The Loop
  if ( $the_query->have_posts() ) {
	  $string = NULL;
      $string .= '<div class="postsbycategory">';
      while ( $the_query->have_posts() ) {
          $the_query->the_post();
              if ( has_post_thumbnail() ) {
              $string .= '<div class="item">';
              $string .= '<a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_post_thumbnail($the_query->post->ID, array( $height,$width) ) . get_the_title() .'</a></div>';
              } else { 
              // if no featured image is found
              $string .= '<p><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() .'</a></p>';
              }
              }
	  /* Restore original Post Data */
     wp_reset_postdata(); 
	
      } else {
      // no posts found
  }
  $string .= '</div>';
   
  return $string;
   
 

  }
  // Add a shortcode
  add_shortcode('categoryposts', 'wpb_postsbycategory');
   
  // Enable shortcodes in text widgets
  add_filter('widget_text', 'do_shortcode' );

  ///////add_action( 'init', 'register_shortcodes' );
 
/*--------------------------------------------------------------------------------------
CLEAN HEADER
----------------------------------------------------------------------------------- */

add_action('after_setup_theme', 'cleanup');
 
function cleanup() {
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'index_rel_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_head', 'rel_canonical');
  remove_action('wp_head', 'rel_alternate');
  remove_action('wp_head', 'wp_oembed_add_discovery_links');
  remove_action('wp_head', 'wp_oembed_add_host_js');
  remove_action('wp_head', 'rest_output_link_wp_head');
   
  remove_action('rest_api_init', 'wp_oembed_register_route');
  remove_action('wp_print_styles', 'print_emoji_styles');
   
  remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
  remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
   
  add_filter('embed_oembed_discover', '__return_false');
  //add_filter('show_admin_bar', '__return_false');
}

/* ----------------------------------------------------------------
 * ADD HEADER CODE
 * ---------------------------------------------------------------*/
add_action('wp_head', 'My_code_header');
function My_code_header(){
?>

<?php
};

/* ----------------------------------------------------------------
 * ADD FOOTER CODE
 * ---------------------------------------------------------------*/
add_action('wp_footer', 'My_code_footer');
function My_code_footer(){
?>

<?php
};

/*----------------------------------------------------
 * FANCY BOX data-fancybox-trigger="gallery"
 * --------------------------------------------------*/
/**
 * Add data attributes for Fancybox
 */
// Gallery images
function ccd_fancybox_gallery_attribute( $content, $id ) {
	// Restore title attribute
	$title = get_the_title( $id );
	return str_replace('<a', '<a data-type="image" data-fancybox="gallery" title="' . esc_attr( $title ) . '" ', $content);
}
add_filter( 'wp_get_attachment_link', 'ccd_fancybox_gallery_attribute', 10, 4 );
// Single images
function ccd_fancybox_image_attribute( $content ) {
       global $post;
       $pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
       $replace = '<a$1href=$2$3.$4$5 data-type="image" data-fancybox="image">';
       $content = preg_replace( $pattern, $replace, $content );
       return $content;
}
add_filter( 'the_content', 'ccd_fancybox_image_attribute' );


// ADD FANCYBOX SCRIPT
add_action ('wp_enqueue_scripts', 'add_fancybox_script');
function add_fancybox_script() {
    if ( is_single() ) {
        $add_script = 'jQuery(document).ready(function($){ 
            $("[data-fancybox]").fancybox({
                buttons: [
                "zoom",
                "fullScreen",
                "share",
                "thumbs",
                "close"
                ],
                protect: true
            });
        });'; 
        wp_enqueue_script ('fancybox-script', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js', array(), '3.3.5', true);     
        wp_add_inline_script ('fancybox-script', $add_script, 'after');
    }
}
// ENQUEUE CSS TO FOOTER
function fancy_footer_styles() {
    if ( is_single() ) {
        wp_enqueue_style( 'fancybox-style','https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css' );
    }   
};
add_action( 'get_footer', 'fancy_footer_styles' );




