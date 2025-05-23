<?php
/**
 * BF automatic custom css generator
 */
class BF_Pages_CSS extends BF_Custom_CSS {

    /**
     * Contains Current Page or Post ID
     *
     * @var int
     */
    public $post_id = 0;


    /**
     * prepare functionality
     */
    function __construct(){

        // Clear Cache Callbacks
        // TODO this callbacks are not triggered in pages
        add_action( 'delete_post', array( $this, 'clear_cache' ) );
        add_action( 'untrash_post', array( $this, 'clear_cache' ) );
        add_action( 'save_post', array( $this, 'clear_cache' ) );

        // Register Custom CSS
        add_action( 'wp_enqueue_scripts', array($this, 'register_custom_css'), 100);

        // Output Custom CSS Codes
        add_action( 'template_redirect', array($this, 'global_custom_css'), 1);

    }


    /**
     * Register BF Custom CSS Codes For Theme Specified Fields
     *
     * - Action Callback
     */
    function register_custom_css(){

        // Only in Post Types Single Page and Pages
        if( is_singular() ){

            $css_meta_cached = get_post_meta( get_the_ID(), '_bf_post_css_cached_' . get_the_ID(), true );

            if( $css_meta_cached === "" ) {
                $this->load_post_fields( get_the_ID() );
                $css_meta_cached = get_post_meta( get_the_ID(), '_bf_post_css_cached_' . get_the_ID(), true ) ;
            }

            $css_meta = get_post_meta( get_the_ID(), '_bf_post_css_' . get_the_ID(), true );

            if( $css_meta !== '' )
                wp_enqueue_style( 'bs-page-custom', get_site_url() . '/?bs_per_page_custom_css=1&post_id='. get_the_ID() . '&ver=' . $css_meta_cached, array(), NULL );

        }

    }


    /**
     * Output Custom CSS
     *
     * - Action Callback
     */
    public function global_custom_css(){
        // just when custom css requested
        if (
            empty( $_GET['bs_per_page_custom_css'] ) OR
            intval($_GET['bs_per_page_custom_css']) != 1 OR
            ! isset( $_GET['post_id'] ) OR
             empty( $_GET['post_id'] )

        )  return;

        $this->post_id = intval( $_GET["post_id"] );
        $this->display();
        exit;
    }


    /**
     * Clear cache (transient)
     *
     * - Action Callback
     */
    public function clear_cache( $post_ID ){

        delete_post_meta( $post_ID, '_bf_post_css_' . $post_ID );
        delete_post_meta( $post_ID, '_bf_post_css_cached_' . $post_ID );

    }


    /**
     * Load all fields
     */
    function load_all_fields(){

        // Filter Custom CSS Code For Pages
        if( is_page() ){

            $this->fields = apply_filters( 'better-framework/css/pages' , $this->fields );
            $this->load_post_fields();

        }elseif( is_singular() ){

            $this->fields = apply_filters( 'better-framework/css/posts' , $this->fields );
            $this->load_post_fields();

        }

    }

    /**
     * Loads Fields For Posts And Pages
     *
     * @param bool $post_id
     */
    function load_post_fields( $post_id = false ){

        if( $post_id == false ){
            $post_id = $this->post_id;
        }

        // load from cache if available
        $css_meta_cached = get_post_meta( $post_id, '_bf_post_css_cached_' . $post_id, true ) ;
        if( $css_meta_cached !== '' ){

            $css_meta = get_post_meta( $post_id, '_bf_post_css_' . $post_id );

            if( $css_meta === false ){
                return;
            }
            else{
                foreach( $css_meta as $post_meta ){
                    $this->fields = array_merge( $this->fields ,  $post_meta );
                }
                return;
            }

        }

        // save current time to page cached time
        add_post_meta( $post_id, '_bf_post_css_cached_' . $post_id, time() );

        // Load All Metabox Fields
        $metabox_options = apply_filters( 'better-framework/metabox/options', array() );

        // Iterate All Meta Box's
        foreach( $metabox_options as $option_key => $option_value ){

            if( isset( $option_value['panel-id'] ) ){
                $css_id = $this->get_css_id( $option_value['panel-id'] );
            }else{
                $css_id = 'css';
            }

            $metabox_css = array();

            // If meta box have config
            if( ! isset( $option_value['config'] )  )
                continue;

            // If Meta Box is Valid for Current Page
            if( ! Better_Framework::factory( 'meta-box' )->can_output( $option_value['config'] ) )
                continue;

            // If have meta box have fields
            if( ! isset( $option_value['fields'] ) )
                continue;

            // Each field of Metabox
            foreach( $option_value['fields'] as $field_key => $field_value){

                // continue when haven't css field
                if( ! isset( $field_value[$css_id] ) )
                    if( ! isset( $field_value['css'] ) )
                        continue;

                // If Field Value Saved
                if( false == ( $field_saved_value = get_post_meta( $post_id, $field_value['id'], true ) ) ) continue;

                if( isset( $field_value[$css_id] ) ){
                    $field_value[$css_id]['value'] = $field_saved_value;
                    $metabox_css[] = $field_value[$css_id];
                }else{
                    $field_value['css']['value'] = $field_saved_value;
                    $metabox_css[] = $field_value['css'];
                }

            }

            // remove without data background image fields
            foreach( $metabox_css as $key => $meta_css ){
                if( isset( $meta_css['value']['img'] ) && $meta_css['value']['img'] == '' ){
                    unset( $metabox_css[$key] );
                }
            }

            if( count( $metabox_css ) > 0 ) {
                add_post_meta( $post_id, '_bf_post_css_' . $post_id, $metabox_css );
                $this->fields = array_merge( $this->fields ,  $metabox_css );
            }

        }

    }

}