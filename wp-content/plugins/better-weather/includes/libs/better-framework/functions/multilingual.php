<?php



if( ! function_exists( 'bf_get_current_lang' ) ){
	/**
	 * Used for finding current language in multilingual
	 *
	 * @sine 2.0
	 *
	 * @return string
	 */
	function bf_get_current_lang() {

		// WPML
		if( defined( 'ICL_SITEPRESS_VERSION' ) ){

			$lang = icl_get_current_language();

			// Fix conditions WPML is active but not setup
			if( is_null( $lang ) ){
				$lang = 'none';
			}

		} else {
			$lang = 'none';
		}

		// Default language is en!
		if( $lang == 'en' ){
			$lang = 'none';
		}

		return $lang;
	}
}


if( ! function_exists( 'bf_get_current_lang_raw' ) ){
	/**
	 * Used for finding current language in multilingual
	 *
	 * @sine 2.0
	 *
	 * @return string
	 */
	function bf_get_current_lang_raw() {

		// WPML
		if( defined( 'ICL_SITEPRESS_VERSION' ) ){

			$lang = icl_get_current_language();

			// Fix conditions WPML is active but not setup
			if( is_null( $lang ) ){
				$lang = 'none';
			}

		} else {
			$lang = 'none';
		}

		return $lang;
	}
}


if( ! function_exists( 'bf_get_all_languages' ) ){
	/**
	 * Returns all active multilingual languages
	 *
	 * @since 2.0
	 *
	 * @return array
	 */
	function bf_get_all_languages() {

		$languages = array();

		// WPML
		if( defined( 'ICL_SITEPRESS_VERSION' ) ){

			global $sitepress;

			// get filtered active language informations
			$temp_lang = icl_get_languages( 'skip_missing=1' );

			foreach( $temp_lang as $lang ) {

				// Get language raw data from DB
				$_lang = $sitepress->get_language_details( $lang['language_code'] );

				$languages[] = array(
					'id'     => $lang['language_code'],
					'name'   => $_lang['english_name'], // english display name
					'flag'   => $lang['country_flag_url'],
					'locale' => $lang['default_locale'],
				);

			}

		} elseif( function_exists( 'pll_languages_list' ) ) {

			$languages = pll_languages_list();

		}

		return $languages;

	}
}


if( ! function_exists( 'bf_get_language_data' ) ){
	/**
	 * Returns multilingual language information
	 *
	 * @since 2.0
	 *
	 * @param null $lang
	 *
	 * @return array
	 */
	function bf_get_language_data( $lang = NULL ) {

		$output = array(
			'id'     => '',
			'name'   => '',
			'flag'   => '',
			'locale' => '',
		);

		if( is_null( $lang ) )
			return $output;

		$languages = bf_get_all_languages();

		foreach( $languages as $_language ) {

			if( $_language['id'] == $lang ){

				$output = $_language;

			}

		}

		return $output;

	}
}



if( ! function_exists( 'bf_get_language_name' ) ){
	/**
	 * Returns multilingual language name from ID
	 *
	 * @since 2.0
	 *
	 * @param null $lang
	 *
	 * @return array
	 */
	function bf_get_language_name( $lang = NULL ) {

		$lang = bf_get_language_data( $lang );

		if( isset( $lang['name'] ) ){
			return $lang['name'];
		}

		return '';
	}
}

