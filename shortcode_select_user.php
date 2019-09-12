<?php
/**
 * Archivo: shortcode_select_user.php
 */

/**
 * Implementa formulario con campos select que carga usuarios de WordPress
 *
 * @return void
 */
function Kfp_Form_Mania_Select_user()
{
    global $wpdb;
    wp_enqueue_style('css_form_mania', plugins_url('style.css', __FILE__));

    // Si vienen datos del formulario los graba en las tablas
    if (!empty($_POST) && $_POST['nombre'] != '' && $_POST['id_usuario'] != '') {
        $tabla_dispositivo = $wpdb->prefix . 'dispositivo';
        $nombre = sanitize_text_field($_POST['nombre']);
        $id_usuario = (int)$_POST['id_usuario'];
        $created_at = date('Y-m-d H:i:s');
        $wpdb->insert(
            $tabla_dispositivo, 
            array(
                'nombre' => $nombre,
                'id_usuario' => $id_usuario,
                'created_at' => $created_at,
            )
        );
    }
    
    $users = get_users();
    ob_start();
    ?>
    <form action="<?php get_the_permalink(); ?>" method="post"
        class="kfp-form-mania">
        <div class="form-input">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <div class="form-input">
            <label for="id_usuario">Usuario</label>
            <select name="id_usuario" id="kfp-fm-select-usuario" required>
                <option value="">Selecciona el usuario</option>
                <?php
                foreach ($users as $user) {
                    echo("<option value='$user->ID'>$user->user_nicename</option>)");
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