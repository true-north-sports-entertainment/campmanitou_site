<?php

/**
 * Handles generation off all icons
 */
class BF_Icons_Factory {


    /**
     * Inner array of icons instances
     *
     * @var array
     */
    private static $instances = array();


    /**
     * used for getting instance of a type of icons
     *
     * @param string $icon
     * @return bool
     */
    public static function getInstance( $icon = '' ){

        if( empty( $icon ) )
            return false;

        $_icon = $icon;

        $icon = ucfirst($icon);

        if ( !isset( self::$instances[$icon]) || is_null( self::$instances[$icon] ) ){

            if(!class_exists('BF_'.$icon))
                require_once BF_PATH . 'libs/icons/class-bf-'.$_icon.'.php';

            $class = 'BF_' . $icon;
            self::$instances[$icon] = new $class;
        }

        return self::$instances[$icon];
    }


    /**
     * Handy function for creating icon tag from id
     *
     * @param $id
     * @param string $class
     *
     * @return string
     */
    public function get_icon_tag_from_id( $id, $class = '' ){

        $id = trim( $id );

        // Fontawesome icon
        if( substr( $id, 0, 3 ) == 'fa-' ){

            return '<i class="bf-icon '. $class .' fa '. $id .'"></i>';

        }

        // Better Social Font Icon
        elseif( substr( $id, 0, 5 ) == 'bsfi-' ){

            return '<i class="bf-icon '. $class .' '. $id .'"></i>';

        }

        // Dashicon
        elseif( substr( $id, 0, 10 ) == 'dashicons-' ){

            return '<i class="bf-icon '. $class .' dashicons dashicons-'. $id .'"></i>';

        }

        // Better Studio Admin Icon
        elseif( substr( $id, 0, 5 ) == 'bsai-' ){

            return '<i class="bf-icon '. $class .' '. $id .'"></i>';

        }

        return '';

    }

}