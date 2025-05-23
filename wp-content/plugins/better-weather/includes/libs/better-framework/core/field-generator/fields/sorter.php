<?php
	if( empty( $options['options'] ) )
		return;

	$value 		   = isset( $options['value'] ) && is_array( $options['value'] ) ? $options['value'] : array();
	$groups_ids	   = array();
?>

<div class="bf-sorter-groups-container">
    <ul id="bf-sorter-group-<?php echo $options['id']; ?>" class="bf-sorter-list bf-sorter-<?php echo $options['id']; ?>" >
        <?php
        if ( is_array( $value) && count( $value) > 0 ) {

            foreach( $value as $item_id => $item ) { ?>
                <li id="bf-sorter-group-item-<?php echo $options['id']; ?>-<?php echo $item_id; ?>" class="<?php echo isset( $options['options'][$item_id]['css-class'] ) ? $options['options'][$item_id]['css-class'] : ''; ?>" style="<?php echo isset( $options['options'][$item_id]['css'] ) ? $options['options'][$item_id]['css'] : ''; ?>">
                    <?php echo is_array( $item) ? $item['label'] : $item; ?>
                    <input name="<?php echo $options['input_name']?>[<?php echo $item_id; ?>]" value="<?php echo is_array( $item) ? $item['label'] : $item; ?>" type="hidden"/>
                </li>
            <?php }
        }
        else {
            foreach( $options['options'] as $item_id => $item ) { ?>
                <li id="bf-sorter-group-item-<?php echo $options['id']; ?>-<?php echo $item_id; ?>" class="<?php echo isset( $item['css-class'] ) ? $item['css-class'] : ''; ?>" style="<?php echo isset( $item['css'] ) ? $item['css'] : ''; ?>">
                    <?php echo is_array( $item) ? $item['label'] : $item; ?>
                    <input name="<?php echo $options['input_name']?>[<?php echo $item_id; ?>]" value="<?php echo is_array( $item) ? $item['label'] : $item; ?>" type="hidden"/>
                </li>
            <?php }
        }
        ?>
    </ul>
</div>
