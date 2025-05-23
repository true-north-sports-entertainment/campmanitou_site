<?php
if( empty( $options['options'] ) )
    return;

$value 		   = isset( $options['value'] )? explode( ',', $options['value'] ) : array();

$check_all = count( $value ) ? false : true;

$groups_ids	   = array();

$input   = Better_Framework::html()->add( 'input' )->type( 'hidden' )->name( $options['input_name'] )->attr( 'value', implode( ',', $value ) );

if( isset( $options['input_class'] ) )
    $input->class($options['input_class']);

echo $input->display();

?>
<div class="bf-sorter-groups-container">
    <ul id="bf-sorter-group-<?php echo $options['id']; ?>" class="bf-vc-sorter-list bf-vc-sorter-checkbox-list bf-sorter-<?php echo $options['id']; ?>" >
        <?php
        // Options That Saved Before
        foreach( $value as $item_id => $item ) {
            if( ! $item ) continue;
            ?>
            <li id="bf-sorter-group-item-<?php echo $options['id']; ?>-<?php echo $item; ?>" class="<?php echo isset( $options['options'][$item]['css-class'] ) ? $options['options'][$item]['css-class'] : ''; ?> item-<?php echo $item_id; ?> checked-item" style="<?php echo isset( $options['options'][$item]['css'] ) ? $options['options'][$item]['css'] : ''; ?>">
                <label>
                    <input name="<?php echo $item; ?>" value="1" type="checkbox" checked="checked" />
                    <?php echo $options['options'][$item]['label']; ?>
                </label>
            </li>
            <?php
            unset( $options['options'][$item] ) ;
        }

        // Options That Not Saved but are Active
        foreach( $options['options'] as $item_id => $item ) {

            // Skip Disabled Items
            if( isset( $item['css-class'] ) && strpos( $item['css-class'], 'active-item' ) === false ) continue;
            ?>
            <li id="bf-sorter-group-item-<?php echo $options['id']; ?>-<?php echo $item_id; ?>" class="<?php echo isset( $item['css-class'] ) ? $item['css-class'] : ''; ?> item-<?php echo $item_id; ?>" style="<?php echo isset( $item['css'] ) ? $item['css'] : ''; ?>">
                <label>
                    <input name="<?php echo $item_id; ?>" value="1" type="checkbox" <?php echo $check_all ? ' checked="checked" ' : ''; ?>/>
                    <?php echo is_array( $item) ? $item['label'] : $item; ?>
                </label>
            </li>
            <?php

            unset( $options['options'][$item_id] ) ;
        }

        // Disable Items
        foreach( $options['options'] as $item_id => $item ) { ?>
            <li id="bf-sorter-group-item-<?php echo $options['id']; ?>-<?php echo $item_id; ?>" class="<?php echo isset( $item['css-class'] ) ? $item['css-class'] : ''; ?> item-<?php echo $item_id; ?>" style="<?php echo isset( $item['css'] ) ? $item['css'] : ''; ?>">
                <label>
                    <input name="<?php echo $item_id; ?>" value="0" type="checkbox" disabled />
                    <?php echo is_array( $item) ? $item['label'] : $item; ?>
                </label>
            </li>
        <?php
        }

        ?>
    </ul>
</div>
