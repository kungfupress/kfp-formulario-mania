<?php
/**
 * File: shortcode_select_enlazado.php
 *
 * @package kfp-fman
 */

defined( 'ABSPATH' ) || die();
/**
 * Implementa formulario con campos select enlazados.
 *
 * @return string
 */
function kfp_form_mania_select_enlazado() {
	global $wpdb;
	wp_enqueue_style(
		'css_form_mania',
		plugins_url( '../css/style.css', __FILE__ ),
		null,
		KFP_FMAN_VERSION
	);
	wp_enqueue_script(
		'js_select_enlazado',
		plugins_url( '../js/select-enlazado.js', __FILE__ ),
		'jquery',
		true,
		KFP_FMAN_VERSION
	);
	if ( ! empty( $_POST ) && $_POST['nombre'] != '' && $_POST['id_modelo'] != '' ) {
		$tabla_dispositivo = $wpdb->prefix . 'dispositivo';
		$nombre            = sanitize_text_field( $_POST['nombre'] );
		$id_modelo         = (int) $_POST['id_modelo'];
		$created_at        = date( 'Y-m-d H:i:s' );
		$wpdb->insert(
			$tabla_dispositivo,
			array(
				'nombre'     => $nombre,
				'id_modelo'  => $id_modelo,
				'created_at' => $created_at,
			)
		);
	}
	// Trae marcas y modelos de dispositivos de la base de datos.
	$tabla_dispositivo_marca = $wpdb->prefix . 'dispositivo_marca';
	$dispositivo_marcas      = $wpdb->get_results( "SELECT * FROM $tabla_dispositivo_marca" );
	$tabla_dispositivo_modelo = $wpdb->prefix . 'dispositivo_modelo';
	$dispositivo_modelos      = $wpdb->get_results( "SELECT * FROM $tabla_dispositivo_modelo" );
	ob_start();
	?>
	<form action="<?php get_the_permalink(); ?>" method="post"
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
				foreach ( $dispositivo_marcas as $marca ) {
					echo( "<option value='$marca->id'>$marca->nombre</option>)" );
				}
				?>
			</select>
		</div>
		<div class="form-input">
			<label for="id_modelo">Modelo</label>
			<select name="id_modelo" id="kfp-fm-select-modelo" required>
				<option value="">Selecciona el modelo del dispositivo</option>
				<?php
				foreach ( $dispositivo_modelos as $modelo ) {
					echo '<option data-marca="' . esc_attr( $modelo->id_marca )
						. '" value="' . esc_attr( $modelo->id ) . '">'
						. esc_attr( $modelo->nombre ) . '</option>';
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
