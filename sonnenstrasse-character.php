<?php
/*
Plugin Name: Sonnenstrasse Character
Plugin URI: https://wordpress.org/plugins/sonnenstrasse-character/
Description: This plugin allows you to display a character manager for rpgs in your posts using the shortcode [rp-hero][/rp-hero].
Version: 1.00
Author: Klemens
Author URI: https://profiles.wordpress.org/Klemens#content-plugins
Text Domain: sonnenstrasse-character
*/ 

include_once(ABSPATH . '/wp-content/plugins/sonnenstrasse-base/inc/template.class.php');
require_once('inc/rp-character-install.php'); 
require_once('inc/rp-character-functions.php'); 
require_once('inc/rp-character-class.php'); 

$rp_hero_index = 0;

register_deactivation_hook(__FILE__, 'rp_character_uninstall');
register_activation_hook(__FILE__, 'rp_character_install');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 'rp-character' Hero Shortcode
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

add_shortcode ('rp-hero', 'rp_hero_shortcode');

function rp_hero_shortcode($atts, $content) {

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    global $rp_hero_index;
    $rp_hero_index++;

	extract(shortcode_atts(array(
		'title' => __('RP Hero', 'rp-hero'),
		'name' => '',
        'style' => 'default'
	), $atts));

	return rp_character_hero_html($name);
}



?>