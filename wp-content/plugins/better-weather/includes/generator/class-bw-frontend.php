<?php

/**
 * Generate all front end codes for better weather
 *
 * IMPORTANT NOTE: Do not create directly instance from this class! just use BW_Generator_Factory factory for getting instance
 */
class BW_Frontend {


    /**
     * Stores all widgets
     * @var array
     */
    var $widgets = array();


    function init(){

        add_action( 'wp_enqueue_scripts' , array( $this , 'register_assets' ) , 9 );
        add_action( 'wp_enqueue_scripts' , array( $this , 'enqueue_assets' ) , 11 );

    }


    /**
     * Before enqueue register frontend assets for ability to change the assets outside of plugin
     */
    function register_assets(){

        wp_register_script( 'skycons', Better_Weather::dir_url() . 'includes/libs/better-weather/js/skycons.js', array( 'jquery' ), Better_Weather::get_version(), true );

        wp_register_script( 'better-weather', Better_Weather::dir_url() . 'includes/libs/better-weather/js/betterweather.min.js', array( 'jquery', 'skycons' ), Better_Weather::get_version(), true );

        wp_register_script( 'better-weather-widgets', Better_Weather::dir_url() . 'includes/assets/js/better-weather-widgets.js', array( 'jquery', 'skycons', 'better-weather' ), Better_Weather::get_version(), true );

        wp_register_style( 'better-weather', Better_Weather::dir_url() . 'includes/libs/better-weather/css/bw-style.min.css', array(), Better_Weather::get_version() );

    }


    /**
     * Enqueue styles and scripts that before registered
     */
    function enqueue_assets(){

        Better_Framework::assets_manager()->enqueue_script( 'element-query' );

        wp_enqueue_script( 'better-weather-widgets' );

        wp_enqueue_style( 'better-weather' );

        $local_texts = array(
            "url"       =>  admin_url( 'admin-ajax.php' ),
            "action"    =>  'bw_ajax',
            "apiKey"    =>  Better_Weather::get_API_Key() ,
            "monthList" =>  array(
                'January'       =>  Better_Weather::get_option( 'tr_month_january' ),
                'February'      =>  Better_Weather::get_option( 'tr_month_february' ),
                'March'         =>  Better_Weather::get_option( 'tr_month_march' ),
                'April'         =>  Better_Weather::get_option( 'tr_month_april' ),
                'May'           =>  Better_Weather::get_option( 'tr_month_may' ),
                'June'          =>  Better_Weather::get_option( 'tr_month_june' ),
                'July'          =>  Better_Weather::get_option( 'tr_month_july' ),
                'August'        =>  Better_Weather::get_option( 'tr_month_august' ),
                'September'     =>  Better_Weather::get_option( 'tr_month_september' ),
                'October'       =>  Better_Weather::get_option( 'tr_month_october' ),
                'November'      =>  Better_Weather::get_option( 'tr_month_november' ),
                'December'      =>  Better_Weather::get_option( 'tr_month_december' ),
            ),
            "daysList"  =>  array(
                'Sat'           =>  Better_Weather::get_option( 'tr_days_sat' ),
                'Sun'           =>  Better_Weather::get_option( 'tr_days_sun' ),
                'Mon'           =>  Better_Weather::get_option( 'tr_days_mon' ),
                'Tue'           =>  Better_Weather::get_option( 'tr_days_tue' ),
                'Wed'           =>  Better_Weather::get_option( 'tr_days_wed' ),
                'Thu'           =>  Better_Weather::get_option( 'tr_days_thu' ),
                'Fri'           =>  Better_Weather::get_option( 'tr_days_fri' ),
            ),
            "stateList" =>  array(
                'clear'                     =>  Better_Weather::get_option( 'tr_forecast_clear' ),
                'rain'                      =>  Better_Weather::get_option( 'tr_forecast_rain' ),
                'light_rain'                =>  Better_Weather::get_option( 'tr_forecast_light_rain' ),
                'drizzle'                   =>  Better_Weather::get_option( 'tr_forecast_drizzle' ),
                'light_rain_and_windy'      =>  Better_Weather::get_option( 'tr_forecast_light_rain_and_windy' ),
                'cloudy'                    =>  Better_Weather::get_option( 'tr_forecast_cloudy' ),
                'mostly_cloudy'             =>  Better_Weather::get_option( 'tr_forecast_mostly_cloudy' ),
                'partly_cloudy'             =>  Better_Weather::get_option( 'tr_forecast_partly_cloudy' ),
                'snow'                      =>  Better_Weather::get_option( 'tr_forecast_snow' ),
                'light_snow'                =>  Better_Weather::get_option( 'tr_forecast_light_snow' ),
                'snow_and_breezy'           =>  Better_Weather::get_option( 'tr_forecast_snow_and_breezy' ),
                'snow_and_windy'            =>  Better_Weather::get_option( 'tr_forecast_snow_and_windy' ),
                'sleet'                     =>  Better_Weather::get_option( 'tr_forecast_sleet' ),
                'wind'                      =>  Better_Weather::get_option( 'tr_forecast_wind' ),
                'foggy'                     =>  Better_Weather::get_option( 'tr_forecast_foggy' ),
                'thunderstorm'              =>  Better_Weather::get_option( 'tr_forecast_thunderstorm' ),
                'overcast'                  =>  Better_Weather::get_option( 'tr_forecast_overcast' ),
                'overcast_df'               =>  Better_Weather::get_option( 'tr_forecast_overcast_df' ),
                'breezy_and_Partly_Cloudy'  =>  Better_Weather::get_option( 'tr_forecast_breezy_and_partly_cloudy' ),
                'breezy_and_mostly_cloudy'  =>  Better_Weather::get_option( 'tr_forecast_breezy_and_mostly_cloudy' ),
                'humid_and_mostly_cloudy'   =>  Better_Weather::get_option( 'tr_forecast_humid_and_mostly_cloudy' ),
                'windy_and_mostly_cloudy'   =>  Better_Weather::get_option( 'tr_forecast_windy_and_mostly_cloudy' ),
                'breezy_and_overcast'       =>  Better_Weather::get_option( 'tr_forecast_breezy_and_overcast' ),
                'flurries'                  =>  Better_Weather::get_option( 'tr_forecast_flurries' ),
                'flurries_df'               =>  Better_Weather::get_option( 'tr_forecast_flurries_df' ),
                'dry_and_partly_cloudy'     =>  Better_Weather::get_option( 'tr_forecast_dry_and_partly_cloudy' ),
                'dry_and_partly_cloudy_df'  =>  Better_Weather::get_option( 'tr_forecast_dry_and_partly_cloudy_df' ),
                'dry_and_mostly_cloudy'     =>  Better_Weather::get_option( 'tr_forecast_dry_and_mostly_cloudy' ),
                'dry_and_mostly_cloudy_df'  =>  Better_Weather::get_option( 'tr_forecast_dry_and_mostly_cloudy_df' ),
            )
        );

        wp_localize_script( 'better-weather' , 'BW_Localized' , $local_texts );

    }


    /**
     * Used for generating HTML attribute string
     *
     * @param string $id
     * @param string $val
     * @return string
     */
    private function html_attr( $id ='' , $val='' ){

        if( is_bool( $val ) ){

            if( $val )
                $val = "true";
            else
                $val = "false";

        }

        return 'data-' . $id . '="' . $val . '" ';
    }


    /**
     * Generate widget
     *
     * @param $options
     * @param bool $echo
     * @return mixed|void
     */
    function generate( $options , $echo = true){

        $id = $this->get_unique_id();
        $this->widgets[$id] = $options;

        $output = '<';

        if( isset( $options['mode'] ) && $options['mode']=='inline' ){
            $output .= 'span id="'. $id .'" class="better-weather-inline" ';
        }else{
            $output .= 'div id="'. $id .'" class="better-weather" ';
        }

        foreach ( (array) $options as $key => $value ){
            $output .= $this->html_attr( $key , $value );
        }

        if( isset( $options['mode'] ) && $options['mode']=='inline' ){
            $output .= '></span>';
        }else{
            $output .= '></div>';
        }

        if( $echo )
            echo $output;
        else
            return $output;
    }


    /**
     * Generate unique id widgets
     *
     * @return string
     */
    function get_unique_id(){

        return 'bw-'. uniqid();

    }

}