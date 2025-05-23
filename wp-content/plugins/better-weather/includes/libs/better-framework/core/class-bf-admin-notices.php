<?php

/**
 * Handles all message showing in admin panel
 */
class BF_Admin_Notices{

    function __construct(){

        add_action( 'admin_notices', array( $this, 'show_notice' ) );

        add_action( 'switch_theme', array( $this, 'delete_deferred_notices' ) );

    }


    /**
     * Removes all BF deferred notices before deactivate theme
     */
    function delete_deferred_notices(){

        delete_option( '__better_framework__deferred_notices' );

    }


    /**
     * Adds notice to showing queue
     *
     * @param $notice
     */
    function add_notice( $notice ){

        if( isset( $notice['msg'] ) ){

            $notices =  get_option( '__better_framework__deferred_notices', array() );

            if( isset( $notice['id'] ) ){
                $notices[$notice['id']] = $notice;
            }else{
                $notices[] = $notice;
            }

            update_option( '__better_framework__deferred_notices', $notices );

        }

    }


    /**
     * remove notice
     *
     * @param $id
     */
    function remove_notice( $id = null ){

        if( is_null( $id ) ){
            return;
        }

        $notices = get_option( '__better_framework__deferred_notices', array() );

        if( isset( $notices[$id] ) ){

            unset( $notices[$id] );

            update_option( '__better_framework__deferred_notices', $notices );

        }

    }


    /**
     * Shows notice
     */
    function show_notice(){

        $notices = get_option( '__better_framework__deferred_notices', array() );

        $notices = apply_filters( 'better-framework/admin-notices', $notices );

        if( count( $notices ) > 0 ){

            foreach( $notices as $notice ){

                if( ! isset( $notice['class'] ) )
                    $notice['class'] = 'updated';

                ?>
                <div class="<?php echo $notice['class']; ?>">
                    <?php echo wpautop( $notice['msg'] ); ?>
                </div>
                <?php

            }

            delete_option( '__better_framework__deferred_notices' );

        }

    }

}