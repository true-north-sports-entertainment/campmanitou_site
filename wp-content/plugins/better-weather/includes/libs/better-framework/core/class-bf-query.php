<?php

//
// todo remove this class and functions outside of class
//

class BF_Query {


    /**
     * Get Pages
     *
     * @param array $extra Extra Options.
     *
     * @since 1.0
     * @return array
     */
    public static function get_pages( $extra = array() ){

        /*
            Extra Usage:

            array(
                'sort_order'        =>  'ASC',
                'sort_column'       =>  'post_title',
                'hierarchical'      =>  1,
                'exclude'           =>  '',
                'include'           =>  '',
                'meta_key'          =>  '',
                'meta_value'        =>  '',
                'authors'           =>  '',
                'child_of'          =>  0,
                'parent'            =>  -1,
                'exclude_tree'      =>  '',
                'number'            =>  '',
                'offset'            =>  0,
                'post_type'         =>  'page',
                'post_status'       =>  'publish'
            )

        */

        $output = array();

        $query  = get_pages( $extra );

        foreach( $query as $page ){

            $output[ $page->ID ] = $page->post_title;

        }

        return $output;

    }


    /**
     * Get Posts
     *
     * @param array $extra Extra Options.
     *
     * @since 1.0
     * @return array
     */
    public static function get_posts( $extra = array() ){

        /*
            Extra Usage:

            array(
                'posts_per_page'  => 5,
                'offset'          => 0,
                'category'        => '',
                'orderby'         => 'post_date',
                'order'           => 'DESC',
                'include'         => '',
                'exclude'         => '',
                'meta_key'        => '',
                'meta_value'      => '',
                'post_type'       => 'post',
                'post_mime_type'  => '',
                'post_parent'     => '',
                'post_status'     => 'publish',
                'suppress_filters' => true
            )
        */

        $output = array();

        $query  = get_posts( $extra );

        foreach ( $query as $post )
            $output[ $post->ID ] = $post->post_title;

        return $output;

    }


    /**
     * Get an link for a random post
     *
     * @param bool $echo
     * @return bool|string
     */
    static function get_random_post_link( $echo = true ){
        $query = new WP_Query(
            array(
                'orderby' => 'rand',
                'posts_per_page' => '1'
            )
        );

        if( $echo )
            echo get_permalink($query->posts[0]);
        else
            return get_permalink($query->posts[0]);
    }


    /**
     * Get categories
     *
     * @param array $extra Extra Options.
     *
     * @since 1.0
     * @return array
     */
    public static function get_categories( $extra = array()) {

        /*
            Extra Usage:

            array(
                'type'          => 'post',
                'child_of'      => 0,
                'parent'        => '',
                'orderby'       => 'name',
                'order'         => 'ASC',
                'hide_empty'    => 1,
                'hierarchical'  => 1,
                'exclude'       => '',
                'include'       => '',
                'number'        => '',
                'taxonomy'      => 'category',
                'pad_counts'    => false
            )
        */

        $output = array();

        $query  = get_categories( $extra );

        foreach ( $query as $cat ){

            $output[ $cat->cat_ID ] = $cat->name;

        }

        return $output;

    }


    /**
     * Get categories
     *
     * @param array $extra Extra Options.
     *
     * @since 1.0
     * @return array
     */
    public static function get_categories_by_slug( $extra = array() ){

        /*
            Extra Usage:

            array(
                'type'          => 'post',
                'child_of'      => 0,
                'parent'        => '',
                'orderby'       => 'name',
                'order'         => 'ASC',
                'hide_empty'    => 1,
                'hierarchical'  => 1,
                'exclude'       => '',
                'include'       => '',
                'number'        => '',
                'taxonomy'      => 'category',
                'pad_counts'    => false
            )
        */

        $output = array();

        $query  = get_categories( $extra );

        foreach ( $query as $cat )
            $output[ $cat->slug ] = $cat->name;

        return $output;

    }


    /**
     * Get Tags
     *
     * @param array $extra Extra Options.
     *
     * @since 1.0
     * @return mixed
     */
    public static function get_tags( $extra = array() )	{

        $output = array();
        $query  = get_tags( $extra );

        foreach ( $query as $tag )
            $output[ $tag->term_id ] = $tag->name;

        return $output;

    }


    /**
     * Get Tags
     *
     * @param array $extra Extra Options.
     * @param array|bool $advanced_ouput Advanced Query is the results with query other resutls
     *
     * @since 1.0
     * @return array
     */
    public static function get_users( $extra = array(), $advanced_ouput = false ){

        $output = array();

        if ( count( $extra ) === 0)
            $extra = array( 'orderby' => 'post_count', 'order' => 'DESC' );

        $query = new WP_User_Query( $extra );

        foreach ( $query->results as $user )
            $output[ $user->data->ID ] = $user->data->display_name;


        if ( $advanced_ouput ) {
            // Unset the result for make free the memory
            unset( $query->results );
            return array( $output, $query );
        }

        return $output;

    }


    /**
     * Get Post Types
     *
     * @param array $extra Extra Options.
     *
     * @since 1.0
     * @return array
     */
    public static function get_post_types( $extra = array() ){

        $output = array();

        if ( !isset( $extra['exclude'] ) || !is_array( $extra['exclude'] ) )
            $extra['exclude'] = array();

        $query = get_post_types();

        foreach ( $query as $key => $val ) {
            if ( in_array( $key, array_merge( $extra['exclude'], array( 'revision', 'nav_menu_item', 'attachment' ) ) ) )
                continue;

            $output[ $key ] = ucfirst( $val );
        }

        return $output;

    }


    /**
     * Get Page Templates
     *
     * @param array $extra Extra Options.
     *
     * @since 1.0
     * @return mixed
     */
    public static function get_page_templates( $extra = array() ){

        $output = array();

        if ( !isset( $extra['exclude'] ) || !is_array( $extra['exclude'] ) )
            $extra['exclude'] = array();

        $query = wp_get_theme()->get_page_templates();

        foreach ( $query as $key => $val) {
            if (in_array( $key, $extra['exclude']))
                continue;
            $output[ $key ] = $val;
        }

        return $output;

    }


    /**
     * Get Taxonomies
     *
     * @param array $extra Extra Options.
     *
     * @since 1.0
     * @return array
     */
    public static function get_taxonomies( $extra = array() ){

        $output = array();
        $query  = get_taxonomies();

        if ( !isset( $extra['exclude'] ) || !is_array( $extra['exclude'] ) )
            $extra['exclude'] = array();

        foreach ( $query as $key => $val) {
            if (in_array( $key, $extra['exclude']))
                continue;
            $output[ $key ] = ucfirst( str_replace( '_', ' ', $val ) );
        }

        return $output;

    }


    /**
     * Get All Terms of Specific Taxonomy
     *
     * @param array|string $tax Taxonomy Slug
     * @param array $extra Extra Options.
     *
     * @since 1.0
     * @return array
     */
    public static function get_terms( $tax = 'category', $extra = array() ){

        if ( !isset( $extra['exclude']) || !is_array( $extra['exclude'] ) )
            $extra['exclude'] = array();

        $query  = get_terms( $tax, $extra );
        $output = array();

        foreach ( $query as $taxonomy) {
            if (in_array( $taxonomy->slug, $extra['exclude'] ) )
                continue;
            $output[ $taxonomy->slug ] = $taxonomy->name;
        }

        return $output;

    }



    /**
     * Get Roles
     *
     * @param array $extra Extra Options.
     *
     * @since 1.0
     * @return array
     */
    public static function get_roles( $extra = array() ){

        global $wp_roles;
        $output = array();

        if ( !isset( $extra['exclude'] ) || !is_array( $extra['exclude'] ) )
            $extra['exclude'] = array();

        foreach ( $wp_roles->roles as $key => $val ) {
            if (in_array( $key, $extra['exclude'] ) )
                continue;

            $output[ $key ] = $val['name'];
        }

        return $output;

    }


    /**
     * Get Menus
     *
     * @param bool $hide_empty
     *
     * @since 1.0
     * @return array
     */
    public static function get_menus( $hide_empty = false ){

        $output = array();

        $menus = get_terms( 'nav_menu', array( 'hide_empty' => $hide_empty ) );

        foreach( $menus as $menu ):

            $output[$menu->term_id] = $menu->name;

        endforeach;

        return $output;

    }


    /**
     * Used to detect category from id
     *
     * @param null $id
     * @return bool|mixed
     */
    public static function is_a_category( $id = null ){

        if( is_null( $id ) ){
            return false;
        }

        $cat = get_category( $id );

        if( count( $cat ) > 0 ){
            return current( $cat );
        } else{
            return false;
        }

    }


    /**
     * Used to detect tag from id
     *
     * @param null $id
     * @return bool|mixed
     */
    public static function is_a_tag( $id = null ){

        if( is_null( $id ) ){
            return false;
        }

        $tag = get_tag( $id );

        if( count( $tag ) > 0 ){
            return current( $tag );
        } else{
            return false;
        }

    }


    /**
     * Used to find list of all RevolutionSlider Sliders.zip
     *
     * @return array
     */
    public static function get_rev_sliders(){

        global $wpdb;

        $sliders = array();

        if( function_exists('rev_slider_shortcode') ){

            $temp_sliders = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'revslider_sliders' );

            if( $temp_sliders ){

                foreach( $temp_sliders as $slider ){

                    $sliders[$slider->alias] = $slider->title;

                }

            }
        }

        return $sliders;

    }


}