<?php
/**
 * File: shortcode-select-triple.php
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
		plugins_url( '../js/select-ttriple.js', __FILE__ ),
		array( 'jquery' ),
		KFP_FMAN_VERSION,
		false
	);
	// Trae marcas, modelos y variantes de dispositivos de la base de datos
	// para mostrarlos en los desplegables del formulario.
	$tabla_dispositivo_marca    = $wpdb->prefix . 'dispositivo_marca'; // db call ok; no-cache ok.
	$dispositivo_marcas         = $wpdb->get_results( "SELECT * FROM $tabla_dispositivo_marca" ); // db call ok; no-cache ok.
	$tabla_dispositivo_modelo   = $wpdb->prefix . 'dispositivo_modelo';
	$dispositivo_modelos        = $wpdb->get_results( "SELECT * FROM $tabla_dispositivo_modelo" ); // db call ok; no-cache ok.
	$tabla_dispositivo_variante = $wpdb->prefix . 'dispositivo_variante';
	$dispositivo_variantes      = $wpdb->get_results( "SELECT * FROM $tabla_dispositivo_variante" ); // db call ok; no-cache ok.
	if ( isset( $_GET['kfp_fman_texto_aviso'] ) ) {
		echo '<h4>' . $_GET['kfp_fman_texto_aviso'] . '</h4>';
	}
	ob_start();
	?>
	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post"
		class="kfp-form-mania" id="kfp-fman-form-triple-select">
		<?php wp_nonce_field( 'kfp-fman-triple', 'kfp-fman-triple-nonce' ); ?>
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
					echo ( "<option value='$marca->id'>$marca->nombre</option>)" );
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
					echo ( "<option data-marca='$modelo->id_marca'
						value='$modelo->id'>$modelo->nombre</option>" );
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
					echo ( "<option data-modelo='$variante->id_modelo'
                        value='$variante->id'>$variante->nombre</option>" );
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
