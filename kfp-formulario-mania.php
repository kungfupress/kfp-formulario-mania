<?php
/**
 * KFP Formulario Manía
 * 
 * @wordpress-plugin
 * Plugin Name: KFP Formulario Manía
 * Author: KungFuPress
 * Version: 1.0
 * Description: Plugin con ejemplos de formularios de todo tipo y color
 * Author URI: https://kungfupress.com
 */

//  Salir si se intenta acceder directamente
if (! defined('ABSPATH')) {
    exit();
}

$ruta_plugin = plugin_dir_path(__FILE__);

require_once $ruta_plugin . 'crear_tablas.php';
require_once $ruta_plugin . 'crear_datos_ejemplo.php';
require_once $ruta_plugin . 'shortcode_select_simple.php';
require_once $ruta_plugin . 'shortcode_select_enlazado.php';
require_once $ruta_plugin . 'shortcode_select_triple.php';
require_once $ruta_plugin . 'shortcode_select_user.php';

register_activation_hook(__FILE__, 'Kfp_Form_Mania_Crear_tablas');
register_activation_hook(__FILE__, 'Kfp_Form_Mania_Crear_Datos_ejemplo');

// Define los shortcodes que muestran los distintos tipos de formularios
add_shortcode('kfp_form_mania_select_simple', 'Kfp_Form_Mania_Select_simple');
add_shortcode('kfp_form_mania_select_enlazado', 'Kfp_Form_Mania_Select_enlazado');
add_shortcode('kfp_form_mania_select_triple', 'Kfp_Form_Mania_Select_triple');
add_shortcode('kfp_form_mania_select_user', 'Kfp_Form_Mania_Select_user');
