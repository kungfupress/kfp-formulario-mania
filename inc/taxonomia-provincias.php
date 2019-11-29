<?php
/**
 * File: kfp-formulario-mania/inc/taxonomia-provincias.php
 *
 * @package kfp-fman
 */

defined( 'ABSPATH' ) || die();

/**
 * Registra taxonomia para provincias
 *
 * @return void
 */
function kfp_fman_taxonomy_provincias() {
	$labels = array(
		'name'                       => _x( 'Provincias', 'Taxonomy General Name', 'kfp_fman' ),
		'singular_name'              => _x( 'Provincia', 'Taxonomy Singular Name', 'kfp_fman' ),
		'menu_name'                  => __( 'Provincias-fman', 'kfp_fman' ),
		'all_items'                  => __( 'Todas las provincias', 'kfp_fman' ),
		'new_item_name'              => __( 'Nueva provincia', 'kfp_fman' ),
		'add_new_item'               => __( 'Añadir nueva provincia', 'kfp_fman' ),
		'edit_item'                  => __( 'Editar provincia', 'kfp_fman' ),
		'update_item'                => __( 'Actualizar provincia', 'kfp_fman' ),
		'view_item'                  => __( 'Ver provincia', 'kfp_fman' ),
		'separate_items_with_commas' => __( 'Separar provincias con comas', 'kfp_fman' ),
		'add_or_remove_items'        => __( 'Añadir o eliminar provincias', 'kfp_fman' ),
		'choose_from_most_used'      => __( 'Elige entre las más usadas', 'kfp_fman' ),
		'popular_items'              => __( 'Provincias más frecuentes', 'kfp_fman' ),
		'search_items'               => __( 'Buscar provincias', 'kfp_fman' ),
		'not_found'                  => __( 'No encontrada', 'kfp_fman' ),
		'no_terms'                   => __( 'No hay provincias', 'kfp_fman' ),
		'items_list'                 => __( 'Lista de provincias', 'kfp_fman' ),
		'items_list_navigation'      => __( 'Lista de navegación de provincias', 'kfp_fman' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
	);
	// Registra la taxonomía pero no la enlaza a ningún tipo de entrada
	register_taxonomy( 'kfp_fman_provincias', array(), $args );
}
add_action( 'init', 'kfp_fman_taxonomy_provincias', 0 );

/**
 * Agrega las provincias como terms
 *
 * @return void
 */
function kfp_fman_provincias_add() {
	$provincias = array(
		'Álava',
		'Albacete',
		'Alicante',
		'Almería',
		'Asturias',
		'Ávila',
		'Badajoz',
		'Barcelona',
		'Burgos',
		'Cáceres',
		'Cádiz',
		'Cantabria',
		'Castellón',
		'Ciudad Real',
		'Córdoba',
		'La Coruña',
		'Cuenca',
		'Gerona',
		'Granada',
		'Guadalajara',
		'Guipúzcoa',
		'Huelva',
		'Huesca',
		'Islas Baleares',
		'Jaén',
		'León',
		'Lérida',
		'Lugo',
		'Madrid',
		'Málaga',
		'Murcia',
		'Navarra',
		'Orense',
		'Palencia',
		'Las Palmas',
		'Pontevedra',
		'La Rioja',
		'Salamanca',
		'Segovia',
		'Sevilla',
		'Soria',
		'Tarragona',
		'Santa Cruz de Tenerife',
		'Teruel',
		'Toledo',
		'Valencia',
		'Valladolid',
		'Vizcaya',
		'Zamora',
		'Zaragoza',
	);
	foreach ( $provincias as $provincia ) {
		wp_insert_term( $provincia, 'kfp_fman_provincias' );
	}
}
add_action( 'init', 'kfp_fman_provincias_add', 1 );
