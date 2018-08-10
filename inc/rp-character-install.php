<?php
    
require_once('rp-character-database.php'); 
require_once('rp-character-admin.php'); 

////////////////////////////////////////////////////////////////////////////////////////////////////////////

// function to create the DB / Options / Defaults					
function rp_character_install() {
	
	if( !class_exists( 'Sonnenstrasse\Template' ) ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die( __( 'Please install and activate Sonnenstrasse Base Shortcodes .', 'sonnenstrasse-character' ), 'Plugin dependency check', array( 'back_link' => true ) );
    }
	
	//sets up activation hook
	register_activation_hook(__FILE__, 'rp_character_install');
	
    rp_character_create_tables();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////

function rp_character_uninstall() {
    rp_character_drop_tables();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////

add_action('init', 'rp_character_css_and_js');

function rp_character_css_and_js() {
    wp_register_style('rp_character_css', plugins_url('css/rp-character.css', __FILE__));
    wp_enqueue_style('rp_character_css');
    wp_register_script('rp_character_js', plugins_url('js/rp-character.js', __FILE__));
    wp_enqueue_script('rp_character_js');
    wp_register_script('rp_character_reload_js', plugins_url('js/rp-character-reload.js', __FILE__));
    wp_enqueue_script('rp_character_reload_js');
    wp_enqueue_style('dashicons');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////

add_action('admin_init', 'rp_character_register_options' );

function rp_character_register_options() {
	register_setting( 'rp_character', 'rp_character' );
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////

add_filter('plugin_action_links', 'rp_character_plugin_actions', 10, 2);

function rp_character_plugin_actions($links, $file) {
 	if ($file == 'rp-character/rp-character.php' && function_exists("admin_url")) {
		$settings_link = '<a href="' . admin_url('options-general.php?page=rp-character') . '">' . __('Settings', 'rp-character') . '</a>';
		array_unshift($links, $settings_link); 
	}
	return $links;
}

add_action('admin_menu', 'rp_character_add_pages');

function rp_character_add_pages() {
    // Add a new submenu under Options:
	$css = add_options_page('Sonnenstrasse Characters', 'Sonnenstrasse Characters', 'manage_options', 'rp-character', 'rp_character_options');
	add_action("admin_head-$css", 'rp_character_css');
}

function rp_character_css() {
    wp_register_style('rp_character_admin_css', plugins_url('css/rp-character-admin.css', __FILE__));
    wp_enqueue_style('rp_character_admin_css');
    wp_register_script('rp_character_admin_js', plugins_url('js/rp-character-admin.js', __FILE__));
    wp_enqueue_script('rp_character_admin_js');
    wp_register_script('rp_character_reload_js', plugins_url('js/rp-character-reload.js', __FILE__));
    wp_enqueue_script('rp_character_reload_js');
}

function rp_character_options() { 
    // displays the options page content
    rp_character_admin_options();
}

?>