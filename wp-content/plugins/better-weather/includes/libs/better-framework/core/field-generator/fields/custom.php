
<?php

echo $options['input'];

if( isset( $options['js-code'] ) ){

    Better_Framework()->assets_manager()->add_admin_js( $options['js-code'] );

}

if( isset( $options['css-code'] ) ){

    Better_Framework()->assets_manager()->add_admin_css( $options['css-code'] );

}