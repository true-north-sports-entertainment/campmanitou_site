<?php

// Default selected
$current = array(
    'key'   =>  '' ,
    'title' =>  __( 'Chose an Icon', 'better-studio' ) ,
);


if( isset($options['value']) && ! empty($options['value']) ){

    Better_Framework::factory('icon-factory');

    $fontawesome  = BF_Icons_Factory::getInstance('fontawesome');


    if( isset( $fontawesome->icons[$options['value']] ) ){

        $current['key']     =  $options['value'];

        $current['title']   =  $fontawesome->getIconTag($options['value']) . $fontawesome->icons[$options['value']]['label'];
    }
}

$icon_handler = 'bf-icon-modal-handler-' . rand( 1, 999999999 );

?>
<div class="bf-icon-modal-handler" id="<?php echo $icon_handler; ?>">

    <div class="select-options">
        <span class="selected-option"><?php echo $current['title']; ?></span>
    </div>

    <input type="hidden" class="icon-input" data-label="<?php echo esc_attr( $current['title'] ); ?>" name="<?php echo $options['input_name']; ?>" id="<?php echo $options['input_name']; ?>" value="<?php echo $current['key']; ?>" />

</div><!-- modal handler container -->
<?php

$this->add_modal( 'icon' );
