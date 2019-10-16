<?php
/**
 * Plugin Name: KFP Formulario Manía
 * Author: KungFuPress
 * Version: 1.3.0
 * Description: Plugin con ejemplos de formularios de todo tipo y color
 * Author URI: https://kungfupress.com
 *
 * @wordpress-plugin
 * @package kfp-fman
 */

// Salir si se intenta acceder directamente.
defined( 'ABSPATH' ) || die();

define( 'KFP_FMAN_DIR', plugin_dir_path( __FILE__ ) );
define( 'KFP_FMAN_VERSION', '1.3.0' );

require_once KFP_FMAN_DIR . 'inc/crear-tablas.php';
require_once KFP_FMAN_DIR . 'inc/crear-datos-ejemplo.php';
require_once KFP_FMAN_DIR . 'inc/shortcode-select-simple.php';
require_once KFP_FMAN_DIR . 'inc/shortcode-select-enlazado.php';
require_once KFP_FMAN_DIR . 'inc/shortcode-select-triple.php';
require_once KFP_FMAN_DIR . 'inc/shortcode-select-user.php';
require_once KFP_FMAN_DIR . 'inc/graba-select-enlazado.php';
require_once KFP_FMAN_DIR . 'inc/graba-select-triple.php';

register_activation_hook( __FILE__, 'kfp_fman_crear_tablas' );
register_activation_hook( __FILE__, 'kfp_fman_crear_datos_ejemplo' );

// Define los shortcodes que muestran los distintos tipos de formularios.
add_shortcode( 'kfp_fman_select_simple', 'kfp_fman_select_simple' );
add_shortcode( 'kfp_fman_select_enlazado', 'kfp_fman_select_enlazado' );
add_shortcode( 'kfp_fman_select_triple', 'kfp_fman_select_triple' );
add_shortcode( 'kfp_fman_select_user', 'kfp_fman_select_user' );
