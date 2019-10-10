<?php
/** Archivo: crear_datos_ejemplo.php */

/**
 * Inserta datos de ejemplo en las tablas de la base de datos si están vacías
 *
 * @return void
 */
function Kfp_Form_Mania_Crear_Datos_ejemplo()
{
    global $wpdb;
    $tabla_dispositivo = $wpdb->prefix . 'dispositivo';
    $tabla_dispositivo_tipo = $wpdb->prefix . 'dispositivo_tipo';
    $tabla_dispositivo_marca = $wpdb->prefix . 'dispositivo_marca';
    $tabla_dispositivo_modelo = $wpdb->prefix . 'dispositivo_modelo';
    $tabla_dispositivo_variante = $wpdb->prefix . 'dispositivo_variante';

    if ($wpdb->get_var("SELECT COUNT(*) FROM $tabla_dispositivo_marca") == 0 ) {
        $wpdb->insert( 
            $tabla_dispositivo_marca,  
            array('id' => 1, 'nombre' => 'Apple')
        );
        $wpdb->insert( 
            $tabla_dispositivo_marca, 
            array('id' => 2, 'nombre' => 'Samsung')
        );
        $wpdb->insert( 
            $tabla_dispositivo_marca, 
            array('id' => 3, 'nombre' => 'Huawei')
        );
    }
    if ($wpdb->get_var("SELECT COUNT(*) FROM $tabla_dispositivo_modelo") == 0 ) {
        $wpdb->insert( 
            $tabla_dispositivo_modelo, 
            array('id' => 1, 'id_marca' => 1, 'nombre' => 'iPhone X') 
        );
        $wpdb->insert( 
            $tabla_dispositivo_modelo, 
            array('id' => 2,'id_marca' => 1,'nombre' => 'iPhone 8') 
        );
        $wpdb->insert( 
            $tabla_dispositivo_modelo, 
            array('id' => 3,'id_marca' => 2,'nombre' => 'Galaxy 8') 
        );
        $wpdb->insert( 
            $tabla_dispositivo_modelo, 
            array('id' => 4,'id_marca' => 2,'nombre' => 'Galaxy 9') 
        );
        $wpdb->insert( 
            $tabla_dispositivo_modelo, 
            array('id' => 5,'id_marca' => 3,'nombre' => 'P20 Pro') 
        );
        $wpdb->insert( 
            $tabla_dispositivo_modelo, 
            array('id' => 6,'id_marca' => 3,'nombre' => 'Honor Band 5') 
        );
    }
    if ($wpdb->get_var("SELECT COUNT(*) FROM $tabla_dispositivo_variante") == 0 ) {
        $wpdb->insert( 
            $tabla_dispositivo_variante, 
            array('id' => 1,'id_modelo' => 4,'nombre' => 'G92016HQ', 'anyo' => '2016') 
        );
        $wpdb->insert( 
            $tabla_dispositivo_variante, 
            array('id' => 2,'id_modelo' => 4,'nombre' => 'G92018PQR', 'anyo' => '2018') 
        );
        $wpdb->insert( 
            $tabla_dispositivo_variante, 
            array('id' => 3,'id_modelo' => 1,'nombre' => 'APX17', 'anyo' => '2017') 
        );
        $wpdb->insert( 
            $tabla_dispositivo_variante, 
            array('id' => 4,'id_modelo' => 1,'nombre' => 'APX17S', 'anyo' => '2017') 
        );
        $wpdb->insert( 
            $tabla_dispositivo_variante, 
            array('id' => 5,'id_modelo' => 3,'nombre' => 'G82015P', 'anyo' => '2015') 
        );
    }
    if ($wpdb->get_var("SELECT COUNT(*) FROM $tabla_dispositivo_tipo") == 0 ) {
        $wpdb->insert( 
            $tabla_dispositivo_tipo, 
            array('id' => 1,'nombre' => 'Teléfono móvil') 
        );
        $wpdb->insert( 
            $tabla_dispositivo_tipo, 
            array('id' => 2,'nombre' => 'Ordenador portátil') 
        );
        $wpdb->insert( 
            $tabla_dispositivo_tipo, 
            array('id' => 3,'nombre' => 'Reloj inteligente') 
        );
    }
}