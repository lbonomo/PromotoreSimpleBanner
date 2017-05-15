<?php
/**
 * @package Promotore Simple Banner 
 */
/*
Plugin Name: Promotore Simple Banner
Plugin URI: https://promotore.com.ar/wordpress-plugins/
Description: Nos permite subier una imagen y ubicarla como widget
Version: 0.0.1
Author: Lucas Bonomo
Author URI: https://lucasbonomo.com/
License: GPLv2 or later
Text Domain: Promotore Simple Banner 
*/

// Agrego el estilo del Plug-in
function ptr_add_styles() {
    wp_enqueue_style( 
            'ptr_banner', // Name of the stylesheet. Should be unique.
            plugin_dir_url( __FILE__ ).'assets/css/banner.css');
}
add_action( 'wp_enqueue_scripts', 'ptr_add_styles' ); 

// Menu "Ajustes -> Simple Banner" y pagina de configuracion.
include_once(plugin_dir_path( __FILE__ ).'options.php');

// Configuracion y visualizacion del Widget
include_once(plugin_dir_path( __FILE__ ).'widgets.php');

// Nueva Widget Area - Antes del loop principal de Wordpress
function ptr_new_wa() {
    $options = array(
        'id' => 'ptr-wa-before-loop',
        'name' => 'Promotore WA before loop',
        'description' => 'Widget Area antes del loop (genesis_before_loop)',
        'class'         => 'ptr-wa-before-loop',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>'
    );
    // https://codex.wordpress.org/Function_Reference/register_sidebar
    register_sidebar($options);
}
add_action('widgets_init','ptr_new_wa');

// Muestro la Widget Area
function ptr_show_wa() {
    // https://codex.wordpress.org/Function_Reference/dynamic_sidebar
    dynamic_sidebar('ptr-wa-before-loop'); // id del WA
}
add_action('genesis_before_loop','ptr_show_wa'); // Requiere Genesis

// Banner Short Code
function ptr_sc_banner(){
    $img ='<img '
        .'src='.wp_get_attachment_url(get_option("ptr_banner_id")).' '
        .'class="ptr_simple_banner_image">';
    return $img;
}
add_shortcode('simple-banner', 'ptr_sc_banner');