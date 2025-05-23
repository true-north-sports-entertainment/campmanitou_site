<?php
$default_lang = 'text/html';
if ( empty( $options['language'] ) ) {
    $lang = $default_lang;
} else {
    switch ( $options['language'] ) {
        case ('xml'):
        case ('html'):
            $lang = 'text/html';
            break;

        case ('javascript'):
        case ('json'):
        case ('js'):
            $lang = 'text/javascript';
            break;

        case ('php'):
            $lang = 'application/x-httpd-php';
            break;

        case ('css'):
            $lang = 'text/css';
            break;

        case ('sql'):
            $lang = 'text/x-sql';
            break;

        default:
            $lang = $default_lang;
            break;
    }
}

$textarea = Better_Framework::html()->add( 'textarea' )->class( 'bf-code-editor' )->name( $options['input_name'] );

$line_numbers	 	 = !empty( $options['line_numbers'] ) 	   	 ? 'enable' : 'disable';
$auto_close_brackets = !empty( $options['auto_close_brackets'] ) ? 'enable' : 'disable';
$auto_close_tags	 = !empty( $options['auto_close_tags'] )	 ? 'enable' : 'disable';

// Set editor language
$textarea->data( 'lang', $lang );

// Set editor line number feature
$textarea->data( 'line-numbers',$line_numbers );

// Set editor auto close brackets feature
$textarea->data( 'auto-close-brackets', $auto_close_brackets );

// Set editor auto close tags feature
$textarea->data( 'auto-close-tags', $auto_close_tags );

if( !empty( $options['placeholder'] ) )
    $textarea->placeholder( $options['placeholder'] );

if( !empty( $options['value'] ) )
    $textarea->val( $options['value'] );

echo $textarea->display();