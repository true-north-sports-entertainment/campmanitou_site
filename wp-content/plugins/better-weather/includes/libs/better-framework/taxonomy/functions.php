<?php


if( ! function_exists( 'bf_get_term_meta' ) ){
	/**
	 * Used For retrieving meta of term
	 *
	 * @param   int|object  $term_id       Term ID or object
	 * @param   string      $meta_id       Custom Field ID
	 * @param   bool|string $force_default Default Value
	 *
	 * @return bool
	 */
	function bf_get_term_meta( $meta_id, $term_id = NULL, $force_default = NULL ) {

		// Extract ID from term object if passed
		if( is_object( $term_id ) ){
			if( isset( $term_id->term_id ) ){
				$term_id = $term_id->term_id;
			} else {
				return $force_default;
			}
		} else {

			// If term ID not passed
			if( is_null( $term_id ) ){
				// If its category or tag archive get that term ID
				if( is_category() || is_tag() ){
					$term_id = get_queried_object()->term_id;
				} else {
					return $force_default;
				}

			}

		}

		// Return it from cache
		if( isset( BF()->taxonomy_meta()->cache[ $term_id ][ $meta_id ] ) ){
			return BF()->taxonomy_meta()->cache[ $term_id ][ $meta_id ];
		}

		if( $output = get_option( 'bf_term_'.$term_id ) ){

			if( isset( $output[ $meta_id ] ) ){
				BF()->taxonomy_meta()->cache[ $term_id ] = $output; // Save to cache
				return $output[ $meta_id ];
			}

		}

		// Default value for function have more priority to std field
		if( ! is_null( $force_default ) ){
			return $force_default;
		}

		// Load all options one time
		BF()->taxonomy_meta()->load_options();

		// Iterate All Metaboxe
		foreach( BF()->taxonomy_meta()->taxonomy_options as $metabox_id => $metabox ) {

			if( isset( $metabox['fields'][ $meta_id ] ) ){

				if( isset( $metabox['panel-id'] ) ){
					$std_id = BF()->options()->get_std_field_id( $metabox['panel-id'] );
				} else {
					$std_id = 'std';
				}

				if( isset( $metabox['fields'][ $meta_id ][ $std_id ] ) ){
					return $metabox['fields'][ $meta_id ][ $std_id ];
				} elseif( isset( $metabox['fields'][ $meta_id ]['std'] ) ) {
					return $metabox['fields'][ $meta_id ]['std'];
				} else {
					return $force_default;
				}

			}

		}

		// Fallback to return force default value! This return 'null' if not passed
		return $force_default;
	}
}


if( ! function_exists( 'bf_echo_term_meta' ) ){
	/**
	 * Used For echo meta of term
	 *
	 * @param   int|object  $term_id       Term ID or object
	 * @param   string      $meta_id       Custom Field ID
	 * @param   bool|string $force_default Default Value
	 *
	 * @return bool
	 */
	function bf_echo_term_meta( $meta_id, $term_id = NULL, $force_default = NULL ) {

		echo bf_get_term_meta( $meta_id, $term_id, $force_default );

	}
}