<?php


if( ! function_exists( 'bf_get_sidebar_name_from_id' ) ){
	/**
	 * Used For retrieving current sidebar
	 *
	 * @since 2.0
	 *
	 * @param $sidebar_id
	 *
	 * @return
	 */
	function bf_get_sidebar_name_from_id( $sidebar_id ) {

		global $wp_registered_sidebars;

		if( isset( $wp_registered_sidebars[ $sidebar_id ] ) ){
			return $wp_registered_sidebars[ $sidebar_id ]['name'];
		}

	}
}


