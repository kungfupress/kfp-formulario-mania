<?php
/**
 * File: kfp-formulario-mania/inc/shortcode-select-triple.php
 *
 * @package kfp-man
 */

defined( 'ABSPATH' ) || die();
/**
 * Implementa formulario con campos select enlazados.
 *
 * @return string
 */
function kfp_fman_select_triple() {
	global $wpdb;
	wp_enqueue_style(
		'css_form_mania',
		plugins_url( '../css/style.css', __FILE__ ),
		null,
		KFP_FMAN_VERSION
	);
	wp_enqueue_script(
		'js_select_triple',
		plugins_url( '../js/select-triple.js', __FILE__ ),
		array( 'jquery' ),
		KFP_FMAN_VERSION,
		false
	);
	// Trae marcas, modelos y variantes de dispositivos de la base de datos
	// para mostrarlos en los desplegables del formulario.
	$dispositivo_marcas    = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}dispositivo_marca`" ); // db call ok; no-cache ok.
	$dispositivo_modelos   = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}dispositivo_modelo`" ); // db call ok; no-cache ok.
	$dispositivo_variantes = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}dispositivo_variante`" ); // db call ok; no-cache ok.
	if ( filter_input( INPUT_GET, 'kfp_fman_status', FILTER_SANITIZE_STRING ) === 'success' ) {
		echo '<h4>Dispositivo grabado correctamente</h4>';
	}
	if ( filter_input( INPUT_GET, 'kfp_fman_status', FILTER_SANITIZE_STRING ) === 'error' ) {
		echo '<h4>Se ha producido un error al grabar el dispositivo</h4>';
	}
	ob_start();
	?>
	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post"
		class="kfp-form-mania" id="kfp-fman-form-triple-select">
		<?php wp_nonce_field( 'kfp-fman-triple-action', 'kfp-fman-triple-nonce' ); ?>
		<input type="hidden" name="action" value="kfp-fman-triple">
		<div class="form-input">
			<label for="nombre">Nombre</label>
			<input type="text" name="nombre" id="nombre" required>
		</div>
		<div class="form-input">
			<label for="id_marca">Marca</label>
			<select name="id_marca" id="kfp-fman-select-marca" required>
				<option value="">Selecciona la marca del dispositivo</option>
				<?php
				foreach ( $dispositivo_marcas as $marca ) {
					echo ( '<option value="' . esc_attr( $marca->id ) . '">'
					. esc_attr( $marca->nombre ) . '</option>' );
				}
				?>
			</select>
		</div>
		<div class="form-input">
			<label for="id_modelo">Modelo</label>
			<select name="id_modelo" id="kfp-fman-select-modelo" required>
				<option value="" selected>Selecciona el modelo del dispositivo</option>
				<?php
				foreach ( $dispositivo_modelos as $modelo ) {
					echo ( '<option data-marca="' . esc_attr( $modelo->id_marca )
						. '" value="' . esc_attr( $modelo->id ) . '">'
						. esc_attr( $modelo->nombre ) . '</option>' );
				}
				?>
			</select>
		</div>
		<div class="form-input">
			<label for="id_variante">Variante</label>
			<select name="id_variante" id="kfp-fman-select-variante">
				<option value="0" selected>No hay variantes para este modelo</option>
				<?php
				foreach ( $dispositivo_variantes as $variante ) {
					echo ( '<option data-modelo="' . esc_attr( $variante->id_modelo )
						. '" value=" ' . esc_attr( $variante->id ) . '">'
						. esc_attr( $variante->nombre ) . '</option>' );
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
