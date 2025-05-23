<?php

/**
 * Front Site Walker
 */
class BF_Menu_Walker extends Walker_Nav_Menu{

    /**
     * item is in a mega menu
     *
     * @var bool
     */
    public $in_mega_menu = false;


    /**
     * Holds current menu item
     *
     * @var array
     */
    public $current_item;


    /**
     * Stores mega menu inner-data
     */
    public $last_lvl;


    /**
     * Show parent items description
     */
    public $show_desc_parent = false;


    function __construct(){

        $this->show_desc_parent = apply_filters( 'better-framework/menu/show-parent-desc', $this->show_desc_parent );

    }


    /**
     * Starts the list before the elements are added.
     *
     * @see Walker_Nav_Menu::start_lvl()
     * @see Walker::start_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ){

        $item_output = '';

        parent::start_lvl( $item_output, $depth, $args );

        if( $this->in_mega_menu ){

            if( $depth >= 1 ){
                $this->last_lvl .= $item_output;
            }

            return;
        }

        $output .= $item_output;
    }


    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker_Nav_Menu::end_lvl()
     * @see Walker::end_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ){

        $item_output = '';

        parent::end_lvl( $item_output, $depth, $args );

        if( $this->in_mega_menu ){

            if( $depth == 0 ){

                $output .= apply_filters( 'better-framework/menu/mega/end_lvl', array(
                    'sub_menu'  => $this->last_lvl,
                    'item'      => $this->current_item )
                );

                $this->last_lvl = '';

                return;
            }

            $this->last_lvl .= $item_output;

            return;
        }

        $output .= $item_output;
    }


    /**
     * Start the element output.
     *
     * @see Walker_Nav_Menu::start_el()
     * @see Walker::start_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){

        // add specific class for identical usages for categories
        if( $item->object == 'category' ){
            $item->classes = array_merge( (array) $item->classes, array( 'menu-term-' . $item->object_id ) );
        }

        // Delete item title when hiding title set
        if( ! isset( $item->hide_menu_title ) || $item->hide_menu_title == 1 ){
            $item->classes = array_merge((array) $item->classes, array('menu-title-hide'));
            $item->title = '<span class="hidden">' . $item->title . '</span>';
        }

        // Generate Badges html
        if( isset( $item->badge_label ) && ! empty( $item->badge_label ) ){

            if( ! isset( $_temp_args ) )
                $_temp_args = clone( (object) $args );

            if( $item->badge_position == 'right' )
                $_temp_args->link_after .= $this->generate_badge_HTML( $item->badge_label ) . $_temp_args->link_before;
            else
                $_temp_args->link_before .= $this->generate_badge_HTML( $item->badge_label ) . $_temp_args->link_before;

            $item->classes = array_merge( (array) $item->classes, array( 'menu-have-badge') );
            $item->classes = array_merge( (array) $item->classes, array( 'menu-badge-' . $item->badge_position ) );
        }

        // Generate Icons HTML
        if( isset( $item->menu_icon ) && ( $item->menu_icon != 'none') ){
            if( ! isset( $_temp_args ) )
                $_temp_args = clone( (object) $args );
            $_temp_args->link_before .= $this->generate_icon_HTML( $item->menu_icon , $item->menu_icon_pos ) . $_temp_args->link_before;
            $item->classes = array_merge((array) $item->classes, array('menu-have-icon'));
        }

        // Add description to parent items
        if( $depth == 0 && $this->show_desc_parent && isset( $item->description ) && ! empty( $item->description ) ){

            if( ! isset( $_temp_args ) )
                $_temp_args = clone( (object) $args );

            $_temp_args->link_after .= '<span class="description">' . $item->description . '</span>';
            $item->classes = array_merge( (array) $item->classes, array('menu-have-description') );
        }

        // continue with new args that changed
        if( isset( $_temp_args ) ){
            parent::start_el($item_output, $item, $depth, $_temp_args , $id);
        }else{
            parent::start_el($item_output, $item, $depth, $args, $id);
        }

        if( $depth == 0 ){
            $this->in_mega_menu = false;
            $this->current_item = null;
        }

        // is a mega menu parent?
        if( $item->mega_menu != '' && $item->mega_menu != 'disabled' && $depth == 0 ){
            $this->in_mega_menu = true;
            $this->current_item = $item;
        }

        // in mega menu
        if( $this->in_mega_menu && $depth > 0 ){
            $this->last_lvl .= $item_output;
            return;
        }

        $output .= $item_output;
    }


    /**
     * Ends the element output, if needed.
     *
     * @see Walker_Nav_Menu::end_el()
     * @see Walker::end_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function end_el( &$output, $item, $depth = 0, $args = array() ){

        $item_output = '';
        parent::end_el( $item_output, $item, $depth, $args );

        if( $this->in_mega_menu && $depth > 0 ){
            $this->last_lvl .= $item_output;
            return;
        }

        $output .= $item_output;
    }


    /**
     * Used for generating custom badge html
     *
     * @param $badge_label
     * @return string
     */
    public function generate_badge_HTML( $badge_label ){

        return '<span class="better-custom-badge ">'. $badge_label .'</span>';

    }


    /**
     * Used for generating custom icon html
     *
     * @param $menu_icon
     * @param $menu_icon_pos
     * @return string
     */
    public function generate_icon_HTML( $menu_icon , $menu_icon_pos ){

        return '<i class="fa '. $menu_icon .'"></i>';

    }

}