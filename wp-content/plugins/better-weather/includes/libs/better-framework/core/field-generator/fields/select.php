<?php
if( empty( $options['options'] ) )
    return;

$select = Better_Framework::html()->add( 'select' )->name( $options['input_name'] );

if( isset( $options['input_class'] ) )
    $select->class( $options['input_class'] );

if( isset( $options['multiple'] ) && $options['multiple'] ){
    $select->attr( 'multiple', 'multiple' );
}

$val = empty( $options['value'] ) ? '' : $options['value'];

foreach( $options['options'] as $option_id => $option_val ){

    if( $option_id === 'category_walker' ){

        $r = array('orderby' => 'name', 'hierarchical' => 1, 'selected' => $val, 'show_count' => 0);

        // categories list
        $cats_list = walk_category_dropdown_tree( get_terms('category', $r), 0, $r);

        $select->text( $cats_list );
        continue;

    }

    if( is_array( $option_val ) && isset( $option_val['disabled'] ) ){

        $select->text( '<option value="'.$option_id.'" '.( $val == $option_id ? 'selected="selected"' : '' ).' '.( $option_val['disabled'] ? 'disabled="disabled"' : '' ).'>'. $option_val['label'] .'</option>' );

    }elseif( is_array( $option_val ) ){

        if( ! isset( $option_val['options'] ) && ! isset( $option_val['label'] ) )
            continue;

        $select->text( '<optgroup label="' . $option_val['label'] . '">' );

        foreach( $option_val['options'] as $_option_id => $_option_val ){

            if( $_option_id === 'category_walker' ){

                $r = array('orderby' => 'name', 'hierarchical' => 1, 'selected' => $val, 'show_count' => 0);

                // categories list
                $cats_list = walk_category_dropdown_tree(get_terms('category', $r), 0, $r);

                $select->text( $cats_list );
                continue;

            }else{

               $select->text( '<option value="'.$_option_id.'" '.( $val == $_option_id ? 'selected="selected"' : '' ).'>'. $_option_val .'</option>' );

            }
        }

        $select->text( '</optgroup>' );

    }else{
        $select->text( '<option value="'.$option_id.'" '.( $val == $option_id ? 'selected="selected"' : '' ).'>'. $option_val .'</option>' );
    }

}

echo '<div class="bf-select-option-container">';
echo $select->display();
echo '</div>';
echo $this->get_filed_input_desc( $options );