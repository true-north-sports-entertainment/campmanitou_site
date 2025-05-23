<?php
/**
 * todo refactor this
 */
abstract class BF_Admin_Fields{

    /**
     * Holds All Field Generator Options
     *
     * @since 1.0
     * @access private
     * @var array
     */
    protected  $options = array();


    /**
     * Holds all fields
     *
     * @since 1.0
     * @access private
     * @var array
     */
    protected  $items = array();


    /**
     * Panel ID
     *
     * @since 1.0
     * @access public
     * @var string
     */
    protected $id;


    /**
     * Panel Values
     *
     * @since 1.0
     * @access public
     * @var array
     */
    protected $values;


    /**
     * Holds All Supported Fields
     *
     * @since 1.0
     * @access public
     * @var array
     */
    public $supported_fields = array(
        'text',
        'textarea',
        'wp_editor',
        'code',
        'color',
        'date',
        'slider',
        'radio',
        'checkbox',
        'switch',
        'repeater',
        'select',
        'ajax_select',
        'ajax_action',
        'sorter',
        'sorter_checkbox',
        'heading',
        'media',
        'background_image',
        'media_image',
        'image_upload',
        'image_checkbox',
        'image_radio',
        'image_select',
        'icon_select',
        'typography',
        'border',
        'export',
        'import',
        'info',
        'custom',
    );


    /**
     * Holds All Supported Fields in Repeater Field
     *
     * @since 1.4
     * @access public
     * @var array
     */
     public $supported_fields_in_repeater = array(
        'text',
        'textarea',
        'ajax_select',
        'image_radio',
        'image_upload',
        'color',
        'date',
        'select',
        'icon_select',
        'media',
        'checkbox',
        'media_image',
        'image_select',
        'switch',
        );

    /**
     * PHP Constructor Function
     *
     * defining class options with constructor function
     *
     * @param array $items
     *
*@internal param $ (array) $options fields options array
     *
     * @since 1.0
     * @access public
     * @return \BF_Admin_Fields
     */
    public function __construct( $items = array() ){

        bf_require_once( 'core/field-generator/class-bf-ajax-select-callbacks.php' );

        $default_options = array(
            'fields_dir'	=>	 dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'fields' . DIRECTORY_SEPARATOR,
            'modals_dir'	=>	 dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'modals' . DIRECTORY_SEPARATOR,
            'templates_dir'	=>	 dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR,
            'section-file' 	=> 	 dirname( __FILE__ ) . '/templates/default-fileld-template.php'
        );
        $this->options = array_merge( $default_options, $items );


        add_action( 'admin_footer', array( 'BF_Admin_Fields', 'enqueue_modals' ) );
    }


    /**
     * Setting object settings
     *
     * This class is for setting options
     *
     * @param (string)			   $option_name  	Name of option
     * @param (array|sting|bool)   $option_value 	Value of option
     *
     * @since 1.0
     * @access public
     * @return object
     */
    public function set( $option_name, $option_value ){
        $this->options[ $option_name ] = $option_value;
        return $this;
    }


    /**
     * Check if the panel has specific field
     *
     * @param (string) $type Field Type
     *
     * @since 1.0
     * @access public
     * @return bool
     */
    public function has_field( $field ){
        $has = false;
        foreach( $this->items as $item )
            if( @$item['type'] == $field )
                return true;

        return (bool) $has;
    }


    /**
     * Used for checking meta box have tab or not
     *
     * @return bool
     */
    public function has_tab(){

        foreach( $this->items['fields'] as $field )
            if( $field['type'] == 'tab' )
                return true;

        return false;

    }


    /**
     * Wrap the input in a section
     *
     * This class is for setting options
     *
     * @param (string)	$input   The string value of input (<input />))
     * @param (array)   $option	 Field options (like name, id etc)
     *
     * @since 1.0
     * @access public
     * @return string
     */
    public function section( $input, $options ){

        $template_file = $this->options['templates_dir'] . $options['type'] . '.php';
        ob_start();

        if( ! file_exists( $template_file ) )
            require $this->options['templates_dir'] . 'default.php';
        else
            require $template_file;

        return  ob_get_clean();

    }


    /**
     * Make input name from options variable
     *
     * @param (array) $options Options array
     *
     * @since 1.0
     * @access public
     * @return string
     */
    public function input_name( &$options ){
        $id   = @$options['id'];
        $type = @$options['type'];

        switch( $type ){

            case( 'image_checkbox' ):
                return "{$id}[%s]";
                break;

            default:
                return $id;
                break;

        }

    }


    /**
     * Get classes - @Vahid WTF!!!
     *
     * get element classes array
     *
     * @param (type) about this param
     *
     * @since 1.0
     * @access public
     * @return array
     */
    public function get_classes( &$options ){

        $is_repeater = isset( $options['repeater_item'] ) && $options['repeater_item'] === true;
        $classes = array();

        $classes['section'] 		 			 			 =  apply_filters( 'better-framework/field-generator/class/section', 'bf-section' );
        $classes['section'] .= ! isset( $options['section_class'] ) ? '' : ' ' . $options['section_class'];

        $classes['container'] 		 			 			 =  apply_filters( 'better-framework/field-generator/class/container', 'bf-section-container' );
        $classes['container'] .= ! isset( $options['container_class'] ) ? '' : ' ' . $options['container_class'];


        $classes['repeater-section'] 			 		 	 =  apply_filters( 'better-framework/field-generator/class/section/repeater', 'bf-repeater-section-option' );
        $classes['nonrepeater-section']		 				 =  apply_filters( 'better-framework/field-generator/class/section/nonrepeater', 'bf-nonrepeater-section' );
        $classes['section-class-by-filed-type']  			 =  apply_filters( 'better-framework/field-generator/class/section/by/type', 'bf-section-' . $options['type'] . '-option', $options['type'] );
        $classes['nonrepeater-section-class-by-filed-type']  =  apply_filters( 'better-framework/field-generator/class/section/nonrepeater/by/type', 'bf-nonrepeater-' . $options['type'] . '-section', $options['type'] );
        $classes['repeater-section-class-by-filed-type'] 	 =  apply_filters( 'better-framework/field-generator/class/section/repeater/by/type', 'bf-repeater-' . $options['type'] . '-section', $options['type'] );

        $classes['heading'] 		 			 			 =  apply_filters( 'better-framework/field-generator/class/heading', 'bf-heading' );
        $classes['repeater-heading'] 			 		 	 =  apply_filters( 'better-framework/field-generator/class/heading/repeater', 'bf-repeater-heading-option' );
        $classes['nonrepeater-heading']		 				 =  apply_filters( 'better-framework/field-generator/class/heading/nonrepeater', 'bf-nonrepeater-heading' );
        $classes['heading-class-by-filed-type']  			 =  apply_filters( 'better-framework/field-generator/class/heading/by/type', 'bf-heading-' . $options['type'] . '-option', $options['type'] );
        $classes['nonrepeater-heading-class-by-filed-type']  =  apply_filters( 'better-framework/field-generator/class/heading/nonrepeater/by/type', 'bf-nonrepeater-' . $options['type'] . '-heading', $options['type'] );
        $classes['repeater-heading-class-by-filed-type'] 	 =  apply_filters( 'better-framework/field-generator/class/heading/repeater/by/type', 'bf-repeater-' . $options['type'] . '-heading', $options['type'] );

        $classes['controls'] 		 			 			 =  apply_filters( 'better-framework/field-generator/class/controls', 'bf-controls' );
        $classes['repeater-controls'] 			 		 	 =  apply_filters( 'better-framework/field-generator/class/heading/repeater', 'bf-repeater-controls-option' );
        $classes['nonrepeater-controls']		 			 =  apply_filters( 'better-framework/field-generator/class/heading/nonrepeater', 'bf-nonrepeater-controls' );
        $classes['controls-class-by-filed-type']  			 =  apply_filters( 'better-framework/field-generator/class/heading/by/type', 'bf-controls-' . $options['type'] . '-option', $options['type'] );
        $classes['nonrepeater-controls-class-by-filed-type'] =  apply_filters( 'better-framework/field-generator/class/heading/nonrepeater/by/type', 'bf-nonrepeater-' . $options['type'] . '-controls', $options['type'] );
        $classes['repeater-controls-class-by-filed-type'] 	 =  apply_filters( 'better-framework/field-generator/class/heading/repeater/by/type', 'bf-repeater-' . $options['type'] . '-controls', $options['type'] );

        $classes['explain'] 		 			 			 =  apply_filters( 'better-framework/field-generator/class/explain', 'bf-explain' );
        $classes['repeater-explain'] 			 		 	 =  apply_filters( 'better-framework/field-generator/class/explain/repeater', 'bf-repeater-explain-option' );
        $classes['nonrepeater-explain']		 				 =  apply_filters( 'better-framework/field-generator/class/explain/nonrepeater', 'bf-nonrepeater-explain' );
        $classes['explain-class-by-filed-type']  			 =  apply_filters( 'better-framework/field-generator/class/explain/by/type', 'bf-explain-' . $options['type'] . '-option', $options['type'] );
        $classes['nonrepeater-explain-class-by-filed-type']  =  apply_filters( 'better-framework/field-generator/class/explain/nonrepeater/by/type', 'bf-nonrepeater-' . $options['type'] . '-explain', $options['type'] );
        $classes['repeater-explain-class-by-filed-type'] 	 =  apply_filters( 'better-framework/field-generator/class/explain/repeater/by/type', 'bf-repeater-' . $options['type'] . '-explain', $options['type'] );

         return $classes;

    }


    /**
     * Used for generating start tag of fields group
     *
     * @param $group
     *
     * @return string
     */
    function get_fields_group_start( $group ){

        $group_container_class = 'fields-group bf-clearfix';
        if( isset( $group['container-class'] ) ){
            $group_container_class .= ' ' . $group['container-class'];
        }

        $group_title_class = 'fields-group-title-container';
        if( isset( $group['title-class'] ) ){
            $group_title_class .= ' ' . $group['title-class'];
        }

        if( ! isset( $group['id'] ) ){
            $group['id'] = time();
        }

        if( isset( $group['color'] ) ){
            $color = $group['color'];
        }else{
            $color = '';
        }

        // Collapsible feature
        if( isset( $group['state'] ) ) {
            $state = $group['state'];
        }else{
            $state = 'open';
        }
        if( $state == 'close' ){

            $group_container_class .= ' collapsible close';
            $collapse_button = '<span class="collapse-button"><i class="fa fa-plus"></i></span>';


        }elseif( $state == 'open' ){

            $group_container_class .= ' collapsible open';
            $collapse_button = '<span class="collapse-button"><i class="fa fa-minus"></i></span>';


        }else{

            $group_container_class .= ' not-collapsible';
            $collapse_button = '';

        }


        // Desc
        if( isset( $group['desc'] ) ){
            $desc = "<div class='bf-group-desc'>{$group['desc']}</div>";
        }else{
            $desc = "";
        }

        $output = "\n\n<!-- Fields Group -->\n<div class='{$group_container_class} {$color}' id='fields-group-{$group['id']}'>\n";
        $output .= "<div class='{$group_title_class}'><span class='fields-group-title'>{$group['name']}</span>{$collapse_button}</div>";
        $output .= "<div class='bf-group-inner bf-clearfix' style='" . ( $state == 'close' ? 'display:none;' : '' ) ."'>$desc";

        return $output;
    }


    /**
     * Used for generating close tag of fields group
     *
     * @param $group
     *
     * @return string
     */
    function get_fields_group_close( $group = '' ){

        return '</div></div>';

    }


    /**
     * Used for generating repeater field
     *
     * @param $panel_or_metabox          array           Repeater field information's
     * @param $field     array           Field information's
     * @param $defaults      string|int|bool Field Value
     * @param $name_format      string          Field name
     * @param $number           int             Field id in repeater values
     *
     * @return string
     */
    function generate_repeater_field( $panel_or_metabox, $field, $defaults, $name_format, $number ){

        if(
            empty( $field['id'] )
            || empty( $field['type'] )
            || !in_array( $field['type'], $this->supported_fields_in_repeater )
        )
            return;

        // Repeater in metabox
        if( isset( $panel_or_metabox['metabox-field'] ) && $panel_or_metabox['metabox-field'] ){
            $field['input_name'] = sprintf( $name_format, $panel_or_metabox['metabox-id'], $panel_or_metabox['id'], $number, $field['id'] );
        }
        // Repeater in widgets
        elseif( isset( $panel_or_metabox['widget_field'] ) ){
            $field['input_name'] = sprintf( $field['input_name'], $number );
        }
        // General Repeater
        else{
            $field['input_name'] = sprintf( $name_format, $panel_or_metabox['id'], $number, $field['id'] );
        }

        if( isset( $field['filter-field'] ) && $field['filter-field-value'] ){

            if( $field['filter-field-value'] !== @$defaults[$field['filter-field']] ){

                $field['section-css']['display'] = "none";

            }

        }

        $field['value'] = @$defaults[$field['id']];

        echo call_user_func(
            array( $this, 'section' ),
            call_user_func(
                array( $this, $field['type'] ),
                $field
            ),
            $field
        );

    }


    /**
     * Used for generating repeater field script tags
     * that will be used adding more items in front end
     *
     * @param $panel_or_metabox          array           Repeater field information's
     * @param $field    array           Field Information's
     * @param $defaults            string|int|bool Field value
     *
     * @return string
     */
    function generate_repeater_field_script( $panel_or_metabox, $field, $defaults ){

        if( ! in_array( $field['type'], $this->supported_fields_in_repeater ) )
            return;

        // Repeater in metabox
        if( isset( $panel_or_metabox['metabox-field'] ) && $panel_or_metabox['metabox-field'] ){
            $field['input_name'] = "|_to_clone_{$panel_or_metabox['metabox-id']}-child-{$panel_or_metabox['id']}-num-{$field['id']}|";
        }
        // Repeater in widgets
        elseif( isset( $panel_or_metabox['widget_field'] ) ){
            $field['input_name'] = "|_to_clone_{$panel_or_metabox['id']}-num-{$field['id']}|";
        }
        // General Repeater
        else{
            $field['input_name'] = "|_to_clone_{$panel_or_metabox['id']}-num-{$field['id']}|";
        }

        if( isset( $field['filter-field'] ) && $field['filter-field-value'] ){

            if( $field['filter-field-value'] !== @$defaults[$field['filter-field']] ){

                $field['section-css']['display'] = "none";

            }

        }

        $field['value'] = $defaults[$field['id']];

        echo call_user_func(
            array( $this, 'section' ),
            call_user_func(
                array( $this, $field['type'] ),
                $field
            ),
            $field
        );

    }


    /**
     * PHP __call Magic Function
     *
     * @param $name
     * @param $arguments
     * @throws Exception
     * @internal param $ (string) $name      name of requested method
     * @internal param $ (array)  $arguments arguments of requested method
     *
     * @since 1.0
     * @access public
     * @return mixed
     */
    public function __call( $name, $arguments ){

        $file = $this->options['fields_dir'] . $name . '.php';

        // Check if requested field (method) does exist!
        if( ! file_exists( $file ) )
            throw new Exception( $name . ' does not exist!' );

        $options = $arguments[0];

        // Capture output
        ob_start();
        require $file;

        $data = ob_get_clean();

        return $data;
    }


    //
    //
    // Handy functions
    //
    //


    /**
     * Used for generating section css attr from field array
     *
     * @since 2.0
     * @param $field
     *
     * @return string
     */
    function get_section_css_attr( $field ){

        $attr = '';

        if( isset( $field['section-css'] ) ){

            $attr = 'style="';

            foreach( (array) $field['section-css'] as $css_id => $css_code ){

                $attr .= $css_id . ':' . $css_code . ';';

            }

            $attr .= '"';
        }


        return $attr;
    }


    /**
     * Used for generating section field attr from field array
     *
     * @since 2.0
     * @param $field
     *
     * @return string
     */
    function get_section_filter_attr( $field ){

        $attr = '';

        if( isset( $field['filter-field'] ) && $field['filter-field-value'] ){

            $attr = ' data-filter-field="' . $field['filter-field'] . '"';
            $attr .= ' data-filter-field-value="' . $field['filter-field-value'] . '" ';

        }

        return $attr;
    }


    /**
     * Used for creating field input desc
     *
     * @since 2.0
     *
     * @param $field
     *
     * @return string
     */
    function get_filed_input_desc( $field ){

        if( isset( $field['input-desc'] ) ){

            return '<div class="input-desc">' . $field['input-desc'] . '</div>';

        }else{
            return '';
        }

    }


    /**
     * Return The HTML Output of Tabs
     *
     * @since 1.0
     * @return string
     */
    public function get_tabs(){

        $fields = $this->items['fields'];

        // Generate Tabs Array
        $tabs_array		 = array();
        $prev_tab_key	 = 0;
        $menu_items      = array();

        foreach ( (array) $fields as $field )
            if ( $field['type'] == 'tab' || $field['type'] == 'subtab' )
                $tabs_array[] = $field;

        foreach ( $tabs_array as $k => $v ) {
            $token = $v['id'];
            // Capture the token.
            $v['token'] = $token;
            if ( $v['type'] == 'tab' ) {
                $menu_items[$token] = $v;
                $prev_tab_key 		= $token;
            }
            if ( $v['type'] == 'subtab' ) {
                $menu_items[$prev_tab_key]['children'][] = $v;
            }
        }


        if( count( $menu_items ) <= 0 ){
            return '';
        }

        $output   = '';
        $output  .= '<ul>';
        $tabs    = $menu_items;

        foreach( $tabs as $tab_id => $tab ){
            $hasChildren = isset( $tab['children'] ) && count( $tab['children'] ) > 0;
            $class	 = $hasChildren ? 'has-children' : '';

            if( isset( $tab['margin-top'] ) ){
                $class .= ' margin-top-' . $tab['margin-top'];
            }

            if( isset( $tab['margin-bottom'] ) ){
                $class .= ' margin-bottom-' . $tab['margin-bottom'];
            }

            $output .= '<li class="'.$class.'" data-go="'.$tab_id.'">';
            $output .= '<a href="#" class="bf-tab-item-a" data-go="'.$tab['id'].'">';


            // Icon
            if( isset( $tab['icon'] ) && ! empty( $tab['icon'] ) ){

                $output .= BF()->icon_factory()->get_icon_tag_from_id( $tab['icon'] ) . ' ';

            }

            $output .= $tab['name'];


            // Adds badge to tab
            if( isset( $tab['badge'] ) && isset( $tab['badge']['text'] ) ){

                $badge_style = '';

                if( isset( $tab['badge']['color'] ) ){
                    $badge_style = "style='background-color:{$tab['badge']['color']};border-color:{$tab['badge']['color']}'";
                }

                $output .= "<span class='bf-tab-badge' {$badge_style}>{$tab['badge']['text']}</span>";
            }


            $output .= '</a>';

            if ( $hasChildren ) {

                $output .= '<ul class="sub-nav">';

                foreach ( $tab['children'] as $child ) {

                    $output .= '<li>';
                    $output .= '<a href="#" class="bf-tab-subitem-a" data-go="'.$child['id'].'">'.$child['name'].'</a>';
                    $output .= '</li>';
                }

                $output .= '</ul>';

            }

            $output .= '</li>';
        }

        $output .= '</ul>';

        return $output;

    }


    //
    //
    // Better Modals Handlers
    //
    //


	/**
     * Contains list of active modals that should be printed in bottom of page
     *
     * @var array
     */
    public static $active_modals = array();


	/**
     * Adds modals to active modals list
     *
     * @param $modal_id
     */
    public static function add_modal( $modal_id ){
        self::$active_modals[$modal_id] = $modal_id;
    }


	/**
     * Callback: Hooked to admin_footer to print all modals in bottom of page
     */
    public static function enqueue_modals(){

        foreach( (array) self::$active_modals as $modal ){

            delete_option(( 'better-modal-code-' . $modal ));

            // Get from cache
            $modal_code = get_option( 'better-modal-code-' . $modal );

            if( $modal_code !== false ){

                echo $modal_code;

            }
            // Generate and cache it
            else{

                $modal_template_file = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'modals' . DIRECTORY_SEPARATOR . $modal . '.php';

                ob_start();

                require $modal_template_file;

                $modal_code = ob_get_clean();

                add_option( 'better-modal-code-' . $modal, $modal_code, '', false );

                echo $modal_code;
            }

        }

    }

}