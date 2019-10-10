<?php
// Evita que se llame directamente a este fichero sin pasar por WordPress
defined( 'ABSPATH' ) or die();
// Agrega los action hooks para grabar el formulario (el primero para usuarios 
// logeados y el otro para el resto)
// Lo que viene tras admin_post_ y admin_post_nopriv_ tiene que coincidir con 
// el value del campo input con name "action" del formulario enviado
add_action("admin_post_kfp-fman-triple", "Kfp_Fman_Graba_Triple_select");
add_action("admin_post_nopriv_kfp-fman-triple", "Kfp_Fman_Graba_Triple_select");
/**
 * Graba los valores que vienen del formulario con triple select
 *
 * @return void
 */
function Kfp_Fman_Graba_Triple_select()
{
    global $wpdb;
    // Aprovecha uno de los campos que crea wp_nonce para volver al form
    if (!empty($_POST['_wp_http_referer'])){
        $url_origen = $_POST['_wp_http_referer'];
    } else {
        $url_origen = home_url( '/');
    }
    /**
     * Invertir este if y lanzar error
     */
    // Graba los datos del formulario si vienen rellenos los parámetros requeridos
    if (!empty($_POST) && $_POST['nombre'] != '' && $_POST['id_modelo'] != ''){ 
    //&& wp_verify_nonce($_POST['kfp-fman-triple-nonce'], 'kfp-fman-triple')) {
        $tabla_dispositivo = $wpdb->prefix . 'dispositivo';
        $nombre = sanitize_text_field($_POST['nombre']);
        $id_modelo = (int) $_POST['id_modelo'];
        if ($_POST['id_variante'] != '') {
            $id_variante = (int) $_POST['id_variante'];
        } 
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
        $aviso = "success";
        $texto_aviso = "Se ha registrado un dispositivo correctamente. ¡Gracias!";
        wp_redirect(
            esc_url_raw(
                add_query_arg(
                    array(
                        'kfp_fman_aviso' => $aviso,
                        'kfp_fman_texto_aviso' => $texto_aviso,
                    ),
                    $url_origen
                )
            )
        );
        exit();
    } else {
        $aviso = "error";
        $texto_aviso = "Por favor, rellena los contenidos requeridos del formulario";
        wp_redirect(
            esc_url_raw(
                add_query_arg(
                    array(
                        'kfp_fman_aviso' => $aviso,
                        'kfp_fman_texto_aviso' => $texto_aviso,
                    ),
                    $url_origen
                )
            )
        );
        exit();
    }
    /**
     * store post data in transient with set_transient()
     * store any errors in transient
     * redirect to form output
     * check for errors in transient
     * load post values into form fields from transient
     */
}
