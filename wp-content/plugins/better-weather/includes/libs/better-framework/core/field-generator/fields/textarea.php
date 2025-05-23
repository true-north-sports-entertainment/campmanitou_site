<?php

$object = Better_Framework::html()->add( 'textarea' );

if( $options['value'] !== false )
    $object->val( $options['value'] );

if( isset($options['rtl']) && $options['rtl'] !== false)
    $object->class( 'rtl' );

if( isset($options['ltr']) && $options['ltr'] !== false)
    $object->class( 'ltr' );

$object->name( $options['input_name'] );

$output = '';

$output .= $object->display();

echo $output;
echo $this->get_filed_input_desc( $options );