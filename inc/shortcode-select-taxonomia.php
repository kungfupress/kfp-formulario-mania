<?php
/**
 * File: kfp-formulario-mania/inc/shortcode_select_taxonomia.php
 *
 * @package kfp-man
 */

defined( 'ABSPATH' ) || die();

add_shortcode( 'kfp_fman_select_taxonomia', 'kfp_fman_select_taxonomia' );
/**
 * Implementa formulario con campo select taxonomia.
 *
 * @return string
 */
function kfp_fman_select_taxonomia() {
	global $wpdb;
	wp_enqueue_style(
		'css_form_mania',
		plugins_url( '../css/style.css', __FILE__ ),
		null,
		KFP_FMAN_VERSION
	);
	if ( isset( $_POST )
		&& isset( $_POST['nombre'] )
		&& isset( $_POST['id_provincia'] )
		&& isset( $_POST['kfp-fman-taxonomia-nonce'] )
		&& wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kfp-fman-taxonomia-nonce'] ) ), 'kfp-fman-taxonomia' )
		) {
		$nombre   = sanitize_text_field( wp_unslash( $_POST['nombre'] ) );
		$id_provincia = (int) $_POST['id_provincia'];
		$created_at = date( 'Y-m-d H:i:s' );
		$wpdb->insert(
			$wpdb->prefix . 'dispositivo',
			array(
				'nombre'   => $nombre,
				'id_term_provincia' => $id_provincia,
				'created_at' => $created_at,
			)
		); // db call ok; no-cache ok.
	}
	// Trae las provincias de dispositivos de la base de datos.
	$provincias = get_terms( 'kfp_fman_provincias', array(
		'orderby'    => 'term_id',
		'hide_empty' => 0
	) );
	ob_start();
	?>
	<form action="<?php get_the_permalink(); ?>" method="post"
		class="kfp-form-mania">
		<?php wp_nonce_field( 'kfp-fman-taxonomia', 'kfp-fman-taxonomia-nonce' ); ?>
		<div class="form-input">
			<label for="nombre">Modelo</label>
			<input type="text" name="nombre" id="nombre" required>
		</div>
		<div class="form-input">
			<label for="id_provincia">Provincia</label>
			<select name="id_provincia" required>
				<option value="">Selecciona la provincia</option>
				<?php
				foreach ( $provincias as $provincia ) {
					echo(
						'<option value="' . esc_attr( $provincia->term_id ) . '">'
						. esc_attr( $provincia->name ) . '</option>'
					);
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
