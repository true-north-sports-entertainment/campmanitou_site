<?php

// Prevent Direct Access
defined( 'ABSPATH' ) or die;


/**
 * Class BF_Admin_Menus
 */
class BF_Admin_Menus {


    /**
     * Contains list of all active admin menus
     *
     * @since 1.4
     * @var array
     */
    protected $admin_menus = array();


    /**
     * contains id of BetterStudio menu
     *
     * @since 1.4
     * @var string
     */
    protected $main_admin_menu_id = '';


    /**
     * contains slug of BetterStudio menu
     *
     * @since 1.4
     * @var string
     */
    protected $main_admin_menu_slug = '';


    function __construct(){

        // Used for registering active menus to WP admin menu
        add_action( 'admin_menu', array( $this, 'wp_admin_menu' ), 5 );

    }


    /**
     * Used for adding page to WP menu
     *
     * @since 1.4
     * @param $menu
     */
    function add_menu_page( $menu ){

        if( isset( $menu['id'] ) && isset( $menu['callback'] ) ){

            $this->admin_menus[$menu['id']] = $menu;

        }

    }


    /**
     * Used for adding separator to BetterStudio WP menu
     *
     * @since 2.0
     * @param $position
     */
    function add_menu_separator( $position = 79 ){

        $id = 'sep-' . rand( 100, 100000 );

        $this->admin_menus[$id] =  array(
            'id' 				  =>    $id,
            'slug' 				  =>    'sep',
            'name' 	              =>    '',
            'page_title' 	      =>    '',
            'menu_title' 	      =>    '',
            'callback' 	          =>    '',
            'parent' 			  =>    'better-studio',
            'position'  		  =>    $position,
        );

    }



    /**
     * Hook register menus to WordPress
     *
     * @since   1.4
     * @access  public
     *
     * @return  void
     */
    function wp_admin_menu(){

        /**
         * Action for adding menu pages
         *
         * @since 1.4
         */
        do_action( 'better-framework/admin-menus/admin-menu/before' );

        // If there is no submitted admin menu
        if( count( $this->admin_menus ) == 0 )
            return;


        // Adds admin pages that are outside of BetterStudio main menu
        foreach( (array) $this->admin_menus as $menu_id => $menu ){

            if( isset( $menu['parent'] ) && $menu['parent'] != 'better-studio' ){

                if( $menu['parent'] === false && isset( $menu['parent_title'] ) ){

                    $_main_admin_menu_id = 'better-studio/' . $menu['id'];
                    $_main_admin_menu_slug = $menu['slug'];

                    // Adds main better studio menu page
                    $this->register_menu_page( array(
                        'id'                    =>    $_main_admin_menu_id,
                        'slug'                  =>    $_main_admin_menu_slug,
                        'parent'                =>    false,
                        'name'                  =>    $menu['parent_title'],
                        'page_title'            =>    $menu['parent_title'],
                        'menu_title'            =>    $menu['parent_title'],
                        'callback'              =>    $menu['callback'],
                        'capability'            =>    'manage_options',
                        'icon'                  =>    '',
                        'position'              =>    $menu['position'],
                    ) );

                    // Updates main menu page for new main sub menu
                    $this->register_menu_page( array(
                        'id'                    =>    $_main_admin_menu_id,
                        'slug'                  =>    $_main_admin_menu_slug,
                        'parent'                =>    $_main_admin_menu_slug,
                        'name'                  =>    $menu['name'],
                        'page_title'            =>    $menu['page_title'],
                        'menu_title'            =>    $menu['menu_title'],
                        'callback'              =>    $menu['callback'],
                        'capability'            =>    'manage_options',
                        'icon'                  =>    null,
                        'position'              =>    1,
                    ) );

                    // Adds another temp item to force menu for having sub menu
                    $this->register_menu_page( array(
                        'id'                    =>    '',
                        'slug'                  =>    'extra' ,
                        'parent'                =>    $_main_admin_menu_slug,
                        'name'                  =>    '',
                        'page_title'            =>    '',
                        'menu_title'            =>    '',
                        'capability'            =>    'manage_options',
                        'icon'                  =>    null,
                        'position'              =>    '99',
                    ) );

                    // Add style for hiding temp sub menu with css
                    bf_add_admin_css( '#adminmenu li#toplevel_page_'. str_replace( array( '/'), '-', $_main_admin_menu_slug ) .' .wp-submenu li:nth-child(3){ display: none !important; }', true );
                    bf_add_admin_css( '#adminmenu li#toplevel_page_'. str_replace( array( '/'), '-', $_main_admin_menu_slug ) .' .wp-menu-image:before{ content: \'' . $menu['icon'] . '\' !important; font-family: \'Better Studio Admin Icons\'; font-size: 15px; line-height: 21px;}', true );

                    unset( $this->admin_menus[$menu_id] );

                }else{

                    $this->register_menu_page( $menu );

                    unset( $this->admin_menus[$menu_id] );

                }

            }

        }


        // add separator if needed
        $this->prepare_menu_separators();

        // Sorts items with position sub array key
        usort( $this->admin_menus, array( $this, "usort_cmp_by_position" ) );

        // When there is only one item in BetterStudio main menu
        if( count( $this->admin_menus ) == 1 ){

            $menu = current( $this->admin_menus );

            // Save main menu id tat will be used for hiding
            $this->main_admin_menu_id = 'better-studio/' . $menu['id'];
            // todo check this, here we should set $this->main_admin_menu_slug but we don't!

            // Adds main better studio menu page
            $this->register_menu_page( array(
                'id'                    =>    $this->main_admin_menu_id,
                'slug'                  =>    $this->main_admin_menu_slug,
                'parent'                =>    false,
                'name'                  =>    '<strong>Better</strong>Studio',
                'page_title'            =>    '<strong>Better</strong>Studio',
                'menu_title'            =>    '<strong>Better</strong>Studio',
                'callback'              =>    $menu['callback'],
                'capability'            =>    'manage_options',
                'icon'                  =>    ''  ,
                'position'              =>    '59.001',
            ) );

            // Updates main menu page for new main sub menu
            $this->register_menu_page( array(
                'id'                    =>    $this->main_admin_menu_id,
                'slug'                  =>    $this->main_admin_menu_slug,
                'parent'                =>    $this->main_admin_menu_slug,
                'name'                  =>    $menu['name'],
                'page_title'            =>    $menu['page_title'],
                'menu_title'            =>    $menu['menu_title'],
                'callback'              =>    $menu['callback'],
                'capability'            =>    'manage_options',
                'icon'                  =>    null,
                'position'              =>    '59.001',
            ) );

            // Adds another temp item to force menu for having sub menu
            $this->register_menu_page( array(
                'id'                    =>    '',
                'slug'                  =>    'extra' ,
                'parent'                =>    $this->main_admin_menu_slug,
                'name'                  =>    '',
                'page_title'            =>    '',
                'menu_title'            =>    '',
                'capability'            =>    'manage_options',
                'icon'                  =>    null,
                'position'              =>    '59.001',
            ) );

            // Add style for hiding temp sub menu with css
            bf_add_admin_css( '#adminmenu li#toplevel_page_'. str_replace( array( '/'), '-', $this->main_admin_menu_slug ) .' .wp-submenu li:nth-child(3){ display: none !important; }', true );
            bf_add_admin_css( '#adminmenu li#toplevel_page_'. str_replace( array( '/'), '-', $this->main_admin_menu_slug ) .' .wp-menu-image:before{ content: \'\e000\' !important; font-family: \'Better Studio Admin Icons\'; font-size: 15px; line-height: 21px;}', true );

        }else{

            foreach( $this->admin_menus as $menu_id => $menu ){

                // Adds main menu and update sub menu
                if( empty( $this->main_admin_menu_id ) ){

                    // Save main menu id that will be used for hiding
                    $this->main_admin_menu_id = 'better-studio/' . $menu['id'];

                    if( isset( $menu['slug'] ) )
                        $this->main_admin_menu_slug = $menu['slug'];
                    else
                        $this->main_admin_menu_slug = $this->main_admin_menu_id;

                    // Adds main better studio menu page
                    $this->register_menu_page( array(
                        'id'                    =>    $this->main_admin_menu_id,
                        'slug'                  =>    $this->main_admin_menu_slug,
                        'parent'                =>    false,
                        'name'                  =>    '<strong>Better</strong>Studio',
                        'page_title'            =>    '<strong>Better</strong>Studio',
                        'menu_title'            =>    '<strong>Better</strong>Studio',
                        'callback'              =>    $menu['callback'],
                        'capability'            =>    'manage_options',
                        'icon'                  =>    ''  ,
                        'position'              =>    '59.001',
                        'exclude_from_export'   =>    false,
                    ) );

                    // Updates main menu page for new main sub menu
                    $this->register_menu_page( array(
                        'id'                    =>    $this->main_admin_menu_id,
                        'slug'                  =>    $this->main_admin_menu_slug,
                        'parent'                =>    $this->main_admin_menu_slug,
                        'name'                  =>    $menu['name'],
                        'page_title'            =>    $menu['page_title'],
                        'menu_title'            =>    $menu['menu_title'],
                        'callback'              =>    $menu['callback'],
                        'capability'            =>    'manage_options',
                        'icon'                  =>    null,
                        'position'              =>    '59.001',
                        'exclude_from_export'   =>    false,
                    ));

                }
                // add sub menu for main menu
                else{

                    $menu['parent'] = $this->main_admin_menu_slug;

                    $this->register_menu_page( $menu );

                }
            }


        }

        // adding separator for main menu
        bf_add_admin_css( '
#adminmenu li#toplevel_page_'. str_replace( array( '/'), '-', $this->main_admin_menu_slug ) .' { margin-bottom: 10px !important; }
#adminmenu li#toplevel_page_'. str_replace( array( '/'), '-', $this->main_admin_menu_slug ) .' ul li a[href=sep]{
height: 0px;
border-top: 1px solid rgba(255, 255, 255, 0.1);
overflow: hidden;
margin: 5px 0;
pointer-events: none;
padding:0;
cursor: default;
}
', true );
        bf_add_admin_css( '#adminmenu li#toplevel_page_'. str_replace( array( '/'), '-', $this->main_admin_menu_slug ) .' .wp-menu-image:before{ content: \'\e000\' !important; font-family: \'Better Studio Admin Icons\'; font-size: 15px; line-height: 21px;}', true );

    }


    /**
     * Adds menu page or sub page to WordPress
     *
     * @since 1.4
     *
     * @param bool|array $menu
     */
    public function register_menu_page( $menu = false ){

        if( $menu == false )
            return;

        $menu['parent'] = isset( $menu['parent'] ) ? $menu['parent'] : false;

        // Prepares menu name
        $name 		= str_replace(
            array(
                '_',
                '-'
            ),
            array(
                ' ',
                ' '
            ),
            $menu['id']
        );

        $name = ucwords( $name );

        // Page title
        $menu['page_title'] = isset( $menu['page_title'] ) ? $menu['page_title'] : ucfirst( $menu['id'] );

        // Menu title
        $menu['menu_title'] = isset( $menu['menu_title'] ) ? $menu['menu_title'] : $name;

        // Page shown for users that hav this capabilities
        $menu['capability'] = isset( $menu['capability'] ) ? $menu['capability'] : 'manage_options';

        // Menu icon
        $menu['icon']   = isset( $menu['icon'] ) ?  $menu['icon']   : null;

        // Menu position in BetterStudio sub menu
        $menu['position']   = isset( $menu['position'] ) ?  $menu['position']   : 40;

        // prepare menu slug
        if( isset( $menu['slug'] ) ){
            $menu_slug = $menu['slug'];
        }else{
            $menu_slug  = 'better-studio/' . $menu['id'];
        }

        // prepare callback
        if( ! isset( $menu['callback'] ) ){
            $menu['callback'] = '';
        }

        if( $menu['parent'] == false ){

            call_user_func_array( 'add_' . 'menu' . '_page', array(
                    $menu['page_title'],
                    $menu['menu_title'],
                    $menu['capability'],
                    $menu_slug,
                    $menu['callback'],
                    $menu['icon'],
                    $menu['position']
                )
            );

        }else{

            call_user_func_array( 'add_' . 'sub' . 'menu' . '_page', array(
                    $menu['parent'],
                    $menu['page_title'],
                    $menu['menu_title'],
                    $menu['capability'],
                    $menu_slug,
                    $menu['callback']
                )
            );

        }

    }


    /**
     * Evaluate registered menus and adds smart separators
     */
    function prepare_menu_separators(){

        $important_pages = false; // Theme pages and other important pages

        $general_pages = false; // General pages

        $plugins_pages = false; // Plugin pages

        $unimportant_pages = false; // Unimportant pages

        foreach( $this->admin_menus as $menu ){

            // Important pages
            if( floatval( $menu['position'] ) > 0 && floatval( $menu['position'] ) < 50 ){
                $important_pages = true;
            }
            elseif( floatval( $menu['position'] ) > 50 && floatval( $menu['position'] ) < 80 ){
                $general_pages = true;
            }
            elseif( floatval( $menu['position'] ) > 80 && floatval( $menu['position'] ) < 100 ){
                $plugins_pages = true;
            }
            elseif( floatval( $menu['position'] ) >= 100 ){
                $unimportant_pages = true;
            }

        }

        if( $important_pages && $general_pages && $plugins_pages && $unimportant_pages ){
            $this->add_menu_separator( 49 );
            $this->add_menu_separator( 79 );
            $this->add_menu_separator( 99 );
        }

        elseif( ! $important_pages && $general_pages && $plugins_pages && $unimportant_pages ){
            $this->add_menu_separator( 79 );
            $this->add_menu_separator( 99 );
        }

        elseif( ! $important_pages && ! $general_pages && $plugins_pages && $unimportant_pages ){
            $this->add_menu_separator( 99 );
        }

        elseif( ! $important_pages && ! $general_pages && ! $plugins_pages && $unimportant_pages ){
            $this->add_menu_separator( 99 );
        }

        elseif( $important_pages && $general_pages && ! $plugins_pages && ! $unimportant_pages ){
            $this->add_menu_separator( 49 );
        }

        elseif( $important_pages && $general_pages && ! $plugins_pages && $unimportant_pages ){
            $this->add_menu_separator( 49 );
            $this->add_menu_separator( 99 );
        }

        elseif( $important_pages && $general_pages && $plugins_pages && ! $unimportant_pages ){
            $this->add_menu_separator( 79 );
        }

    }

    //
    //
    // Handy Functions
    //
    //


    /**
     * Handy function for sorting arrays with position sub value value
     *
     * @since 1.4
     *
     * @param $a
     * @param $b
     *
     * @return mixed
     */
    private function usort_cmp_by_position( $a, $b ){

        return floatval( $a["position"] ) > floatval( $b["position"] );

    }
}