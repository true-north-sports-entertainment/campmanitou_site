<?php
$value = !empty( $options['value'] ) ? $options['value'] : '';

foreach ( $options['options'] as $key => $item ) {
    $is_checked  	= !empty( $value ) && ($key==$value);

    $input  = Better_Framework::html()->add( 'input' )->type( 'radio' )->name( $options['input_name'] )->value( $key );

    if( isset( $options['input_class'] ) )
        $input->class($options['input_class']);

    if( $is_checked )
        $input->attr( 'checked', 'checked' );

    $image  = Better_Framework::html()->add( 'img' )->src( $item['img'] )->alt( $item['label'] )->title( $item['label'] );
    $label  = Better_Framework::html()->add( 'label' );

    $label->text( $input );
    $label->text( $image );
    if(isset($item['label'])){
        $p  = Better_Framework::html()->add( 'p' )->text( $item['label'] )->class('item-label');
        $label->text( $p );
    }

    $object = Better_Framework::html()->add( 'div' )->class( 'bf-image-radio-option' );

    if( $is_checked )
        $object->class( 'checked' );

    $object->text( $label->display() );

    echo $object->display();
}