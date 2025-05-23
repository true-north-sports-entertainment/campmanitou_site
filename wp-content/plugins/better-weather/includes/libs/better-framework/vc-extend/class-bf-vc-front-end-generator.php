<?php

class BF_VC_Front_End_Generator extends BF_Admin_Fields{

    /**
     * Holds Items Array
     *
     * @since 1.0
     * @access public
     * @var array|null
     */
    public $item;

    /**
     * Panel ID
     *
     * @since 1.0
     * @access public
     * @var string
     */
    public $id;

    /**
     * Panel Values
     *
     * @since 1.0
     * @access public
     * @var array
     */
    public $values;

    /**
     * Constructor Function
     *
     * @param array     $item   Contain details of one field
     * @param $id
     *
     * @since 1.0
     * @access public
     * @return \BF_VC_Front_End_Generator
     */
    public function __construct( array &$item, &$id){

        // Parent Constructor
        $generator_options = array(
            'fields_dir'	=>	 BF_PATH . 'vc-extend/fields/',
            'templates_dir' => BF_PATH . 'vc-extend/templates/'
        );

        $this->supported_fields[] = 'vc-image_radio';
        $this->supported_fields[] = 'vc-media_image';
        $this->supported_fields[] = 'vc-switchery';
        $this->supported_fields[] = 'vc-sorter_checkbox';
        $this->supported_fields[] = 'vc-info';

        parent::__construct( $generator_options );

        $this->item  = $item;

        $this->id	  = $id;
    }


    /**
     * Display HTML output of panel array
     *
     * Display full html of panel array which is defined in object parameter
     *
     * @since 1.0
     * @access public
     * @return string
     */
    public function get_field(  ){

        $output	 = '';

        $field = $this->item;

        if( ! isset( $field['value'] ) && isset( $field['std'] )){
            $field['value'] = $field['std'];
        }

        $output .= $this->section(
            call_user_func(
                array( $this, $field['type'] ),
                $field
            ),
            $field
        );

        return $output;
    }
}