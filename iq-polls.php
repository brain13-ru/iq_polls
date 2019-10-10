<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              
 * @since             1.0.0
 * @package           Iq_Polls
 *
 * @wordpress-plugin
 * Plugin Name:       IQ Polls
 * Plugin URI:        
 * Description:       Plugin for creating tests and polls.
 * Version:           1.0.0
 * Author:            Chesebiev Igor
 * Author URI:        
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       iq_polls
 * Domain Path:       /lang
 */

if(!function_exists('add_action')){
    echo 'Not allowed!';
    exit();
}

//Setup

//Includes
register_activation_hook( __FILE__, 'iqp_activate_plugin' );
include('includes/activate.php');
include('includes/init.php');
include('includes/admin/init.php');
include('includes/template-chooser.php');
include('includes/widgets.php');



//Hooks
add_action('init','iqp_init' );
add_action('admin_init','iqp_admin_init');
add_action('admin_menu','iqp_create_menu');
add_filter('template_include', 'iqp_template_chooser',1);
add_action('end_session_action', 'end_session');
add_action('widgets_init','iqp_register_widgets');

add_action( 'plugins_loaded', function(){
	load_plugin_textdomain( 'iq_polls', false, dirname( plugin_basename(__FILE__) ) . '/lang' );
});

//Shortcodes


 ?> 
