<?php
/**
 * File: kfp-formulario-mania/inc/graba-select-triple.php
 *
 * TODO:
 * store post data in transient with set_transient()
 * store any errors in transient
 * redirect to form output
 * check for errors in transient
 * load post values into form fields from transient.
 *
 * @package kfp-fman
 */

defined( 'ABSPATH' ) || die();
// Agrega los action hooks para grabar el formulario (el primero para usuarios
// logeados y el otro para el resto)
// Lo que viene tras admin_post_ y admin_post_nopriv_ tiene que coincidir con
// el value del campo input con name "action" del formulario enviado.
add_action( 'admin_post_kfp-fman-triple', 'kfp_fman_graba_triple_select' );
add_action( 'admin_post_nopriv_kfp-fman-triple', 'kfp_fman_graba_triple_select' );
/**
 * Graba los valores que vienen del formulario con triple select
 *
 * @return void
 */
function kfp_fman_graba_triple_select() {
	global $wpdb;
	// Aprovecha uno de los campos que crea wp_nonce para volver al form.
	if ( ! empty( $_POST['_wp_http_referer'] ) ) {
		$url_origen = esc_url_raw( wp_unslash( $_POST['_wp_http_referer'] ) );
	} else {
		$url_origen = home_url( '/' );
	}
	/**
	 * Invertir este if y lanzar error
	 */
	// Graba los datos del formulario si vienen rellenos los parámetros requeridos.
	if ( isset( $_POST['nombre'] )
		&& isset( $_POST['id_modelo'] )
		&& isset( $_POST['kfp-fman-triple-nonce'] )
		&& wp_verify_nonce(
			sanitize_text_field( wp_unslash( $_POST['kfp-fman-triple-nonce'] ) ),
			'kfp-fman-triple-action'
		)
		) {
		$tabla_dispositivo = $wpdb->prefix . 'dispositivo';
		$nombre            = sanitize_text_field( wp_unslash( $_POST['nombre'] ) );
		$id_modelo         = (int) $_POST['id_modelo'];
		if ( isset( $_POST['id_variante'] ) ) {
			$id_variante = (int) $_POST['id_variante'];
		}
		$created_at = date( 'Y-m-d H:i:s' );
		$wpdb->insert(
			$tabla_dispositivo,
			array(
				'nombre'      => $nombre,
				'id_modelo'   => $id_modelo,
				'id_variante' => $id_variante,
				'created_at'  => $created_at,
			)
		); // db call ok; no-cache ok.
		wp_safe_redirect(
			esc_url_raw(
				add_query_arg( 'kfp_fman_status', 'success', $url_origen )
			)
		);
		exit();
	} else {
		wp_safe_redirect(
			esc_url_raw(
				add_query_arg( 'kfp_fman_status', 'error', $url_origen )
			)
		);
		exit();
	}
}
