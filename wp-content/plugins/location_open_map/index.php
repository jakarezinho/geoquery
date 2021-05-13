<?php
/*
Plugin Name: Maps Location  Open Street Map
Plugin URI: 
Description: Mostra sistema de maps com open street map
Version: 1.0
Author: Jorge Melo
Author URI: 
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

////classe geo query
require_once(dirname(__FILE__) . '/includes/geo_class.php');
if (class_exists('GJSGeoQuery')) {

    GJSGeoQuery::Instance();
}

if (!function_exists('the_distance')) {
    function the_distance($post_obj = null, $round = false)
    {
        GJSGeoQuery::the_distance($post_obj, $round);
    }
}

if (!function_exists('get_the_distance')) {
    function get_the_distance($post_obj = null, $round = false)
    {
        return GJSGeoQuery::get_the_distance($post_obj, $round);
    }
}

///////////////////

function my_acf_init()
{

    // acf_update_setting('google_api_key', 'AIzaSyAp8ewZvzi0U9CFUYNqSSVQ_BKoXV4GOlU&libraries=places');
}
add_action('acf/init', 'my_acf_init');

function wpb_adding_scripts()
{

    wp_enqueue_style('mapa', 'https://unpkg.com/leaflet@1.6.0/dist/leaflet.css');
    wp_enqueue_style('leafleat', plugins_url('/css/style.css', __FILE__));

    if (is_single()) {
      wp_enqueue_script('map_leaflet', 'https://unpkg.com/leaflet@1.6.0/dist/leaflet.js');
        wp_enqueue_script('map', plugins_url('/js/map.js', __FILE__),null,null,true);
    }
}

add_action('wp_enqueue_scripts', 'wpb_adding_scripts');

////postype localisation
function local_init()
{
    register_post_type('location', array(
        'labels'                => array(
            'name'                  => __('locations', 'YOUR-TEXTDOMAIN'),
            'singular_name'         => __('location', 'YOUR-TEXTDOMAIN'),
            'all_items'             => __('All locations', 'YOUR-TEXTDOMAIN'),
            'archives'              => __('location Archives', 'YOUR-TEXTDOMAIN'),
            'attributes'            => __('location Attributes', 'YOUR-TEXTDOMAIN'),
            'insert_into_item'      => __('Insert into location', 'YOUR-TEXTDOMAIN'),
            'uploaded_to_this_item' => __('Uploaded to this location', 'YOUR-TEXTDOMAIN'),
            'featured_image'        => _x('Featured Image', 'location', 'YOUR-TEXTDOMAIN'),
            'set_featured_image'    => _x('Set featured image', 'location', 'YOUR-TEXTDOMAIN'),
            'remove_featured_image' => _x('Remove featured image', 'location', 'YOUR-TEXTDOMAIN'),
            'use_featured_image'    => _x('Use as featured image', 'location', 'YOUR-TEXTDOMAIN'),
            'filter_items_list'     => __('Filter locations list', 'YOUR-TEXTDOMAIN'),
            'items_list_navigation' => __('locations list navigation', 'YOUR-TEXTDOMAIN'),
            'items_list'            => __('locations list', 'YOUR-TEXTDOMAIN'),
            'new_item'              => __('New location', 'YOUR-TEXTDOMAIN'),
            'add_new'               => __('Add New', 'YOUR-TEXTDOMAIN'),
            'add_new_item'          => __('Add New location', 'YOUR-TEXTDOMAIN'),
            'edit_item'             => __('Edit location', 'YOUR-TEXTDOMAIN'),
            'view_item'             => __('View location', 'YOUR-TEXTDOMAIN'),
            'view_items'            => __('View locations', 'YOUR-TEXTDOMAIN'),
            'search_items'          => __('Search locations', 'YOUR-TEXTDOMAIN'),
            'not_found'             => __('No locations found', 'YOUR-TEXTDOMAIN'),
            'not_found_in_trash'    => __('No locations found in trash', 'YOUR-TEXTDOMAIN'),
            'parent_item_colon'     => __('Parent location:', 'YOUR-TEXTDOMAIN'),
            'menu_name'             => __('locations', 'YOUR-TEXTDOMAIN'),
        ),
        'public'                => true,
        'hierarchical'          => false,
        'show_ui'               => true,
        'show_in_nav_menus'     => true,
        'supports'              => array('title', 'editor', 'author', 'thumbnail'),
        'has_archive'           => true,
        'rewrite'               => true,
        'query_var'             => true,
        'menu_position'         => null,
        'menu_icon'             => 'dashicons-admin-post',
        'show_in_rest'          => true,
        'rest_base'             => 'location',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    ));
}
add_action('init', 'local_init');

///categorie location

function location_category_init()
{
    register_taxonomy('location_category', array('location'), array(
        'hierarchical'      => false,
        'public'            => true,
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'show_admin_column' => false,
        'query_var'         => true,
        'rewrite'           => true,
        'capabilities'      => array(
            'manage_terms'  => 'edit_posts',
            'edit_terms'    => 'edit_posts',
            'delete_terms'  => 'edit_posts',
            'assign_terms'  => 'edit_posts',
        ),
        'labels'            => array(
            'name'                       => __('location categories', 'YOUR-TEXTDOMAIN'),
            'singular_name'              => _x('location category', 'taxonomy general name', 'YOUR-TEXTDOMAIN'),
            'search_items'               => __('Search location categories', 'YOUR-TEXTDOMAIN'),
            'popular_items'              => __('Popular location categories', 'YOUR-TEXTDOMAIN'),
            'all_items'                  => __('All location categories', 'YOUR-TEXTDOMAIN'),
            'parent_item'                => __('Parent location category', 'YOUR-TEXTDOMAIN'),
            'parent_item_colon'          => __('Parent location category:', 'YOUR-TEXTDOMAIN'),
            'edit_item'                  => __('Edit location category', 'YOUR-TEXTDOMAIN'),
            'update_item'                => __('Update location category', 'YOUR-TEXTDOMAIN'),
            'view_item'                  => __('View location category', 'YOUR-TEXTDOMAIN'),
            'add_new_item'               => __('Add New location category', 'YOUR-TEXTDOMAIN'),
            'new_item_name'              => __('New location category', 'YOUR-TEXTDOMAIN'),
            'separate_items_with_commas' => __('Separate location categories with commas', 'YOUR-TEXTDOMAIN'),
            'add_or_remove_items'        => __('Add or remove location categories', 'YOUR-TEXTDOMAIN'),
            'choose_from_most_used'      => __('Choose from the most used location categories', 'YOUR-TEXTDOMAIN'),
            'not_found'                  => __('No location categories found.', 'YOUR-TEXTDOMAIN'),
            'no_terms'                   => __('No location categories', 'YOUR-TEXTDOMAIN'),
            'menu_name'                  => __('location categories', 'YOUR-TEXTDOMAIN'),
            'items_list_navigation'      => __('location categories list navigation', 'YOUR-TEXTDOMAIN'),
            'items_list'                 => __('location categories list', 'YOUR-TEXTDOMAIN'),
            'most_used'                  => _x('Most Used', 'location_category', 'YOUR-TEXTDOMAIN'),
            'back_to_items'              => __('&larr; Back to location categories', 'YOUR-TEXTDOMAIN'),
        ),
        'show_in_rest'      => true,
        'rest_base'         => 'location_category',
        'rest_controller_class' => 'WP_REST_Terms_Controller',
    ));
}
add_action('init', 'location_category_init');

//// function lat 
function proximo($lat, $lng, $radius)
{
    $query = new WP_Query(array(
        // ... include other query arguments as usual
        'post_type'  => 'post',
        'offset' => 1,
        'geo_query' => array(
            'lat_field' => 'my_lat',  // this is the name of the meta field storing latitude
            'lng_field' => 'my_lng', // this is the name of the meta field storing longitude 
            'latitude'  => $lat,    // this is the latitude of the point we are getting distance from
            'longitude' => $lng,   // this is the longitude of the point we are getting distance from
            'distance'  => $radius,           // this is the maximum distance to search
            'units'     => 'kilometers'       // this supports options: miles, mi, kilometers, km
        ),
        'orderby' => 'distance', // this tells WP Query to sort by distance
        'order'   => 'ASC'
    ));
    return $query;
}
///add shortcode mapa fronted 

function mapa_fronted()
{


    $location = get_field('mapa');
    $description = get_field('field_5dc45dd5ce23f');
?>
    <?php if ($location) : ?>
        <div class="acf-map" id="map">
            <div id="map" class="marker" data-lat="<?php echo get_post_meta(get_post()->ID, 'my_lat', true); ?>" data-lng="<?php echo get_post_meta(get_post()->ID, 'my_lng', true); ?>"></div>
        </div>
        <p>MORADA-><em><?php echo esc_html($location['address']); ?></em></p>
        description-><?php echo $description; ?>


        <?php
        $query_proximo = proximo(get_post_meta(get_post()->ID, 'my_lat', true), get_post_meta(get_post()->ID, 'my_lng', true), 5);
       var_dump(get_post_meta(get_post()->ID,'my_lat',true),get_post_meta(get_post()->ID,'my_lng',true));
       // var_dump($location['lat'], $location['lng']);
        var_dump($location['markers'][0]['lat'],$location['markers'][0]['lng']);

        $string = '<h3> POR PERTO</h3>';
        $string .= '<div class="postsbycategory">';
        if ($query_proximo->have_posts()) {
            while ($query_proximo->have_posts()) {
                $query_proximo->the_post();
                $dist = get_the_distance(null, true);

                if (has_post_thumbnail()) {
                    $string .= '<div class="item">';
                    $string .= '<a href="' . get_the_permalink() . '" rel="bookmark">' . get_the_post_thumbnail($query_proximo->post_id, array(150, 150)) . '<h4>' . get_the_title() . '</h4></a><span> (' . $dist . ')km</span></div>';
                } else {
                    // if no featured image is found
                    $string .= '<h4><a href="' . get_the_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h4>';
                }
            }
            /* Restore original Post Data */
            wp_reset_postdata();
        } else {
            $string .= '<p>Nada por perto</p>';
        }
        $string .= '</div>';

        return $string; ?>
<?php endif;
}
add_shortcode('mapa_locais', 'mapa_fronted');

function property_slideshow($content)
{
    if (is_single()) {
        $custom_content = '[mapa_locais]';
        $custom_content .= $content;
        return $custom_content;
    } else {
        return $content;
    }
}
add_filter('the_content', 'property_slideshow');

//////update lat lng 
add_action('acf/update_value', 'wpq_update_lng_and_lat', 99, 3);

function wpq_update_lng_and_lat($value, $post_id, $field)
{
    $lat = empty($value['address']) ? NULL : $value['markers'][0]['lat'];
    $lng = empty($value['address']) ? NULL : $value['markers'][0]['lng'];
    if ('mapa' === $field['name']) {
        update_post_meta($post_id, 'my_lat', $lat);
        update_post_meta($post_id, 'my_lng', $lng);
    }
    return $value;
}

/////////////////POST META  LOCALIZATION  IN REST API 

add_action('rest_api_init', 'create_api_posts_meta_field');

function create_api_posts_meta_field()
{

    // register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema() )
    register_rest_field(
        array('post', 'location'),
        'post_meta',
        array(
            'get_callback' => 'get_post_meta_for_api',
            'schema' => null,
        )
    );
}

function get_post_meta_for_api($object)
{
    //get the id of the post object arrayS
    $post_id = $object['id'];

    //return the post meta

    //return $mapa['0']['lat'];
    $mapa = get_post_meta($post_id, 'mapa', false);
    return $mapa['0'];
    //return get_post_meta( $post_id);
}
///////////////////// GET IMAGE POST REST API

add_action('rest_api_init', 'register_rest_images');

function register_rest_images()
{
    register_rest_field(
        array('post', 'location'),
        'post_img',
        array(
            'get_callback'    => 'get_rest_featured_image',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function get_rest_featured_image($object, $field_name, $request)
{
    if ($object['featured_media']) {
        $img = wp_get_attachment_image_src($object['featured_media'], 'thumbnail');
        return $img[0];
    }
    return false;
}

//////////////////// GEO QUERY REST API 
add_filter('rest_query_vars', function ($valid_vars) {
    return array_merge($valid_vars, ['geo_location']);
});
/////////////rest_{custom-post-type-slug}_query //// 'rest_post_query'
////https://example.com/wp-json/wp/v2/posts?geo_location={"lat":"64.128288","lng":"-21.827774","radius":"50"}
add_filter('rest_post_query', function ($args, $request) {
    $geo = json_decode($request->get_param('geo_location'));
    if (isset($geo->lat, $geo->lng)) {
        $args['geo_query'] = [
            'latitude'                =>  (float) $geo->lat,
            'longitude'                =>  (float) $geo->lng,
            'lat_field' => 'my_lat',  // this is the name of the meta field storing latitude
            'lng_field' => 'my_lng',
            'distance'             => ($geo->radius) ? (float) $geo->radius : 1,
            'units'     => 'kilometers',
        ];
    }
    return $args;
}, 10, 2);
