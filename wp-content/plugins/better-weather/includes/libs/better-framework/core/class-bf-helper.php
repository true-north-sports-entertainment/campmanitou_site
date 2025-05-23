<?php

/**
 * Deprecated!
 *
 * Helper functions for BetterFramework
 */
class BF_Helper {


    /**
     * Deprecated! Use bf_convert_number_to_odd
     *
     * @param $number
     * @param bool $down
     * @return bool|int
     */
    public static function convert_number_to_odd( $number , $down = false){
        return bf_convert_number_to_odd( $number, $down );
    }


    /**
     * Deprecated! Use bf_is_search_page
     */
    function is_search_page(){
        return bf_is_search_page();
    }


    /**
     * Deprecated! Use bf_get_query_var_paged
     */
    function get_query_var_paged( $default = 1 ){
        return bf_get_query_var_paged( $default );
    }


    /**
     * Deprecated! Use bf_get_sidebar_name_from_id
     */
    public static function get_sidebar_name( $sidebar_id ){
        return bf_get_sidebar_name_from_id( $sidebar_id );
    }


    /**
     * Deprecated! Use bf_get_menu_location_name_from_id
     */
    public static function get_menu_location_name( $location ){
        return bf_get_menu_location_name_from_id( $location );
    }


    /////////////////////////////////////////////////
    //
    // Multilingual Helper Functions
    //
    /////////////////////////////////////////////////


    /**
     * Deprecated! Use bf_get_current_lang
     */
    static function get_current_lang(){
        return bf_get_current_lang();
    }


    /**
     * Deprecated! Use bf_get_current_lang_raw
     */
    static function get_current_lang_raw(){
        return bf_get_current_lang_raw();
    }


    /**
     * Deprecated! Use bf_get_all_languages
     */
    static function get_languages(){
        return bf_get_all_languages();
    }


    /**
     * Deprecated! Use bf_get_language_data
     */
    static function get_language( $lang = null ){
        return bf_get_language_data( $lang );
    }

}