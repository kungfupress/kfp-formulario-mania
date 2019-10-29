<?php
/**
 * File: kfp-formulario-mania/inc/shortcode-select-enlazado.php
 *
 * @package kfp-man
 */

defined( 'ABSPATH' ) || die();
// Agrega los action hooks para grabar el formulario (el primero para usuarios
// logeados y el otro para el resto)
// Lo que viene tras admin_post_ y admin_post_nopriv_ tiene que coincidir con
// el value del campo input con name "action" del formulario enviado.
add_action( 'admin_post_kfp-fman-enlazado', 'kfp_fman_graba_select_enlazado' );
add_action( 'admin_post_nopriv_kfp-fman-enlazado', 'kfp_fman_graba_select_enlazado' );
/**
 * Graba los valores que vienen del formulario con enlazado select
 *
 * @return void
 */
function kfp_fman_graba_select_enlazado() {
	global $wpdb;
	// Aprovecha uno de los campos que crea wp_nonce para volver al form.
	if ( ! empty( $_POST['_wp_http_referer'] ) ) {
		$url_origen = esc_url_raw( wp_unslash( $_POST['_wp_http_referer'] ) );
	} else {
		$url_origen = home_url( '/' );
	}
	if ( isset( $_POST['nombre'] )
		&& isset( $_POST['id_modelo'] )
		&& isset( $_POST['kfp-fman-enlazado-nonce'] )
		&& wp_verify_nonce(
		sanitize_text_field( wp_unslash( $_POST['kfp-fman-enlazado-nonce'] ) ),
		'kfp-fman-enlazado-action'
	)
	) {
		$nombre     = sanitize_text_field( wp_unslash( $_POST['nombre'] ) );
		$id_modelo  = (int) $_POST['id_modelo'];
		$created_at = date( 'Y-m-d H:i:s' );
		$wpdb->insert(
			$wpdb->prefix . 'dispositivo',
			array(
				'nombre'     => $nombre,
				'id_modelo'  => $id_modelo,
				'created_at' => $created_at,
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
