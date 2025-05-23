<?php
$value = isset( $options['value'] ) ? $options['value'] : array();

$field_options = bf_sort_array_by_array( $options['options'], $value);

foreach ( $field_options as $key => $item ) {
    $is_checked  	= !empty( $value[ $key ] ) && $value[ $key ] != 0;
    $input  = Better_Framework::html()->add( 'input' )->type( 'checkbox' )->name( sprintf( $options['input_name'], $key ) );

    if( $is_checked )
        $input->attr( 'checked', 'checked' );

    $image  = Better_Framework::html()->add( 'img' )->src( $item['img'] )->alt( $item['label'] )->title( $item['label'] );
    $label  = Better_Framework::html()->add( 'label' );

    $label->text( $input );
    $label->text( $image );

    $object = Honar::html()->add( 'div' )->class( 'bf-image-checkbox-option' );

    if( $is_checked  )
        $object->class( 'checked' );

    $object->text( $label->display() );

    echo $object->display();
}