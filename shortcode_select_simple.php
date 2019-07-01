<?php

/**
 * Implementa formulario con campo select simple
 *
 * @return void
 */
function Kfp_Form_Mania_Select_simple()
{
    global $wpdb;
    wp_enqueue_style('css_form_mania', plugins_url('style.css', __FILE__));

    if (!empty($_POST) && $_POST['nombre'] != '' && $_POST['id_marca'] != '') {
        $tabla_dispositivo_modelo = $wpdb->prefix . 'dispositivo_modelo';
        $nombre = sanitize_text_field($_POST['nombre']);
        $id_marca = (int)$_POST['id_marca'];
        $wpdb->insert(
            $tabla_dispositivo_modelo, 
            array(
                'nombre' => $nombre,
                'id_marca' => $id_marca,
            )
        );
    }
    // Trae las marcas de dispositivos de la base de datos
    $tabla_dispositivo_marca = $wpdb->prefix . 'dispositivo_marca';
    $dispositivo_marcas = $wpdb->get_results(
        "SELECT * from $tabla_dispositivo_marca ORDER BY nombre"
    );    
    ob_start();
    ?>
    <form action="<?php get_the_permalink(); ?>" method="post"
        class="kfp-form-mania">
        <div class="form-input">
            <label for="nombre">Modelo</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <div class="form-input">
            <label for="id_marca">Marca</label>
            <select name="id_marca" required>
                <option value="">Selecciona la marca</option>
                <?php
                foreach ($dispositivo_marcas as $marca) {
                    echo("<option value='$marca->id'>$marca->nombre</option>)");
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