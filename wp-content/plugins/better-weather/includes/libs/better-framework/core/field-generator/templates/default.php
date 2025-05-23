<?php 
$classes = $this->get_classes( $options );
$iri     = isset( $options['repeater_item'] ) && $options['repeater_item'] == true; // Is this section for a repeater item

$section_classes  = $classes['section'];

$heading_classes  = $classes['heading'];
$controls_classes = $classes['controls'];
$explain_classes = $classes['explain'];

if( $iri ) {

    $section_classes  .= ' ' . $classes['repeater-section'];
    $heading_classes  .= ' ' . $classes['repeater-heading'];
    $controls_classes .= ' ' . $classes['repeater-controls'];
    $explain_classes  .= ' ' . $classes['repeater-explain'];

} else {

    $section_classes  .= ' ' . $classes['nonrepeater-section'];
    $heading_classes  .= ' ' . $classes['nonrepeater-heading'];
    $controls_classes .= ' ' . $classes['nonrepeater-controls'];
    $explain_classes  .= ' ' . $classes['nonrepeater-explain'];

}

$section_classes  .= ' ' . $classes['section-class-by-filed-type'];
$heading_classes  .= ' ' . $classes['heading-class-by-filed-type'];
$controls_classes .= ' ' . $classes['controls-class-by-filed-type'];
$explain_classes  .= ' ' . $classes['explain-class-by-filed-type'];

if( ! isset( $options['desc'] )  || empty( $options['desc'] )  ){
    $controls_classes .= ' ' . 'no-desc';
}


$section_css = '';

if( isset( $options['section-css'] ) ){


    $section_css = 'style="';

    foreach( (array) $options['section-css'] as $css_id => $css_code ){

        $section_css .= $css_id . ':' . $css_code . ';';

    }

    $section_css = '"';
}

?>
<div class="bf-section-container bf-clearfix" <?php  echo $section_css; ?>>
    <div class="<?php echo $section_classes; ?> bf-clearfix" data-id="<?php echo $options['id']; ?>">

        <div class="<?php echo $heading_classes; ?> bf-clearfix">
            <h3><label><?php echo $options['name']; ?></label></h3>
        </div>

        <div class="<?php echo $controls_classes; ?> bf-clearfix">
            <?php echo $input; ?>
        </div>

        <?php if ( !empty( $options['desc'] ) ) { ?>
        <div class="<?php echo $explain_classes; ?> bf-clearfix"><?php echo $options['desc']; ?></div>
        <?php } ?>

    </div>
</div>