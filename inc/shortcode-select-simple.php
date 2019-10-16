<?php
/**
 * File: kfp-formulario-mania/inc/shortcode_select_simple.php
 *
 * @package kfp-man
 */

defined( 'ABSPATH' ) || die();
/**
 * Implementa formulario con campo select simple.
 *
 * @return string
 */
function kfp_fman_select_simple() {
	global $wpdb;
	wp_enqueue_style(
		'css_form_mania',
		plugins_url( '../css/style.css', __FILE__ ),
		null,
		KFP_FMAN_VERSION
	);
	if ( isset( $_POST )
		&& isset( $_POST['nombre'] )
		&& isset( $_POST['id_marca'] )
		&& isset( $_POST['kfp-fman-simple-nonce'] )
		&& wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kfp-fman-simple-nonce'] ) ), 'kfp-man-simple' )
		) {
		$nombre   = sanitize_text_field( wp_unslash( $_POST['nombre'] ) );
		$id_marca = (int) $_POST['id_marca'];
		$wpdb->insert(
			$wpdb->prefix . 'dispositivo_modelo',
			array(
				'nombre'   => $nombre,
				'id_marca' => $id_marca,
			)
		); // db call ok; no-cache ok.
	}
	// Trae las marcas de dispositivos de la base de datos.
	$dispositivo_marcas = $wpdb->get_results(
		"SELECT * FROM `{$wpdb->prefix}dispositivo_marca` ORDER BY nombre"
	); // db call ok; no-cache ok.
	ob_start();
	?>
	<form action="<?php get_the_permalink(); ?>" method="post"
		class="kfp-form-mania">
		<?php wp_nonce_field( 'kfp-fman-simple', 'kfp-fman-simple-nonce' ); ?>
		<div class="form-input">
			<label for="nombre">Modelo</label>
			<input type="text" name="nombre" id="nombre" required>
		</div>
		<div class="form-input">
			<label for="id_marca">Marca</label>
			<select name="id_marca" required>
				<option value="">Selecciona la marca</option>
				<?php
				foreach ( $dispositivo_marcas as $marca ) {
					echo(
						'<option value="' . esc_attr( $marca->id ) . '">'
						. esc_attr( $marca->nombre ) . '</option>'
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
