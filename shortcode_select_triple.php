<?php
/**
 * Archivo: shortcode_select_triple.php
 */

/**
 * Implementa formulario con campos select enlazados
 *
 * @return void
 */
function Kfp_Form_Mania_Select_triple()
{
    global $wpdb;
    wp_enqueue_style('css_form_mania', plugins_url('style.css', __FILE__));
    wp_enqueue_script(
        'js_select_triple',
        plugins_url('js/select-triple.js', __FILE__)
    );
    // Graba los datos del formulario si vienen rellenos los parámetros requeridos
    if (!empty($_POST) && $_POST['nombre'] != '' && $_POST['id_modelo'] != '' 
        && $_POST['id_variante'] != '') {
        $tabla_dispositivo = $wpdb->prefix . 'dispositivo';
        $nombre = sanitize_text_field($_POST['nombre']);
        $id_modelo = (int) $_POST['id_modelo'];
        $id_variante = (int) $_POST['id_variante'];
        $created_at = date('Y-m-d H:i:s');
        $wpdb->insert(
            $tabla_dispositivo,
            array(
                'nombre' => $nombre,
                'id_modelo' => $id_modelo,
                'id_variante' => $id_variante,
                'created_at' => $created_at,
            )
        );
    }
    // Trae marcas, modelos y variantes de dispositivos de la base de datos
    // para mostrarlos en los desplegables del formulario
    $tabla_dispositivo_marca = $wpdb->prefix . 'dispositivo_marca';
    $dispositivo_marcas = $wpdb->get_results("SELECT * FROM $tabla_dispositivo_marca");
    $tabla_dispositivo_modelo = $wpdb->prefix . 'dispositivo_modelo';
    $dispositivo_modelos = $wpdb->get_results("SELECT * FROM $tabla_dispositivo_modelo");
    $tabla_dispositivo_variante = $wpdb->prefix . 'dispositivo_variante';
    $dispositivo_variantes = $wpdb->get_results("SELECT * FROM $tabla_dispositivo_variante");
    ob_start();
    ?>
    <form action="<?php get_the_permalink();?>" method="post"
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
                    echo ("<option value='$marca->id'>$marca->nombre</option>)");
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
                    echo ("<option data-marca='$modelo->id_marca'
                        value='$modelo->id'>$modelo->nombre</option>");
                }
                ?>
            </select>
        </div>
        <div class="form-input">
            <label for="id_variante">Variante</label>
            <select name="id_variante" id="kfp-fm-select-variante" required>
                <option value="">Selecciona la variante del dispositivo</option>
                <?php
                foreach ($dispositivo_variantes as $variante) {
                    echo ("<option data-modelo='$variante->id_modelo'
                        value='$variante->id'>$variante->nombre</option>");
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