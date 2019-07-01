<?php

/**
 * Crea las tablas necesarias durante la activación del plugin
 *
 * @return void
 */
function Kfp_Form_Mania_Crear_tablas()
{
    global $wpdb;
    $sql = array(); 
    $tabla_dispositivo = $wpdb->prefix . 'dispositivo';
    $tabla_dispositivo_tipo = $wpdb->prefix . 'dispositivo_tipo';
    $tabla_dispositivo_marca = $wpdb->prefix . 'dispositivo_marca';
    $tabla_dispositivo_modelo = $wpdb->prefix . 'dispositivo_modelo';
    $charset_collate = $wpdb->get_charset_collate();
    
    // Consulta para crear las tablas
    // Mas adelante utiliza dbDelta, si la tabla ya existe no la crea sino que la
    // modifica con los posibles cambios y sin pérdida de datos
    $sql[] = "CREATE TABLE $tabla_dispositivo (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        nombre varchar(100) NOT NULL,
        id_tipo mediumint(9),
        id_modelo mediumint(9),
        numero_serie varchar(50),
        created_at datetime NOT NULL,
        PRIMARY KEY (id)
        ) $charset_collate";

    $sql[] = "CREATE TABLE $tabla_dispositivo_tipo (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        nombre varchar(100) NOT NULL,
        PRIMARY KEY (id)
        ) $charset_collate";

    $sql[] = "CREATE TABLE $tabla_dispositivo_marca (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        nombre varchar(100) NOT NULL,
        PRIMARY KEY (id)
        ) $charset_collate";
    
    $sql[] = "CREATE TABLE $tabla_dispositivo_modelo (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        id_marca mediumint(9) NOT NULL,
        nombre varchar(100) NOT NULL,
        PRIMARY KEY (id)
        ) $charset_collate";
    
    include_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}