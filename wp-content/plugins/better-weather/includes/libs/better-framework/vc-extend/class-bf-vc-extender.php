<?php

/**
 * Initialize custom functionality to VC
 */
class BF_VC_Extender {


    function __construct(){

        require_once BF_PATH . 'vc-extend/class-bf-vc-shortcode-extender.php';

        require_once BF_PATH . 'vc-extend/class-bf-vc-front-end-generator.php';

        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            return;
        }

        add_shortcode_param( 'bf_select',            array( $this, 'select_param' ) );

        add_shortcode_param( 'bf_color',             array( $this, 'color_param' ) );

        add_shortcode_param( 'bf_background_image',  array( $this, 'background_image_param' ) );

        add_shortcode_param( 'bf_media_image',       array( $this, 'media_image_param' ) );

        add_shortcode_param( 'bf_image_radio',       array( $this, 'image_radio' ) );

        add_shortcode_param( 'bf_info',              array( $this, 'info' ) );

        add_shortcode_param( 'bf_slider',            array( $this, 'slider_param' ) );

        add_shortcode_param( 'bf_sorter_checkbox',   array( $this, 'sorter_checkbox_param' ) );

        add_shortcode_param( 'bf_switchery',         array( $this, 'switchery' ) );

        add_shortcode_param( 'bf_ajax_select',       array( $this, 'ajax_param' ) );

        add_shortcode_param( 'bf_icon_select',       array( $this, 'icon_select_param' ));

        add_shortcode_param( 'bf_heading',           array( $this, 'heading_param' ));

    }


    /**
     * Convert VC Field option to an BF Field Option
     *
     * @param $settings
     * @param $value
     * @return array
     */
    private function convert_field_option( $settings, $value ){

        $options = array(
            'name'          =>  $settings['heading'],
            'id'            =>  $settings['param_name'],
            'input_name'    =>  $settings['param_name'],
            'value'         =>  $value,
            'input_class'   =>  "wpb_vc_param_value wpb-" . $settings['type'] . " " . $settings['param_name'] . ' ' . $settings['type'] . "_field",
        );

        if( isset( $settings['description'] ) )
            $options['desc'] = $settings['description'];

        return $options;
    }


    /**
     * Adds BF Image Radio Field to Visual Composer
     *
     * @param $settings
     * @param $value
     * @return string
     */
    function image_radio( $settings, $value ){

        $options = $this->convert_field_option( $settings, $value );

        $options['type'] = 'vc-image_radio';

        $options['options'] = $settings['options'];

        if( isset( $settings['section_class'] ) )
            $options['section_class'] = $settings['section_class'];

        $generator = new BF_VC_Front_End_Generator( $options, $settings['param_name'] );

        return $generator->get_field();
    }


    /**
     * Adds BF Info Field to Visual Composer
     *
     * @param $settings
     * @param $value
     * @return string
     */
    function info( $settings, $value ){

        $options = $this->convert_field_option( $settings, $value );

        $options['type'] = 'vc-info';

        if( isset( $settings['section_class'] ) )
            $options['section_class'] = $settings['section_class'];

        if( isset( $settings['state'] ) )
            $options['state'] = $settings['state'];

        if( isset( $settings['info-type'] ) )
            $options['info-type'] = $settings['info-type'];

        $generator = new BF_VC_Front_End_Generator( $options, $settings['param_name'] );

        return $generator->get_field();
    }


    /**
     * Adds BF Image Radio Field to Visual Composer
     *
     * @param $settings
     * @param $value
     * @return string
     */
    function switchery( $settings, $value ){

        $options = $this->convert_field_option( $settings, $value );

        $options['type'] = 'vc-switchery';

        $generator = new BF_VC_Front_End_Generator( $options, $settings['param_name'] );

        return $generator->get_field();
    }


    /**
     * Adds BF Color field to Visual Composer
     *
     * @param $settings
     * @param $value
     * @return string
     */
    function color_param( $settings, $value ){

        $options = $this->convert_field_option( $settings, $value );

        $options['type'] = 'color';

        $generator = new BF_VC_Front_End_Generator( $options, $settings['param_name'] );

        return $generator->get_field();
    }


    /**
     * Adds BF Select field to Visual Composer
     *
     * @param $settings
     * @param $value
     * @return string
     */
    function select_param( $settings, $value ){

        $options = $this->convert_field_option( $settings, $value );

        $options['options'] = $settings['options'];
        $options['type']    = 'select';

        if( isset( $settings['multiple'] ) )
            $options['multiple'] = $settings['multiple'];

        $generator = new BF_VC_Front_End_Generator( $options, $settings['param_name'] );

        return $generator->get_field();
    }


    /**
     * Adds BF Ajax field to Visual Composer
     *
     * @param $settings
     * @param $value
     * @return string
     */
    function ajax_param( $settings, $value ){

        $options = $this->convert_field_option( $settings, $value );

        $options['type'] = 'ajax_select';

        $options['callback'] = $settings['callback'];

        $options['get_name'] = $settings['get_name'];

        if( isset( $settings['placeholder'] ) )
            $options['placeholder'] = $settings['placeholder'];

        $generator = new BF_VC_Front_End_Generator( $options, $settings['param_name'] );

        return $generator->get_field();
    }


    /**
     * Adds BF Background Image field to Visual Composer
     *
     * @param $settings
     * @param $value
     * @return string
     */
    function background_image_param( $settings, $value ){

        $options = $this->convert_field_option( $settings, $value );

        $options['type'] = 'background_image';

        if( isset( $settings['media_title'] ) )
            $options['media_title'] = $settings['media_title'];

        if( isset( $settings['button_text'] ) )
            $options['button_text'] = $settings['button_text'];

        if( isset( $settings['upload_label'] ) )
            $options['upload_label'] = $settings['upload_label'];

        if( isset( $settings['remove_label'] ) )
            $options['remove_label'] = $settings['remove_label'];

        if( isset( $settings['section_class'] ) )
            $options['section_class'] = $settings['section_class'];

        $generator = new BF_VC_Front_End_Generator( $options, $value );

        return $generator->get_field();
    }


    /**
     * Adds BF Background Image field to Visual Composer
     *
     * @param $settings
     * @param $value
     * @return string
     */
    function media_image_param( $settings, $value ){

        $options = $this->convert_field_option( $settings, $value );

        $options['type'] = 'vc-media_image';

        if( isset( $settings['upload_label'] ) )
            $options['upload_label'] = $settings['upload_label'];

        if( isset( $settings['remove_label'] ) )
            $options['remove_label'] = $settings['remove_label'];

        if( isset( $settings['media_title'] ) )
            $options['media_title'] = $settings['media_title'];

        if( isset( $settings['media_button'] ) )
            $options['media_button'] = $settings['media_button'];

        if( isset( $settings['section_class'] ) )
            $options['section_class'] = $settings['section_class'];

        $generator = new BF_VC_Front_End_Generator( $options, $value );

        return $generator->get_field();
    }


    /**
     * Adds BF slider field to Visual Composer
     *
     * @param $settings
     * @param $value
     * @return string
     */
    function slider_param( $settings, $value ){

        $options = $this->convert_field_option( $settings, $value );

        $options['type'] = 'slider';

        if( isset( $settings['dimension'] ) )
            $options['dimension'] = $settings['dimension'];

        if( isset( $settings['min'] ) )
            $options['min'] = $settings['min'];

        if( isset( $settings['max'] ) )
            $options['max'] = $settings['max'];

        if( isset( $settings['step'] ) )
            $options['step'] = $settings['step'];

        $generator = new BF_VC_Front_End_Generator( $options, $value );

        return $generator->get_field();
    }


    /**
     * Adds BF slider field to Visual Composer
     *
     * @param $settings
     * @param $value
     * @return string
     */
    function sorter_checkbox_param( $settings, $value ){

        $options = $this->convert_field_option( $settings, $value );

        $options['type'] = 'vc-sorter_checkbox';

        $options['options'] = $settings['options'];

        if( isset( $settings['section_class'] ) )
            $options['section_class'] = $settings['section_class'];

        if( isset( $settings['value'] ) )
            $options['order'] = $settings['value'];

        $generator = new BF_VC_Front_End_Generator( $options, $value );

        return $generator->get_field();
    }


    /**
     * Adds BF Background Image field to Visual Composer
     *
     * @param $settings
     * @param $value
     * @return string
     */
    function icon_select_param( $settings, $value ){

        $options = $this->convert_field_option( $settings, $value );

        $options['type'] = 'icon_select';

        $generator = new BF_VC_Front_End_Generator( $options, $value );

        return $generator->get_field();
    }


    /**
     * Adds BF Heading field to Visual Composer
     *
     * @param $settings
     * @param $value
     * @return string
     */
    function heading_param( $settings, $value ){

        $options = $this->convert_field_option( $settings, $value );

        $options['type'] = 'heading';
        $options['title'] = $settings['title'];

        $generator = new BF_VC_Front_End_Generator( $options, $value );
        return $generator->get_field();
    }

}