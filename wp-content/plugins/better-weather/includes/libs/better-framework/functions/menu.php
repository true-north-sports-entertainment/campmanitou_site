<?php


if( ! function_exists( 'bf_get_menu_location_name_from_id' ) ){
	/**
	 * Used For retrieving current sidebar
	 *
	 * #since 2.0
	 *
	 * @param $location
	 *
	 * @return
	 */
	function bf_get_menu_location_name_from_id( $location ) {

		$locations = get_registered_nav_menus();

		if( isset( $locations[ $location ] ) ){
			return $locations[ $location ];
		}

	}
}

