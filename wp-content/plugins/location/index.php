<?php
/*
Plugin Name: Maps Location 
Plugin URI: 
Description: Mostra sistema de maps 
Version: 1.0
Author: Jorge Melo
Author URI: 
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

function my_acf_init()
{
    acf_update_setting('google_api_key', 'AIzaSyAp8ewZvzi0U9CFUYNqSSVQ_BKoXV4GOlU&libraries=places');
}
add_action('acf/init', 'my_acf_init');

function wpb_adding_scripts()
{

    wp_enqueue_style('mapa', plugins_url('/css/style.css', __FILE__));

    if (is_single() && 'location' == get_post_type()) {
        wp_enqueue_script('map_api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAp8ewZvzi0U9CFUYNqSSVQ_BKoXV4GOlU&libraries=places');
        wp_enqueue_script('map', plugins_url('/js/map.js', __FILE__), array('jquery'));
    }
}

add_action('wp_enqueue_scripts', 'wpb_adding_scripts');



///add shortcode mapa fronted 

function mapa_fronted()
{


    $location = get_field('field_5dc434051b563');
    $description = get_field('field_5dc45dd5ce23f');
    ?>
    <?php if ($location) : ?>
        <div class="acf-map" data-zoom="16">
            <div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>"></div>
        </div>
        <p>MORADA-><em><?php echo esc_html($location['address']); ?></em></p>
        description-><?php echo $description; ?>

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

function my_acf_save_post($post_id)
{

    $location = get_field('field_5dc434051b563', $post_id);

    if ($location) {

        update_field('field_5ddd0cb9d2722', $location['lat'], $post_id);
        update_field('field_5ddd0cd4d2723', $location['lng'], $post_id);
    }
}

add_action('acf/save_post', 'my_acf_save_post', 15);
