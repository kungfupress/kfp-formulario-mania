<?php
/** Archivo: crear_datos_ejemplo.php */

/**
 * Inserta datos de ejemplo en las tablas de la base de datos
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

    /*
    $sql = array();
    $sql[] = "DELETE FROM $tabla_dispositivo WHERE id = 1";
    $sql[] = "DELETE FROM $tabla_dispositivo_tipo WHERE id = 1";
    $sql[] = "DELETE FROM $tabla_dispositivo_marca WHERE id = 1";
    $sql[] = "DELETE FROM $tabla_dispositivo_modelo WHERE id = 1";
    include_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
    */

    $wpdb->insert( 
        $tabla_dispositivo_marca,  
        array('id' => 1, 'nombre' => 'Apple')
    );
    $wpdb->insert( 
        $tabla_dispositivo_marca, 
        array('id' => 2, 'nombre' => 'Samsung')
    );
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
        $tabla_dispositivo_tipo, 
        array('id' => 1,'nombre' => 'Teléfono móvil') 
    );
    $wpdb->insert( 
        $tabla_dispositivo_tipo, 
        array('id' => 2,'nombre' => 'Ordenador portátil') 
    );
    $wpdb->insert( 
        $tabla_dispositivo_tipo, 
        array('id' => 3,'nombre' => 'Proyector de vídeo') 
    );

    $wpdb->insert( 
        $tabla_dispositivo, 
        array( 
            'id' => 1,
            'nombre' => 'Dispositivo móvil Pepe', 
            'id_tipo' => 1,
            'id_modelo' => 1, 
            'numero_serie' => 'DNPX55778899-098',
            'created_at' => current_time('mysql'), 
            ) 
    );
}