<?php
/*
Plugin Name: BetterWeather
Plugin URI: http://codecanyon.net/item/better-weather-wordpress-version/7724257?ref=Better-Studio
Description:
Version: 2.0.3
Author: BetterWeather
Author URI: http://betterstudio.com
License: GPL2
Text Domain: better-studio
*/

//  Last version ( V < 1.5 ) compatibility
$last_options = get_option( 'bwoptions_settings' );
if( $last_options != false ){

    if( $last_options['bwoptions_api_forecast_apiKei'] != '' )
        add_filter( 'better-framework/panel/options', 'bw_add_api_key_to_new_panel', 150 );
}
function bw_add_api_key_to_new_panel( $options ){

    $last_options = get_option( 'bwoptions_settings' );
    $options['better_weather_options']['fields']['api_key']['std'] =  $last_options['bwoptions_api_forecast_apiKei'];
    delete_option( 'bwoptions_settings' );

    return $options;

}

// Fire up BetterWeather
new Better_Weather();

class Better_Weather{

    /**
     * Contains BW version number that used for assets for preventing cache mechanism
     *
     * @var string
     */
    private static $version = '2.0.3';


    /**
     * Contains BW option panel id
     *
     * @var string
     */
    public static $panel_id = 'better_weather_options';


    function __construct(){

        // Clear BF transients on plugin activation
        register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );

        // Register included BF to loader
        add_filter( 'better-framework/loader', array( $this, 'better_framework_loader' ) );

        // Enable needed sections
        add_filter( 'better-framework/sections', array( $this, 'better_framework_sections' ) );

        // Add option panel
        include 'includes/panel-options.php';

        // Active and new shortcodes
        add_filter( 'better-framework/shortcodes', array( $this, 'setup_shortcodes' ) );

        // Initialize BetterWeather
        add_action( 'better-framework/after_setup', array( $this, 'init' ) );

        // Callback for resetting data
        add_filter( 'better-framework/panel/reset/result', array( $this , 'callback_panel_reset_result'), 10, 2 );

        // Callback for importing data
        add_filter( 'better-framework/panel/import/result', array( $this , 'callback_panel_import_result'), 10, 3 );

        // Adding Visual Composer add-on
        add_action( 'plugins_loaded', array( $this, 'register_vc_support' ) );

        // Includes BF loader if not included before
        require_once 'includes/libs/better-framework/init.php';

        // Ads plugin textdomain
        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

    }


    /**
     * Load plugin textdomain.
     *
     * @since 2.0.1
     */
    function load_textdomain() {

        // Register text domain
        load_plugin_textdomain( 'better-studio', false, 'better-weather/languages' );

    }


    /**
     * Returns BW current Version
     *
     * @return string
     */
    static function get_version(){

        return self::$version ;

    }


    /**
     * Used for accessing plugin directory URL
     *
     * @param string $address
     *
     * @return string
     */
    public static function dir_url( $address = '' ){

        return plugin_dir_url( __FILE__ ) . $address;

    }


    /**
     * Used for accessing plugin directory path
     *
     * @param string $address
     *
     * @return string
     */
    public static function dir_path( $address = '' ){

        return plugin_dir_path( __FILE__ ) . $address;

    }


    /**
     * Clears BF transients for avoiding of happening any problem
     */
    function plugin_activation(){

        delete_transient( '__better_framework__widgets_css' );
        delete_transient( '__better_framework__panel_css' );
        delete_transient( '__better_framework__menu_css' );
        delete_transient( '__better_framework__terms_css' );
        delete_transient( '__better_framework__final_fe_css' );
        delete_transient( '__better_framework__final_fe_css_version' );
        delete_transient( '__better_framework__backend_css' );

    }


    /**
     * Adds included BetterFramework to loader
     *
     * @param $frameworks
     * @return array
     */
    function better_framework_loader( $frameworks ){

        $frameworks[] = array(
            'version'   =>  '2.2.0',
            'path'      =>  self::dir_path( 'includes/libs/better-framework/' ),
            'uri'       =>  self::dir_url( 'includes/libs/better-framework/' ),
        );

        return $frameworks;

    }


    /**
     * activate BF needed sections
     *
     * @param $sections
     * @return mixed
     */
    function better_framework_sections( $sections ){

        $sections['vc-extender'] = true;

        return $sections;

    }


    /**
     *  Init the plugin
     */
    function init(){

        require_once 'includes/generator/class-bw-generator-factory.php';
        BW_Generator_Factory::generator();

        add_action( 'wp_ajax_nopriv_bw_ajax', array( $this, 'ajax_callback' ) );
        add_action( 'wp_ajax_bw_ajax', array( $this, 'ajax_callback' ) );

    }



    /**
     * Used for retrieving options simply and safely for next versions
     *
     * @param $option_key
     * @return mixed|null
     */
    public static function get_option( $option_key ){

        return bf_get_option( $option_key, self::$panel_id );

    }


    /**
     * Setups Shortcodes
     *
     * @param $shortcodes
     */
    function setup_shortcodes( $shortcodes ){

        require_once self::dir_path() . 'includes/shortcodes/class-better-weather-shortcode.php';
        require_once self::dir_path() . 'includes/widgets/class-better-weather-widget.php';
        $shortcodes['BetterWeather'] = array(
            'shortcode_class'   =>  'Better_Weather_Shortcode',
            'widget_class'      =>  'Better_Weather_Widget',
        );


        require_once self::dir_path() . 'includes/shortcodes/class-better-weather-inline-shortcode.php';
        require_once self::dir_path() . 'includes/widgets/class-better-weather-inline-widget.php';
        $shortcodes['BetterWeather-inline'] = array(
            'shortcode_class'   =>  'Better_Weather_Inline_Shortcode',
            'widget_class'      =>  'Better_Weather_Inline_Widget',
        );

        return $shortcodes;
    }


    /**
     * Used for cutting Forecast.io data to smaller size for performance issues
     *
     * @param $today_data
     * @param $past_day_data
     * @return array
     */
    function create_result_data( $today_data , $past_day_data ){

        $result = array();

        $result['latitude'] = $today_data->latitude;
        $result['longitude'] = $today_data->longitude;
        $result['timezone'] = $today_data->timezone;
        $result['currently'] = $today_data->currently;

        // temperatureMin
        if(isset($past_day_data->temperatureMin))
            $result['currently']->temperatureMin = $past_day_data->temperatureMin;
        else
            $result['currently']->temperatureMin = __( 'NA', 'better-studio' );

        // temperatureMin
        if(isset($past_day_data->temperatureMax))
            $result['currently']->temperatureMax = $past_day_data->temperatureMax;
        else
            $result['currently']->temperatureMax = __( 'NA', 'better-studio' );

        // sunriseTime
        if(isset($past_day_data->sunriseTime))
            $result['currently']->sunriseTime = $past_day_data->sunriseTime ;
        else
            $result['currently']->sunriseTime = __( 'NA', 'better-studio' );

        // sunsetTime
        if(isset($past_day_data->sunsetTime))
            $result['currently']->sunsetTime = $past_day_data->sunsetTime ;
        else
            $result['currently']->sunsetTime = __( 'NA', 'better-studio' );

        $counter = -1;

        foreach ( $today_data->daily->data as $day){

            if($counter == -1){
                $counter++;
                continue;
            }

            if($counter > 4)
                break;
            else
                $counter++;

            $result['daily'][$counter] = array(
                'dayName'  =>  date('D', $day->time ),
                'time'  =>  $day->time,
                'icon'  =>  $day->icon
            );
        }

        return $result;
    }


    /**
     * Used for finding current user IP and Geo Location Data
     *
     * @return bool|string
     */
    function get_user_geo_location(){

        // get user info's by ip
        if( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ){
            $user_ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ){
            $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $user_ip = $_SERVER['REMOTE_ADDR'];
        }

        // return false in local hosts
        if( $user_ip == '127.0.0.1' ){
            return false;
        }

        $user_geo_location = wp_remote_get( "http://bw-api.better-studio.net/get-geo.php?ip=" . $user_ip, array( 'timeout' => 10 ) );

        if( is_wp_error( $user_geo_location ) || ! isset( $user_geo_location['body'] ) || $user_geo_location['body'] == FALSE ){
            return false;
        }

        $user_geo_location = json_decode( $user_geo_location['body'] );

        if( $user_geo_location->statusCode != 'OK' )
            return false;

        return $user_geo_location->latitude . ',' . $user_geo_location->longitude;

    }


    /**
     * Retrieved data from Forecast.io or cache and return it
     *
     * Action Callback: wp_ajax
     *
     * @return string
     */
    function ajax_callback(){

        // Checks API Key
        if( isset( $_POST["apikey"] ) && $_POST["apikey"] != "" && $_POST["apikey"] != "false" ){
            $apikey = $_POST["apikey"];
        }else{
            echo json_encode(
                array(
                    'status'	=> 'error',
                    'msg'  	    => __( 'Better Weather Error: No API Key provided! Obtain API Key from https://developers.forecast.io/', 'better-studio' ),
                    'data'      => 'no data'
                )
            );
            die();
        }

        // Check location
        if( isset( $_POST["location"] ) && $_POST["location"] != "" ){
            $location = $_POST["location"];
        }else{
            $location = "35.6705,139.7409";
        }

        // If visitor location
        if( isset( $_POST["visitor_location"] ) && $_POST["visitor_location"] ){
            $visitor_location = TRUE;
            $_l = $this->get_user_geo_location();

            if( ! is_bool( $_l ) )
                $location = $_l;

        }else{
            $visitor_location = FALSE;
        }

        // Pretty name used for caching
        $pretty_location_name = str_replace(
            array( ".", "/", "\\", ",", " " ) ,
            "" ,
            trim( $location )
        );

        // If cache is older than 30min, get new data or error if triggered
        if( ( $data = get_transient( 'bw_location_' . $pretty_location_name ) ) === FALSE || $visitor_location == TRUE ){

            // retrieving Today content
            $today_data = wp_remote_get( "https://api.forecast.io/forecast/$apikey/$location?exclude=hourly,flags,alerts,minutely" );

            if( is_wp_error($today_data) || ! isset($today_data['body']) || $today_data['body'] == FALSE ){
                echo json_encode(
                    array(
                        'status'	=>  'error',
                        'msg'  	    =>  __( 'BetterWeather Error: No any data received from Forecast.io!.', 'better-studio' ),
                        'data'      =>  $today_data
                    )
                );
                die();
            }

            if ( $today_data['body'] == "Forbidden" ) {
                echo json_encode(
                    array(
                        'status'	=>  'error',
                        'msg'  	    =>  __( 'Better Weather Error: Provided API key is incorrect!.', 'better-studio' ),
                        'data'      =>  __( 'no data', 'better-studio' )
                    )
                );
                die();
            }

            $today_data = json_decode( $today_data['body'] ) ;

            // hack for getting today min/max temperature and sunset sunrise time!
            if( date('Y M d', $today_data->daily->data[0]->time ) == date('Y M d', $today_data->currently->time ) ){
                $past_day_data = $today_data->daily->data[0];
            }else{
                $past_day_data = wp_remote_get("https://api.forecast.io/forecast/$apikey/$location," . strtotime( "-1 day", time() ) . '?exclude=currently,hourly,flags,alerts,minutely');
                $past_day_data = json_decode( $past_day_data['body'] );
                $past_day_data = $past_day_data->daily->data[0];
            }

            $data = $this->create_result_data( $today_data , $past_day_data );

            if( $visitor_location == FALSE )
                set_transient( 'bw_location_' . $pretty_location_name, $data, MINUTE_IN_SECONDS * self::get_option( 'cache_time' ) );

        }

        echo json_encode(
            array(
                'status'	=>  'succeed',
                'msg'  	    =>  __( 'Data retrieved successfully.', 'better-studio' ),
                'data'      =>  $data
            )
        );

        die();

    }


    /**
     * Register BetterWeather VisualComposer support
     */
    function register_vc_support(){

        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            return;
        }

        // Visual composer widget
        vc_map(
            array(
                "name"              =>  __( "BetterWeather Widget", 'better-studio' ),
                "base"              =>  "BetterWeather",
                "class"             =>  "",
                "controls"          =>  "full",
                "icon"              => self::dir_url() . 'includes/assets/img/logo.png',
                "category"          =>  __( 'Content', 'better-studio' ),
                'admin_enqueue_css' =>  self::dir_url() . 'includes/assets/css/vc-style.css',
                "params"            => array(
                    array(
                        "type"          =>  "textfield",
                        "heading"       =>  __( "Location", 'better-studio' ),
                        "admin_label"   =>  true,
                        "param_name"    =>  "location",
                        "value"         =>  "35.6705,139.7409",
                        "description"   =>  __( "Enter location ( latitude,longitude ) for showing forecast.", 'better-studio' ) .'<br>'. '<a target="_blank" href="http://better-studio.net/plugins/better-weather/stand-alone/#how-to-find-location">' . __("How to find location values!?", 'better-studio') .'</a>'
                    ),
                    array(
                        "type"          =>  "textfield",
                        "heading"       =>  __( "Location Custom Name", 'better-studio' ),
                        "param_name"    =>  "location_name",
                        "admin_label"   =>  true,
                        "value"         =>  "",
                    ),
                    array(
                        'type'          => 'dropdown',
                        'heading'       => __( 'Show Location Name?', 'better-studio' ),
                        'param_name'    => 'show_location',
                        'value'         => array(
                            __( 'Yes', 'better-studio' )  => 'on',
                            __( 'No', 'better-studio' ) => 'off',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Show Date?', 'better-studio' ),
                        'param_name'    =>  'show_date',
                        'value'         =>  array(
                            __( 'Yes', 'better-studio' )  => 'on',
                            __( 'No', 'better-studio' ) => 'off',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Widget Style', 'better-studio' ),
                        'param_name'    =>  'style',
                        "admin_label"   =>  true,
                        'value'         => array(
                            __( 'Modern Style', 'better-studio' ) => 'modern',
                            __( 'Normal Style', 'better-studio' ) => 'normal',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Show next 4 days forecast!?', 'better-studio' ),
                        'param_name'    =>  'next_days',
                        'value'         =>  array(
                            __( 'Yes', 'better-studio' ) => 'on',
                            __( 'No', 'better-studio' )  => 'off',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Background Style', 'better-studio' ),
                        'param_name'    =>  'bg_type',
                        "admin_label"   =>  true,
                        'value'         =>  array(
                            __( 'Natural Photo', 'better-studio' ) => 'natural',
                            __( 'Static Color', 'better-studio' )  => 'static',
                        ),
                    ),
                    array(
                        "type"          =>  "colorpicker",
                        "holder"        =>  "div",
                        "class"         =>  "",
                        "heading"       =>  __( "Background Color", 'better-studio' ),
                        "param_name"    =>  "bg_color",
                        "value"         =>  '#4f4f4f',
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Icons Style', 'better-studio' ),
                        'param_name'    =>  'icons_type',
                        'value'         => array(
                            __( 'Animated Icons', 'better-studio' ) => 'animated',
                            __( 'Static Icons', 'better-studio' )  => 'static',
                        ),
                    ),
                    array(
                        "type"          =>  "colorpicker",
                        "holder"        =>  "div",
                        "class"         =>  "",
                        "heading"       =>  __( "Font Color", 'better-studio' ),
                        "param_name"    =>  "font_color",
                        "value"         =>  '#fff',
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Temperature Unit', 'better-studio' ),
                        'param_name'    =>  'unit',
                        'value'         =>  array(
                            __( 'Celsius', 'better-studio' ) => 'C',
                            __( 'Fahrenheit', 'better-studio' )  => 'F',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Show Temperature Unit In Widget!?', 'better-studio' ),
                        'param_name'    =>  'show_unit',
                        'value'         => array(
                            __( 'No', 'better-studio' ) => 'off',
                            __( 'Yes', 'better-studio' )  => 'on',
                        ),
                    ),
                    array(
                        'type'          => 'dropdown',
                        'heading'       => __( 'Auto detect user location via IP!?', 'better-studio' ),
                        'param_name'    => 'visitor_location',
                        'value'         => array(
                            __( 'No', 'better-studio' )  => 'off',
                            __( 'Yes', 'better-studio' ) => 'on',
                        ),
                        "description" => __( 'Before using this you must read <a target="_blank" href="http://better-studio.net/plugins/better-weather/wp/#requests-note">this note</a>.', 'better-studio' ),
                    ),
                )
            )
        );

        // Visual composer inline
        vc_map(
            array(
                "name"              => __( "BetterWeather Inline", 'better-studio' ),
                "base"              => "BetterWeather-inline",
                "class"             => "",
                "controls"          => "full",
                "icon"              => self::dir_url() . 'includes/assets/img/logo.png',
                "category"          => __( 'Content', 'better-studio' ),
                'admin_enqueue_css' => self::dir_url() . 'includes/assets/css/vc-style.css',
                "params"            => array(
                    array(
                        "type"          =>  "textfield",
                        "holder"        =>  "div",
                        "class"         =>  "",
                        "heading"       =>  __( "Location:", 'better-studio' ),
                        "param_name"    =>  "location",
                        "value"         =>  "35.6705,139.7409",
                        "description"   =>  __( "Enter location ( latitude,longitude ) for showing forecast.", 'better-studio' ) .'<br>'. '<a target="_blank" href="http://better-studio.net/plugins/better-weather/stand-alone/#how-to-find-location">' . __("How to find location values!?", 'better-studio') .'</a>'
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Inline Size:', 'better-studio' ),
                        'param_name'    =>  'inline_size',
                        'value'         =>  array(
                            __( 'Large', 'better-studio' ) => 'large',
                            __( 'medium', 'better-studio' )  => 'medium',
                            __( 'small', 'better-studio' )  => 'small',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Icons Style:', 'better-studio' ),
                        'param_name'    =>  'icons_type',
                        'value'         =>  array(
                            __( 'Animated Icons', 'better-studio' ) => 'animated',
                            __( 'Static Icons', 'better-studio' )  => 'static',
                        ),
                    ),
                    array(
                        "type"          =>  "colorpicker",
                        "holder"        =>  "div",
                        "class"         =>  "",
                        "heading"       =>  __( "Font Color:", 'better-studio' ),
                        "param_name"    =>  "font_color",
                        "value"         =>  '#fff'
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Temperature Unit', 'better-studio' ),
                        'param_name'    =>  'unit',
                        'value'         =>  array(
                            __( 'Celsius', 'better-studio' ) => 'C',
                            __( 'Fahrenheit', 'better-studio' )  => 'F',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Show Temperature Unit In Widget!?', 'better-studio' ),
                        'param_name'    =>  'show_unit',
                        'value'         =>  array(
                            __( 'No', 'better-studio' ) => 'off',
                            __( 'Yes', 'better-studio' )  => 'on',
                        ),
                    ),
                    array(
                        'type'          =>  'dropdown',
                        'heading'       =>  __( 'Auto detect user location via IP!?', 'better-studio' ),
                        'param_name'    =>  'visitor_location',
                        'value'         =>  array(
                            __( 'No', 'better-studio' )  => 'off',
                            __( 'Yes', 'better-studio' ) => 'on',
                        ),
                        "description"   =>  __( "Please note Forecast.io free accounts API calls per day is just 1000 and with enabling autodetect location you must do some pay to Forecast.io for calls over 1000!", 'better-studio' )
                    ),
                )
            )
        );
    }


    /**
     * return api key that saved in option panel
     * @return string|bool
     */
    static function get_API_Key(){

        return self::get_option( 'api_key' );

    }



    /**
     * Clears all cache inside data base
     *
     * Callback
     *
     * @return array
     */
    public static function clear_cache_all(){

        // don't print any error or notice!
        ob_start();

        // Delete all pages css transients
        global $wpdb;
        $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->options WHERE meta_key LIKE %s", 'bw_location_%' ) );

        ob_end_clean();

        return array(
            'status'  => 'succeed',
            'msg'	  => __( 'All Caches was cleaned.', 'better-studio' ),
        );

    }



    /**
     * Filter callback: Used for changing current language on importing translation panel data
     *
     * @param $result
     * @param $data
     * @param $args
     * @return
     */
    function callback_panel_import_result( $result, $data, $args ){

        // check panel
        if( $args['panel-id'] != self::$panel_id ){
            return $result;
        }

        // change messages
        if( $result['status'] == 'succeed' ){
            $result['msg'] = __( 'BetterWeather options imported successfully.', 'better-studio' );
        }else{
            if( $result['msg'] == __( 'Imported data is not for this panel.', 'better-studio' ) ){
                $result['msg'] = __( 'Imported data is not for BetterWeather.', 'better-studio' );
            }else{
                $result['msg'] = __( 'An error occurred while importing options.', 'better-studio' );
            }
        }

        return $result;
    }


    /**
     * Filter callback: Used for resetting current language on resetting panel
     *
     * @param $options
     * @param $result
     * @return
     */
    function callback_panel_reset_result( $result, $options ){

        // check panel
        if( $options['id'] != self::$panel_id ){
            return $result;
        }

        // change messages
        if( $result['status'] == 'succeed' ){
            $result['msg'] = __( 'BetterWeather options reset to default.', 'better-studio' );
        }else{
            $result['msg'] = __( 'An error occurred while resetting options.', 'better-studio' );
        }

        return $result;
    }

}

// Check if Visual Composer is installed
if( defined( 'WPB_VC_VERSION' ) ) {

    if( ! class_exists( "WPBakeryShortCode" ) ){
        class WPBakeryShortCode{

        }
    }

    /**
     * Wrapper for WPBakeryShortCode Class for handling editor
     */
    class Better_Weather_VC_Shortcode_Extender extends WPBakeryShortCode{

        function __construct( $settings ){

            // Base BF Class For Styling
            if( isset( $settings['class'] ) ){
                $settings['class'] .= ' bf-vc-field';
            }else{
                $settings['class'] = 'bf-vc-field';
            }

            // Height Class For Styling
            if( isset( $settings['wrapper_height'] ) ){

                if( $settings['wrapper_height'] == 'full' ){
                    $settings['class'] .= ' bf-full-height';
                }

            }

            parent::__construct( $settings );
        }

        /**
         * Prints out the styles needed to render the element icon for the back end interface.
         * Only performed if the 'icon' setting is a valid URL.
         */
        public function printIconStyles() {

            if ( ! filter_var( $this->settings( 'icon' ), FILTER_VALIDATE_URL ) ) {
                return;
            }

            echo "
            <style>
                .wpb_content_element[data-element_type='" . esc_attr( $this->settings['base'] ) . "'] .wpb_element_wrapper,
                .vc_shortcodes_container[data-element_type='" . esc_attr( $this->settings['base'] ) . "'] {
                    background-image: url(" . esc_url( $this->settings['icon']  ) . ") ;
                }
                .wpb-content-layouts .wpb-layout-element-button[data-element='" . esc_attr( $this->settings['icon'] ) . "'] .vc-element-icon {
                    background-image: url(" . esc_url( $this->settings['icon']  ) . ");
                }
                #" . $this->settings['base'] . " .vc-element-icon{
                    background-image: url(" . esc_url( $this->settings['icon']  ) . ") ;
                }
                li[data-element=" . $this->settings['base'] . "]{
                    background-color: #F9FDFF !important;
                    border-color: #9cd4eb !important;
                }
            </style>";
        }
    }
}