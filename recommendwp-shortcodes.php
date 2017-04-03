<?php
/*
Plugin Name: RecommendWP Shortcodes
Description: A collection of shortcodes for WordPress built using the Shortcodes Ultimate plugin API.
Version: 1.0.0
Author: RecommendWP
Author URI: http://www.recommendwp.com
Bitbucket Plugin URI: https://bitbucket.org/webdevsuperfast/recommendwp-shortcodes
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.txt
*/

class RecommendWP_Shortcodes {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'rwps_enqueue_scripts' ) );
        
        add_filter( 'su/data/groups', array( $this, 'rwps_register_groups' ) );

        foreach ( glob( plugin_dir_path( __FILE__ ) . "shortcodes/*.php" ) as $file ) {
            include_once $file;
        }

        //* Mr Image Resize
        if ( !function_exists( 'mr_image_resize' ) ) {
            require_once( plugin_dir_path( __FILE__ ) . 'lib/mr-image-resize.php' );
        }

        if ( function_exists( 'mr_image_resize' ) )
            require_once( plugin_dir_path( __FILE__ ) . 'lib/misc.php' );

        //* Color Luminance
        if ( !function_exists( 'color_luminance' ) ) {
            require_once( plugin_dir_path( __FILE__ ) . 'lib/luminance.php' );
        }

    }

    public function rwps_register_groups( $groups ) {
        $groups['recommendwp'] = __( 'RecommendWP', 'rwps' );

        return $groups;
    }

    public function rwps_enqueue_scripts() {
        if ( ! is_admin() ) {
            // Shortcode CSS
            wp_register_style( 'rwp-shortcodes', plugin_dir_url( __FILE__ ) . 'css/shortcode.css' );
            wp_enqueue_style( 'rwp-shortcodes' );

            // Vendor JS
            wp_register_script( 'rwps-vendor-js', plugin_dir_url( __FILE__ ) . 'js/vendor.min.js', array( 'jquery' ), null, true );
            wp_enqueue_script( 'rwps-vendor-js' );

            // Shortcode JS
            wp_register_script( 'rwps-shortcodes', plugin_dir_url( __FILE__ ) . 'js/shortcode.js', array( 'jquery' ), null, true );
        }
    }
}

new RecommendWP_Shortcodes();

function rwps_light_or_dark( $color, $dark = '#000000', $light = '#ffffff' ) {

    $hex = str_replace( '#', '', $color );

    $c_r = hexdec( substr( $hex, 0, 2 ) );
    $c_g = hexdec( substr( $hex, 2, 2 ) );
    $c_b = hexdec( substr( $hex, 4, 2 ) );

    $brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

    return $brightness > 155 ? $dark : $light;
}
