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

register_activation_hook(__FILE__, 'Kfp_Form_Mania_activation');
register_activation_hook(__FILE__, 'Kfp_Form_Mania_Datos_ejemplo');
// Define los shortcodes que muestran los distintos tipos de formularios
add_shortcode('kfp_form_mania_select_simple', 'Kfp_Form_Mania_Select_simple');
add_shortcode('kfp_form_manial_select_enlazado', 'Kfp_Form_Mania_Select_enlazado');

/**
 * Crea las tablas necesarias durante la activación del plugin
 *
 * @return void
 */
function Kfp_Form_Mania_activation()
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

/**
 * Implementa formulario con campo select simple
 *
 * @return void
 */
function Kfp_Form_Mania_Select_simple()
{
    global $wpdb;
    wp_enqueue_style('css_form_mania', plugins_url('style.css', __FILE__));

    if (!empty($_POST) && $_POST['nombre'] != '' && $_POST['id_tipo'] != '') {
        $tabla_dispositivo = $wpdb->prefix . 'dispositivo';
        $nombre = sanitize_text_field($_POST['nombre']);
        $id_tipo = (int)$_POST['id_tipo'];
        $created_at = date('Y-m-d H:i:s');
        $wpdb->insert(
            $tabla_dispositivo, 
            array(
                'nombre' => $nombre,
                'id_tipo' => $id_tipo,
                'created_at' => $created_at,
            )
        );
    }
    // Trae los tipos de dispositivos de la base de datos
    $tabla_dispositivo_tipo = $wpdb->prefix . 'dispositivo_tipo';
    $dispositivo_tipos = $wpdb->get_results("SELECT * from $tabla_dispositivo_tipo");    
    ob_start();
    ?>
    <form action="<?php get_the_permalink(); ?>" method="post"
        class="kfp-form-mania">
        <div class="form-input">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <div class="form-input">
            <label for="id_tipo">Tipo</label>
            <select name="id_tipo" required>
                <option value="">Selecciona el tipo de dispositivo</option>
                <?php
                foreach ($dispositivo_tipos as $tipo) {
                    echo("<option value='$tipo->id'>$tipo->nombre</option>)");
                }
                ?>
            </select>
        </div>
        <div class="form-input">
            <input type="submit" value="Enviar">
        </div>
    </form>
    <?php
    return ob_get_clean();
}

/**
 * Implementa formulario con campos select enlazados
 *
 * @return void
 */
function Kfp_Form_Mania_Select_enlazado()
{
    global $wpdb;
    wp_enqueue_style('css_form_mania', plugins_url('style.css', __FILE__));
    wp_enqueue_script(
        'js_select_enlazado', 
        plugins_url('select-enlazado.js', __FILE__)
    );

    if (!empty($_POST) && $_POST['nombre'] != '' && $_POST['id_modelo'] != '') {
        $tabla_dispositivo = $wpdb->prefix . 'dispositivo';
        $nombre = sanitize_text_field($_POST['nombre']);
        $id_modelo = (int)$_POST['id_modelo'];
        $created_at = date('Y-m-d H:i:s');
        $wpdb->insert(
            $tabla_dispositivo, 
            array(
                'nombre' => $nombre,
                'id_modelo' => $id_modelo,
                'created_at' => $created_at,
            )
        );
    }
    // Trae marcas y modelos de dispositivos de la base de datos
    $tabla_dispositivo_marca = $wpdb->prefix . 'dispositivo_marca';
    $dispositivo_marcas = $wpdb->get_results(
        "SELECT * FROM $tabla_dispositivo_marca"
    );
    $tabla_dispositivo_modelo = $wpdb->prefix . 'dispositivo_modelo';
    $dispositivo_modelos = $wpdb->get_results(
        "SELECT * FROM $tabla_dispositivo_modelo"
    );

    ob_start();
    ?>
    <form action="<?php get_the_permalink(); ?>" method="post"
        class="kfp-form-mania">
        <div class="form-input">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <div class="form-input">
            <label for="id_marca">Marca</label>
            <select name="id_marca" id="kfp-fm-select-marca" required>
                <option value="">Selecciona la marca del dispositivo</option>
                <?php
                foreach ($dispositivo_marcas as $marca) {
                    echo("<option value='$marca->id'>$marca->nombre</option>)");
                }
                ?>
            </select>
        </div>
        <div class="form-input">
            <label for="id_modelo">Modelo</label>
            <select name="id_modelo" id="kfp-fm-select-modelo" required>
                <option value="">Selecciona el modelo del dispositivo</option>
                <?php
                foreach ($dispositivo_modelos as $modelo) {
                    echo("<option data-marca='$modelo->id_marca' 
                        value='$modelo->id'>$modelo->nombre</option>");
                }
                ?>
            </select>
        </div>
        <div class="form-input">
            <input type="submit" value="Enviar">
        </div>
    </form>



    <?php
    return ob_get_clean();
}

/**
 * Inserta datos de ejemplo en las tablas de la base de datos
 *
 * @return void
 */
function Kfp_Form_Mania_Datos_ejemplo()
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