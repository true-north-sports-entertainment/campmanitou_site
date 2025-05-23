<?php

/**
 * Better Weather Inline Shortcode
 */
class Better_Weather_Inline_Shortcode extends BF_Shortcode{

    function __construct( $id, $options ){

        $id = 'BetterWeather-inline';

        $_options = array(
            'defaults' => array(
                'location'          =>  '',
                'visitor_location'  =>  false,
                'font_color'        =>  '#fff',
                'icons_type'        =>  'animated',
                'inline_size'       =>  'medium',
                "unit"              =>  'C',
                "show_unit"         =>  false,
                "mode"              =>  'inline' ,
            ),

            'have_widget'       => true,
            'have_vc_add_on'    => false,
        );

        $_options = wp_parse_args( $_options, $options );

        parent::__construct( $id, $_options );

    }


    /**
     * Handle displaying of shortcode
     *
     * @param array $atts
     * @param string $content
     * @return string
     */
    function display( array $atts  , $content = '' ){

        $options = array(
            "location"          =>  isset( $atts['location'] ) ? $atts['location'] : '' ,
            "fontColor"         =>  isset( $atts['font_color'] ) ? $atts['font_color'] : '#fff' ,
            "visitorLocation"   =>  isset( $atts['visitor_location'] ) ? $atts['visitor_location'] : false ,
            "inlineSize"        =>  isset( $atts['inline_size'] ) ? $atts['inline_size'] : 'medium' ,
            "unit"              =>  isset( $atts['unit'] ) ? $atts['unit'] : 'C' ,
            "iconsType"         =>  isset( $atts['icons_type'] ) ? $atts['icons_type'] : 'animated' ,
            "showUnit"          =>  isset( $atts['show_unit'] ) ? $atts['show_unit'] : 'off',
            "mode"              =>  'inline' ,
        );

        $options['visitorLocation'] = $options['visitorLocation'] == 'on' ? true : false;

        $options['showUnit'] = $options['showUnit'] == 'on' ? true : false;

        if( $options['iconsType'] == 'static' ){
            $options['animatedIcons'] = false;
        }

        return BW_Generator_Factory::generator()->generate( $options , false );

    }
}