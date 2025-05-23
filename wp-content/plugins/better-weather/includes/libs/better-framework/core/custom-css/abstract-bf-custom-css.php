<?php

/**
 * Handle Base Custom CSS Functionality in BetterFramework
 */
abstract class BF_Custom_CSS{

    /**
     * Contain all css's that must be generated
     *
     * @var array
     */
    protected $fields = array();


    /**
     * Contain final css that rendered.
     *
     * @var string
     */
    protected $final_css = '';


    /**
     * Contain Fonts That Must Be Import In Top Of CSS
     *
     * @var array
     */
    protected $fonts = array();


    /**
     * Used For Adding New Font To Fonts Queue
     *
     * @param string $family
     * @param string $variants
     * @param string $subsets
     */
    public function set_fonts( $family = '', $variants = '', $subsets = '' ){


        // If Font Currently is in Queue Then Add New Variant Or Subset
        if( isset( $this->fonts[$family] ) ){

            if( ! in_array( $variants, $this->fonts[$family]['variants'] ) ){
                $this->fonts[$family]['variants'][] = $variants;
            }

            if( ! in_array( $subsets, $this->fonts[$family]['subsets'] ) ){
                $this->fonts[$family]['subsets'][] = $subsets;
            }

        }
        // Add New Font to Queue
        else{

            $this->fonts[$family] = array(
                'variants'  =>  array( $variants ),
                'subsets'   =>  array( $subsets ),
            );

        }

    }


    /**
     * Used For Generating Fonts
     *
     * @param string $type
     *
     * @return array|string
     */
    public function render_fonts( $type = 'google-fonts' ){

        if( ! count( $this->fonts ) ) return '';

        $output = ''; // Final Out Put CSS

        $out_fonts = array(); // Array of Fonts, Each inner element separately

        // Collect all fonts in one url if can for better performance
        if( $type == 'google-fonts' ) {

            $out_fonts['main'] = array();

        }


        // Create Each Font CSS
        foreach( $this->fonts as $font_id => $font_information){

            //
            // Google Font
            //
            if( $type == 'google-fonts' ){

                $_font_have_subset = false;

                $font_data = Better_Framework::fonts_manager()->google_fonts()->get_font( $font_id );

                if( $font_data == false ) continue; // font id is not valid google font

                $_font = str_replace( ' ', '+', $font_id );

                if( implode( ',', $font_information['variants'] ) != '' ){
                    $_font .= ':' . implode( ',', $font_information['variants'] );
                }

                // Remove Latin Subset because default subset is latin!
                // and if font have other subset then we make separate @import.
                foreach( $font_information['subsets'] as $key => $value ){
                    if( $value == 'latin' ){
                        unset( $font_information['subsets'][$key] );
                    }
                }

                if( implode( ',', $font_information['subsets'] ) != '' ){
                    $_font_have_subset = true;
                    $_font .= '&subset=' . implode( ',', $font_information['subsets'] );
                }

                // no subset
                if( ! $_font_have_subset ){
                    array_push( $out_fonts['main'], $_font );
                }else{
                    $out_fonts[][] = $_font;
                }
            }

            //
            // Custom Font
            //
            elseif( $type == 'custom-fonts' || $type == 'theme-fonts' ){

                if( $type == 'custom-fonts' ){
                    $font_data = Better_Framework::fonts_manager()->custom_fonts()->get_font( $font_id );
                }else{
                    $font_data = Better_Framework::fonts_manager()->theme_fonts()->get_font( $font_id );
                }

                if( $font_data === false ) continue; // font id is not valid or removed

                $main_src_printed = false;

                $custom_output = '';

                $custom_output .= "
@font-face {
    font-family: '" . $font_id . "';";

                // .EOT
                if( ! empty( $font_data['eot'] ) ){

                    $custom_output .= "
    src: url('" . $font_data['eot'] . "'); /* IE9 Compat Modes */
    src: url('" . $font_data['eot'] . "?#iefix') format('embedded-opentype') /* IE6-IE8 */";

                    $main_src_printed = true;

                }

                // .WOFF
                if( ! empty( $font_data['woff'] ) ){

                    if( $main_src_printed ){

                        $custom_output .= "
    , url('" . $font_data['woff'] . "') format('woff') /* Pretty Modern Browsers */";

                    }else{

                        $main_src_printed = true;

                        $custom_output .= "
    src: url('" . $font_data['woff'] . "') format('woff') /* Pretty Modern Browsers */";

                    }
                }


                // .TTF
                if( ! empty( $font_data['ttf'] ) ){

                    if( $main_src_printed ){

                        $custom_output .= "
    , url('" . $font_data['ttf'] . "') format('truetype') /* Safari, Android, iOS */";

                    } else {

                        $main_src_printed = true;

                        $custom_output .= "
    src: url('" . $font_data['ttf'] . "') format('truetype') /* Safari, Android, iOS */";

                    }
                }

                // .SVG
                if( ! empty( $font_data['svg'] ) ){

                    if( $main_src_printed ){

                        $custom_output .= "
    , url('" . $font_data['svg'] . "#" . $font_id . "') format('svg') /* Legacy iOS */";

                    }else{

                        $custom_output .= "
    src: url('" . $font_data['svg'] . "#" . $font_id . "') format('svg') /* Legacy iOS */";


                    }
                }

                $custom_output .= ";
    font-weight: normal;
    font-style: normal;
}";

                $out_fonts[] = $custom_output;

            }

        }

        //
        // Google Fonts final array of links
        //
        if( $type == 'google-fonts' ){

            $final_fonts = array();
            foreach( $out_fonts as $key => $out_font ){
                if( count( $out_font ) > 0 ){
                    $final_fonts[] =  Better_Framework::fonts_manager()->get_protocol() . 'fonts.googleapis.com/css?family=' . implode( '|', $out_font );
                }
            }

            return $final_fonts;
        }

        //
        // Custom Fonts final string of font-face
        //
        elseif( $type == 'custom-fonts' || $type == 'theme-fonts' ){

            foreach( $out_fonts as $out_font ){
                $output .= $out_font;
            }

            if( ! empty( $output ) ){
                $output .= "\n";
            }
        }

        return $output;
    }


    /**
     * Add new line to active fields
     */
    private function add_new_line(){

        $this->fields[] = array( 'newline' => true );

    }


    /**
     * Render a block array to css code
     *
     * @param   array   $block
     * @param   string  $value
     * @param   bool    $add_to_final
     *
     * @return string
     */
    private function render_block( $block , $value='' , $add_to_final = true ){
        $output = '';

        $after_value ='';

        $after_block ='';

        // Uncompressed in dev mode
        if( defined( 'BF_DEV_MODE' ) && BF_DEV_MODE ){
            $ln_char = "\n";
            $tab_char = "\t";
        }else{
            $ln_char = "";
            $tab_char = "";
        }

        if( isset( $block['newline'] ) ){
            $output .=  "\r\n";
        }

        if( isset( $block['comment'] ) || !empty( $block['comment'] ) ){
            $output .= '/* '. $block['comment'] . ' */' . "\r\n";
        }

        // Filters
        if( isset( $block['filter'] ) ){

            // WooCommerce Active Filter
            if( in_array( 'woocommerce', $block['filter'] ) && ! function_exists( 'is_woocommerce' ) ){
                return '';
            }

            // bbPress Active Filter
            if( in_array( 'bbpress', $block['filter'] ) && ! class_exists( 'bbpress' ) ){
                return '';
            }

            // BuddyPress Active Filter
            if( in_array( 'buddypress', $block['filter'] )  && ! function_exists( 'bp_is_active' ) ){
                return '';
            }

            // WPML Active Filter
            if( in_array( 'wpml', $block['filter'] )  && ! defined( 'ICL_SITEPRESS_VERSION' ) ){
                return '';
            }

        }

        // Before than css code. For example used for adding media queries!.
        if( isset( $block['before'] ) ){
                $output .= $block['before']  . $ln_char;
        }

        // Prepare Selectors.
        if( isset( $block['selector'] ) ){
            if( ! is_array( $block['selector'] ) ){
                $output .= $block['selector'] . '{' . $ln_char;
            }else{
                $output .= implode( ',' . $ln_char , $block['selector'] ) . '{' . $ln_char;
            }
        }

        // Prepare Value For Font Field
        if( isset( $block['type'] ) && $block['type'] == 'font' ){

            // If font is not enable then don't echo css
            if( isset( $value['enable'] ) && ! $value['enable'] ){
                return '';
            }

            $output .= $tab_char . 'font-family:' . $value['family'] . ';' . $ln_char;

            if( preg_match( '/\d{3}\w./i', $value['variant'] ) ){
                $pretty_variant = preg_replace( '/(\d{3})/i', '${1} ', $value['variant'] );
                $pretty_variant = explode(' ', $pretty_variant);
            }else{
                $pretty_variant[] = $value['variant'];
            }

            if( isset( $pretty_variant[0] ) )
                $output .= $tab_char . 'font-weight:' . $pretty_variant[0] . ';' . $ln_char;

            if( isset( $pretty_variant[1] ) )
                $output .= $tab_char . 'font-style:' . $pretty_variant[1] . ';' . $ln_char;

            if( isset(  $value['line_height']) && ! empty( $value['line_height'] ) )
                $output .= $tab_char . 'line-height:' . $value['line_height'] . 'px;' . $ln_char;

            if( isset( $value['size'] ) )
                $output .= $tab_char . 'font-size:' . $value['size'] . 'px;' . $ln_char;

            if( isset( $value['align'] ) )
                $output .= $tab_char . 'text-align:' . $value['align'] . ';' . $ln_char;

            if( isset( $value['transform'] ) )
                $output .= $tab_char . 'text-transform:' . $value['transform'] . ';' . $ln_char;

            if( isset( $value['color'] ) )
                $output .= $tab_char . 'color:' . $value['color'] . ';' . $ln_char;

            // Add Font To Fonts Queue
            $this->set_fonts( $value['family'], $value['variant'], $value['subset'] );
        }

        // prepare value for "background-image" type
        if( isset( $block['type'] ) && $block['type'] == 'background-image' ){

            if( $value['img'] == '' ) return '';

            // Full Cover Image
            if( $value['type'] == 'cover' ){
                $after_value .= $tab_char . 'background-repeat: no-repeat;background-position: center center; -webkit-background-size: cover; -moz-background-size: cover;-o-background-size: cover; background-size: cover;'
                    . 'filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $value['img']. '\', sizingMethod=\'scale\');
-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $value['img']. '\', sizingMethod=\'scale\')";'
                    . $ln_char;

                $value = 'url('. $value['img'] .')';
            }
            // Fit Cover
            elseif( $value['type'] == 'fit-cover' ){
                $after_value .= $tab_char . 'background-repeat: no-repeat;background-position: center center; -webkit-background-size: contain; -moz-background-size: contain;-o-background-size: contain; background-size: contain;'
                    . 'filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $value['img']. '\', sizingMethod=\'scale\');
-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $value['img']. '\', sizingMethod=\'scale\')";'
                    . $ln_char;

                $value = 'url('. $value['img'] .')';
            }
            // Parallax Image
            elseif( $value['type'] == 'parallax' ){
                $after_value .= $tab_char . 'background-repeat: no-repeat;background-attachment: fixed; background-position: center center; -webkit-background-size: cover; -moz-background-size: cover;-o-background-size: cover; background-size: cover;'
                    . 'filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $value['img']. '\', sizingMethod=\'scale\');
-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $value['img']. '\', sizingMethod=\'scale\')";'
                    . $ln_char;

                $value = 'url('. $value['img'] .')';
            }
            else{
                switch( $value['type'] ){

                    case 'repeat':
                    case 'cover':
                    case 'repeat-y':
                    case 'repeat-x':
                        $after_value .= $tab_char . 'background-repeat:' . $value['type'] . ';' . $ln_char;
                        break;

                    case 'top-left':
                        $after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
                        $after_value .= $tab_char . 'background-position: top left;' . $ln_char;
                        break;

                    case 'top-center':
                        $after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
                        $after_value .= $tab_char . 'background-position: top center;' . $ln_char;
                        break;

                    case 'top-right':
                        $after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
                        $after_value .= $tab_char . 'background-position: top right;' . $ln_char;
                        break;

                    case 'left-center':
                        $after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
                        $after_value .= $tab_char . 'background-position: left center;' . $ln_char;
                        break;

                    case 'center-center':
                        $after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
                        $after_value .= $tab_char . 'background-position: center center;' . $ln_char;
                        break;

                    case 'right-center':
                        $after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
                        $after_value .= $tab_char . 'background-position: right center;' . $ln_char;
                        break;

                    case 'bottom-left':
                        $after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
                        $after_value .= $tab_char . 'background-position: bottom left;' . $ln_char;
                        break;

                    case 'bottom-center':
                        $after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
                        $after_value .= $tab_char . 'background-position: bottom center;' . $ln_char;
                        break;

                    case 'bottom-right':
                        $after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
                        $after_value .= $tab_char . 'background-position: bottom right;' . $ln_char;
                        break;

                }
                $value = 'url('. $value['img'] .')';
            }

        }

        // prepare value for "color" type
        if( isset( $block['type'] ) && $block['type'] == 'color' ){

            if( preg_match( '/(%%value[-|+]\d*%%)/', $block['value'], $chanage) ){

                Better_Framework::factory('color');

                $color_change = $chanage[0];

                $color_change = BF_Color::change_color( $block['value'], intval( $color_change ) );

                $after_value .= preg_replace( '/(%%value[-|+]\d*%%)/', $color_change, $block['value'] );

                unset( $block['value'] );
            }

        }

        // prepare value for "border" type
        if( isset( $block['type'] ) && $block['type'] == 'border' ){

            if( isset( $value['all'] ) ){

                $output .= $tab_char . 'border:';

                if( isset( $value['all']['width'] ) ){
                    $output .= $value['all']['width'] .'px ';
                }
                if( isset( $value['all']['style'] ) ){
                    $output .= $value['all']['style'] . ' ';
                }
                if( isset( $value['all']['color'] ) ){
                    $output .= $value['all']['color']. ' ';
                }

                $output .= ';' . $ln_char;

            }else{

                if( isset( $value['top'] ) ){

                    $output .= $tab_char . 'border-top:';

                    if( isset( $value['top']['width'] ) ){
                        $output .= $value['top']['width'] .'px ';
                    }
                    if( isset( $value['top']['style'] ) ){
                        $output .= $value['top']['style'] . ' ';
                    }
                    if( isset( $value['top']['color'] ) ){
                        $output .= $value['top']['color']. ' ';
                    }

                    $output .= ';' . $ln_char;

                }

                if( isset( $value['right'] ) ){

                    $output .= $tab_char . 'border-right:';

                    if( isset( $value['right']['width'] ) ){
                        $output .= $value['right']['width'] .'px ';
                    }
                    if( isset( $value['right']['style'] ) ){
                        $output .= $value['right']['style'] . ' ';
                    }
                    if( isset( $value['right']['color'] ) ){
                        $output .= $value['right']['color']. ' ';
                    }

                    $output .= ';' . $ln_char;

                }
                if( isset( $value['bottom'] ) ){

                    $output .= $tab_char . 'border-bottom:';

                    if( isset( $value['bottom']['width'] ) ){
                        $output .= $value['bottom']['width'] .'px ';
                    }
                    if( isset( $value['bottom']['style'] ) ){
                        $output .= $value['bottom']['style'] . ' ';
                    }
                    if( isset( $value['bottom']['color'] ) ){
                        $output .= $value['bottom']['color']. ' ';
                    }

                    $output .= ';' . $ln_char;

                }

                if( isset( $value['left'] ) ){

                    $output .= $tab_char . 'border-left:';

                    if( isset( $value['left']['width'] ) ){
                        $output .= $value['left']['width'] .'px ';
                    }
                    if( isset( $value['left']['style'] ) ){
                        $output .= $value['left']['style'] . ' ';
                    }
                    if( isset( $value['left']['color'] ) ){
                        $output .= $value['left']['color']. ' ';
                    }

                    $output .= ';' . $ln_char;

                }

            }

        }

        // Prepare Properties
        if( isset( $block['prop'] ) ){

            foreach( (array) $block['prop'] as $key => $val ){

                // Customized value template for property
                if( strpos( $val, '%%value%%' ) !== false){

                    $output .= $tab_char . $key . ':';
                    $output .= str_replace( '%%value%%' , $value , $val ) . ';' . $ln_char;

                }
                // Simply set value to property
                else{

                    if( ! is_int( $key ) ){

                        $output .= $tab_char . $key . ':' . $val . ';' . $ln_char;

                    }else{

                        $output .= $tab_char . $val . ':' . $value . ';' . $ln_char;

                    }

                }
            }

        }

        // add after value
        if( isset($after_value) && $after_value != '' )
            $output .= $after_value;

        // Remove last ';'
        $output = rtrim( $output, ';' );

        if( isset( $block['selector'] ) ){
            $output .= "}" . $ln_char;
        }

        // After css code. For example used for adding media queries!.
        if( isset( $block['after'] ) ){
            $output .= $block['after']  . $ln_char;
        }

        if( $add_to_final )
            $this->final_css .= $output;

        return $output;
    }


    /**
     * Render all fields css
     *
     * @return string
     */
    function render_css(){

        foreach( (array) $this->fields as $field ){

            // new line field
            if( isset( $field['newline'] ) ){
                $this->render_block( $field , '' );
                continue;
            }

            // continue when value in empty
            if( ! isset(  $field['value'] ) && empty( $field['value'] ) ) continue;

            $value = $field['value'];

            unset( $field['value'] );

            foreach( (array) $field as $block ){
                if( is_array( $block ) )
                    $this->render_block( $block , $value );
            }
        }

        return $this->final_css;
    }


    /**
     * display css
     */
    function display(){

        status_header( 200 );
        header( "Content-type: text/css; charset: utf-8" );

        $this->load_all_fields();

        $final_css = $this->render_css();

        echo $this->render_fonts();

        echo $final_css;

    }


    /**
     * Returns current css field id that integrated with style system
     *
     * @param   string  $panel_id
     *
     * @return  string
     */
    function get_css_id( $panel_id ){

        // If panel haven't style feature
        if( ! isset( Better_Framework::options()->options[$panel_id]['fields']['style'] ) )
            return 'css';

        if( get_option( $panel_id . '_current_style' ) == 'default' )
            return 'css';
        else
            return 'css-' . get_option( $panel_id . '_current_style' );

    }
}