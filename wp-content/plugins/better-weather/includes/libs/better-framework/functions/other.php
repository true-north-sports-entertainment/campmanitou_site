<?php


if( ! function_exists( 'bf_enqueue_style' ) ){
	/**
	 * Enqueue BetterFramework styles safely
	 *
	 * @param $style_key
	 */
	function bf_enqueue_style( $style_key = '' ) {

		Better_Framework::assets_manager()->enqueue_style( $style_key );

	}
}


if( ! function_exists( 'bf_enqueue_script' ) ){
	/**
	 * Enqueue BetterFramework scripts safely
	 *
	 * @param $script_key
	 */
	function bf_enqueue_script( $script_key ) {

		Better_Framework::assets_manager()->enqueue_script( $script_key );

	}
}


if( ! function_exists( 'bf_add_jquery_js' ) ){
	/**
	 * Used for adding inline js to front end
	 *
	 * @param string $code
	 * @param bool   $to_top
	 */
	function bf_add_jquery_js( $code = '', $to_top = FALSE ) {

		Better_Framework::assets_manager()->add_jquery_js( $code, $to_top );

	}
}


if( ! function_exists( 'bf_add_js' ) ){
	/**
	 * Used for adding inline js to front end
	 *
	 * @param string $code
	 * @param bool   $to_top
	 */
	function bf_add_js( $code = '', $to_top = FALSE ) {

		Better_Framework::assets_manager()->add_js( $code, $to_top );

	}
}


if( ! function_exists( 'bf_add_css' ) ){
	/**
	 * Used for adding inline css to front end
	 *
	 * @param string $code
	 * @param bool   $to_top
	 */
	function bf_add_css( $code = '', $to_top = FALSE ) {

		Better_Framework::assets_manager()->add_css( $code, $to_top );

	}
}


if( ! function_exists( 'bf_add_admin_js' ) ){
	/**
	 * Used for adding inline js to back end
	 *
	 * @param string $code
	 * @param bool   $to_top
	 */
	function bf_add_admin_js( $code = '', $to_top = FALSE ) {

		Better_Framework::assets_manager()->add_admin_js( $code, $to_top );

	}
}


if( ! function_exists( 'bf_add_admin_css' ) ){
	/**
	 * Used for adding inline css to back end
	 *
	 * @param string $code
	 * @param bool   $to_top
	 */
	function bf_add_admin_css( $code = '', $to_top = FALSE ) {

		Better_Framework::assets_manager()->add_admin_css( $code, $to_top );

	}
}


if( ! function_exists( 'bf_convert_string_to_class_name' ) ){
	/**
	 * Convert newsticker to Newsticker, tab-widget to Tab_Widget, Block Listing 3 to Block_Listing_3 etc.
	 *
	 * @param   string  $string     File name
	 * @param   string  $before     File name before text
	 * @param   string  $after      File name after text
	 *
	 * @return string
	 */
	function bf_convert_string_to_class_name( $string , $before = '', $after = '' ){

		$class = str_replace(
			array( '/' , '-', ' ' ),
			'_',
			$string
		);

		$class = explode( '_', $class );

		$class = array_map('ucwords',$class);

		$class = implode( '_', $class );

		return $before . $class . $after;
	}
}


if( ! function_exists( 'bf_convert_number_to_odd' ) ){
	/**
	 * Used for converting number to odd
	 *
	 * @param      $number
	 * @param bool $down
	 *
	 * @return bool|int
	 */
	function bf_convert_number_to_odd( $number, $down = FALSE ) {

		if( is_int( $number ) ){

			if( intval( $number ) % 2 == 0 ){
				return $number;
			} else {

				if( $down ){
					return intval( $number ) - 1;
				} else {
					return intval( $number ) + 1;
				}

			}

		}

		return FALSE;
	}
}


if( ! function_exists( 'bf_var_dump' ) ){
	/**
	 * var_dump on multiple inputs
	 *
	 * @param string|array|object $arg
	 *
	 * @return string
	 */
	function bf_var_dump( $arg ) {

		$arg = func_get_args();

		echo '<pre style="direction: ltr; background: #FFF8D7;border: 1px solid #E5D68D; margin: 10px 0; padding: 15px;">';

		call_user_func_array( 'var_dump', $arg );

		echo '</pre>';

	}
}


if( ! function_exists( 'bf_print_r' ) ){
	/**
	 * print_r on multiple inputs
	 *
	 * @param string|array|object $arg
	 *
	 * @return string
	 */
	function bf_print_r( $arg ) {

		$args = func_get_args();

		echo '<pre style="direction: ltr; background: #FFF8D7;border: 1px solid #E5D68D; margin: 10px 0; padding: 15px;">';

		call_user_func_array( 'print_r', $args );

		echo '</pre>';

	}
}


if( ! function_exists( 'bf_is_json' ) ){
	/**
	 * Checks string for valid JSON
	 *
	 * @param $string
	 *
	 * @return bool
	 */
	function bf_is_json( $string ) {

		json_decode( $string );

		return json_last_error() == JSON_ERROR_NONE;

	}
}


if( ! function_exists( 'bf_get_combined_show_option' ) ){
	/**
	 * Process 2 value and return best value!
	 *
	 * @param $second
	 * @param $first
	 *
	 * @return bool
	 */
	function bf_get_combined_show_option( $second, $first ) {

		if( $first == 'default' ){
			return $second;
		}

		return $first;

	}
}