<?php

$list_style = 'grid-2-column';
if( isset($options['list_style']) && !empty($options['list_style']) ){
    $list_style = $options['list_style'];
}

// default selected
$current = array(
    'key' => '' ,
    'label' => isset($options['default_text']) && ! empty($options['default_text'])? $options['default_text'] : __( 'chose one...' , 'better-studio' ) ,
    'img' => ''
);

if( isset($options['value']) && ! empty($options['value']) ){
    if( isset($options['options'][$options['value']]) ){
        $current = $options['options'][$options['value']];
        $current['key'] =  $options['value'];
    }
}
$select_options = '';
foreach( (array)$options['options'] as $key => $option ){
    $select_options .= '<li data-value="'. $key .'" data-label="'. $option['label'] .'" class="image-select-option '. ($key==$current['key']?'selected':'') .'">
        <img src="'. $option['img'] .'" alt="'. $option['label'] .'"/><p>'. $option['label'] .'</p>
    </li>';
}

echo '<div class="better-select-image"><div class="select-options">
<span class="selected-option">'. $current['label'] .'</span>
    <div class="better-select-image-options"><ul class="options-list '. $list_style .' bf-clearfix">'. $select_options .'</ul>
    </div>
</div>
<input type="hidden" name="'. $options['input_name'] .'" id="'. $options['input_name'] .'" value="'. $current['key'] .'"/>
</div>';

