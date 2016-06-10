<?php
/*
Plugin Name: RecommendWP Shortcodes
Description: A collection of shortcodes for WordPress built using the Shortcodes Ultimate plugin API.
Version: 1.0.0
Author: RecommendWP
Author URI: http://www.recommendwp.com
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.txt
*/

// Check if Divi is installed
register_activation_hook( __FILE__, 'rwps_up_activation_check' );
function rwps_up_activation_check() {
	$theme_info = get_theme_data( TEMPLATEPATH . '/style.css' );

	// need to find a way to check active themes is MultiSites	- This does not work in new 3.1 network panel.
	if( basename( TEMPLATEPATH ) != 'Divi' ) {
		deactivate_plugins( plugin_basename( __FILE__ ) ); // Deactivate ourself
		wp_die( 'Sorry, you can\'t activate unless you have installed Divi' );
	}
}

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
            require_once( plugin_dir_path( __FILE__ ) . 'lib/misc.php' );
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

            // VeinJS
            wp_register_script( 'veinjs', '//cdnjs.cloudflare.com/ajax/libs/veinjs/0.3/vein.min.js', array(), '0.3', true );

            wp_enqueue_script( 'veinjs' );

            // Shortcode JS
            wp_register_script( 'rwps-shorcodes', plugin_dir_url( __FILE__ ) . 'js/shortcode.js', array( 'jquery' ), null, true );
        }
    }
}

new RecommendWP_Shortcodes();
