<?php
$wrapper = Better_Framework::html()->add( 'div' )->class( 'bf-clearfix bf-color-picker-container' );
$input   = Better_Framework::html()->add( 'input' )->type( 'text' )->name( $options['input_name'] )->class( 'bf-color-picker' );

if( isset( $options['input_class'] ) )
    $input->class($options['input_class']);

$preview = Better_Framework::html()->add( 'div' )->class( 'bf-color-picker-preview' );

if(  !empty( $options['value'] ) ) {
    $input->value( $options['value'] )->css('border-color', $options['value']);
    $preview->css( 'background-color', $options['value'] );
}

$wrapper->add( $input );
$wrapper->add( $preview );

echo $wrapper->display();