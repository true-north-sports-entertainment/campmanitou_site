<div class="bf-ajax_action-field-container"><?php

    if( isset( $options['confirm'] ) ){
        $confirm = ' data-confirm="' . $options['confirm'] . '" ';
    }else{
        $confirm = '';
    }
?>
    <a class="bf-action-button bf-button bf-main-button" data-callback="<?php echo $options['callback']; ?>" <?php echo $confirm; ?>><?php echo $options['button-name']; ?></a>
</div>
