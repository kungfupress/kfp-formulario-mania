<?php
/**
 * Plugin Name: KFP Formulario Manía
 * Author: KungFuPress
 * Version: 1.0
 * Description: Plugin con ejemplos de formularios de todo tipo y color
 * Author URI: https://kungfupress.com
 *
 * @wordpress-plugin
 * @package kfp-fman
 */

// Salir si se intenta acceder directamente.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

$ruta_plugin = plugin_dir_path( __FILE__ );

require_once $ruta_plugin . 'inc/crear-tablas.php';
require_once $ruta_plugin . 'inc/crear-datos-ejemplo.php';
require_once $ruta_plugin . 'inc/shortcode-select-simple.php';
require_once $ruta_plugin . 'inc/shortcode-select-enlazado.php';
require_once $ruta_plugin . 'inc/shortcode-select-triple.php';
require_once $ruta_plugin . 'inc/shortcode-select-user.php';
require_once $ruta_plugin . 'inc/graba-select-triple.php';

register_activation_hook( __FILE__, 'kfp_form_mania_crear_tablas' );
register_activation_hook( __FILE__, 'kfp_form_mania_crear_datos_ejemplo' );

// Define los shortcodes que muestran los distintos tipos de formularios.
add_shortcode( 'kfp_form_mania_select_simple', 'kfp_form_mania_select_simple' );
add_shortcode( 'kfp_form_mania_select_enlazado', 'kfp_form_mania_select_enlazado' );
add_shortcode( 'kfp_form_mania_select_triple', 'kfp_fman_select_triple' );
add_shortcode( 'kfp_form_mania_select_user', 'kfp_form_mania_select_user' );
