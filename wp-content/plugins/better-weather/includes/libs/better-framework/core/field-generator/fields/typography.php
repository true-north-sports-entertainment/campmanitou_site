<?php
if( ! isset( $options['value']['family'] ) ){

    $options['value']['family'] = 'Lato';
    $options['value']['variant'] = '';

}

// prepare std id
if( isset( $panel_id ) ){

    $std_id = Better_Framework::options()->get_std_field_id( $panel_id );

}else {

    $std_id = 'css';

}


$enabled = false;

if( isset( $options[ $std_id ] ) ){
    if( isset( $options[ $std_id ]['enable'] ) ){
        $enabled = true;
    }
}
elseif( isset( $options[ 'std' ] ) ){
    if( isset( $options[ 'std' ]['enable'] ) ){
        $enabled = true;
    }
}

if( $enabled && ! isset( $options['value']['enable'] ) ){
    $options['value']['enable'] = $options[ 'std' ]['enable'];
}

// Get current font
$font = Better_Framework()->fonts_manager()->get_font( $options['value']['family'] );

if( $enabled ){ ?>
<div class="typo-fields-container bf-clearfix">
<div class="typo-field-container">
    <div class="typo-enable-container"><?php

        $hidden = Better_Framework::html()->add( 'input' )->type( 'hidden' )->name( $options['input_name'] . '[enable]' )->val('0');

        $checkbox = Better_Framework::html()->add( 'input' )->type( 'checkbox' )->name( $options['input_name'] . '[enable]' )->val('1')->class('checkbox');
        if( $options['value']['enable'] )
            $checkbox->attr( 'checked', 'checked');

        ?>
        <div class="bf-switch bf-clearfix">
            <label class="cb-enable <?php echo $options['value']['enable'] ? 'selected' : ''; ?>"><span><?php _e( 'Enable', 'better-studio' ); ?></span></label>
            <label class="cb-disable <?php echo ! $options['value']['enable'] ? 'selected' : ''; ?>"><span><?php _e( 'Disable', 'better-studio' ); ?></span></label>
            <?php
            echo $hidden->display();
            echo $checkbox->display();

            ?>
        </div>
    </div>
</div>
</div>
<?php
} ?>
<div class="typo-fields-container bf-clearfix">
    <span class="enable-disable"></span>
    <div class="typo-field-container font-family-container">
        <label><?php _e('Font Family:', 'better-studio'); ?></label>
        <select name="<?php echo $options['input_name']; ?>[family]" id="<?php echo $options['input_name']; ?>-family" class="font-family <?php if( is_rtl() ) echo 'chosen-rtl'; ?>">
            <?php

            // All google fonts
            if( $font['type'] == 'theme-font' ){
                echo Better_Framework()->fonts_manager()->theme_fonts()->get_fonts_family_option_elements( $options['value']['family'] );
            }else{
                echo Better_Framework()->fonts_manager()->theme_fonts()->get_fonts_family_option_elements();
            }

            // All google fonts
            if( $font['type'] == 'custom-font' ){
                echo Better_Framework()->fonts_manager()->custom_fonts()->get_fonts_family_option_elements( $options['value']['family'] );
            }else{
                echo Better_Framework()->fonts_manager()->custom_fonts()->get_fonts_family_option_elements();
            }

            // all font stacks
            if( $font['type'] == 'font-stacks' ){
                echo Better_Framework()->fonts_manager()->font_stacks()->get_fonts_family_option_elements( $options['value']['family'] );
            }else{
                echo Better_Framework()->fonts_manager()->font_stacks()->get_fonts_family_option_elements();
            }

            // all google fonts
            if( $font['type'] == 'google-font' ) {
                echo Better_Framework()->fonts_manager()->google_fonts()->get_fonts_family_option_elements( $options['value']['family'] );
            }else{
                echo Better_Framework()->fonts_manager()->google_fonts()->get_fonts_family_option_elements();
            }

            ?>
        </select>
    </div>

    <div class="bf-select-option-container typo-field-container">
        <label for="<?php echo $options['input_name']; ?>[variant]"><?php _e('Font Weight:', 'better-studio'); ?></label>
        <select name="<?php echo $options['input_name']; ?>[variant]" id="<?php echo $options['input_name']; ?>-variants" class="font-variants">
            <?php

            Better_Framework()->fonts_manager()->get_font_variants_option_elements( $font, $options['value']['variant'] );

            ?>
        </select>
    </div>

    <div class="bf-select-option-container typo-field-container">
        <label for="<?php echo $options['input_name']; ?>[subset]"><?php _e('Font Character Set:', 'better-studio'); ?></label>
        <select name="<?php echo $options['input_name']; ?>[subset]" id="<?php echo $options['input_name']; ?>-subset" class="font-subsets">
            <?php

            Better_Framework()->fonts_manager()->get_font_subset_option_elements( $font, $options['value']['subset'] );

            ?>
        </select>
    </div>

    <?php

    $align = false;

    if( isset( $options[ $std_id ] ) ){
        if( isset( $options[ $std_id ]['align'] ) ){
            $align = true;
        }
    }
    elseif( isset( $options[ 'std' ] ) ){
        if( isset( $options[ 'std' ]['align'] ) ){
            $align = true;
        }
    }

    if( $align && ! isset( $options['value']['align'] ) ){
        $options['value']['align'] = $options[ 'std' ]['align'];
    }

    if( $align ){ ?>
        <div class="bf-select-option-container  typo-field-container text-align-container">
            <label for="<?php echo $options['input_name']; ?>[align]"><?php _e('Text Align:', 'better-studio'); ?></label>
            <?php
                $aligns = array(
                    'inherit'   =>  'Inherit',
                    'left'   =>  'Left',
                    'center'   =>  'Center',
                    'right'   =>  'Right',
                    'justify'   =>  'Justify',
                    'initial'   =>  'Initial',
                );
                ?>
                <select name="<?php echo $options['input_name']; ?>[align]" id="<?php echo $options['input_name']; ?>-align" >
                    <?php foreach( $aligns as $key => $align ){
                        echo '<option value="'. $key . '" '. ( $key==$options['value']['align'] ? 'selected':'' ) . '>' . $align . '</option>';
                    }?>
                </select>
        </div>
    <?php } ?>

    <?php

    $transform = false;

    if( isset( $options[ $std_id ] ) ){
        if( isset( $options[ $std_id ]['transform'] ) ){
            $transform = true;
        }
    }
    elseif( isset( $options[ 'std' ] ) ){
        if( isset( $options[ 'std' ]['transform'] ) ){
            $transform = true;
        }
    }

    if( $transform && ! isset( $options['value']['transform'] ) ){
        $options['value']['transform'] = $options[ 'std' ]['transform'];
    }

    if( $transform ){ ?>
    <div class="bf-select-option-container typo-field-container text-transform-container">
        <label for="<?php echo $options['input_name']; ?>[transform]"><?php _e('Text Transform:', 'better-studio'); ?></label>
        <?php
            $transforms = array(
                'none'   =>  'None',
                'capitalize'=>  'Capitalize',
                'lowercase'    =>  'Lowercase',
                'uppercase'    =>  'Uppercase',
                'initial'   =>  'Initial',
                'inherit'   =>  'Inherit',
            );
            ?>
            <select name="<?php echo $options['input_name']; ?>[transform]" id="<?php echo $options['input_name']; ?>-transform" class="text-transform">
                <?php foreach( $transforms as $key => $transform ){
                    echo '<option value="'. $key . '" '. ( $key==$options['value']['transform'] ? 'selected':'' ) . '>' . $transform . '</option>';
                }?>
            </select>
    </div>
    <?php } ?>


    <?php

    $size = false;

    if( isset( $options[ $std_id ] ) ){
        if( isset( $options[ $std_id ]['size'] ) ){
            $size = true;
        }
    }
    elseif( isset( $options[ 'std' ] ) ){
        if( isset( $options[ 'std' ]['size'] ) ){
            $size = true;
        }
    }

    if( $size && ! isset( $options['value']['size'] ) ){
        $options['value']['size'] = $options[ 'std' ]['size'];
    }

    if( $size ){ ?>
    <div class="typo-field-container text-size-container">
        <label for="<?php echo $options['input_name']; ?>[size]"><?php _e('Font Size:', 'better-studio'); ?></label>
        <div class="bf-field-with-suffix">
            <input type="text" name="<?php echo $options['input_name']; ?>[size]" value="<?php echo $options['value']['size']; ?>" class="font-size"/><span class='bf-prefix-suffix bf-suffix'>Pixel</span>
        </div>
    </div>
    <?php }



    $line_height = false;

    if( isset( $options[ $std_id ] ) ){
        if( isset( $options[ $std_id ]['line_height'] ) ){
            $line_height = true;
        }
    }
    elseif( isset( $options[ 'std' ] ) ){
        if( isset( $options[ 'std' ]['line_height'] ) ){
            $line_height = true;
        }
    }

    if( $line_height && ! isset( $options['value']['line_height'] ) ){
        $options['value']['line_height'] = $options[ 'std' ]['line_height'];
    }

    if( $line_height ){ ?>
    <div class="typo-field-container text-height-container">
        <label><?php _e('Line Height:', 'better-studio'); ?></label>
        <div class="bf-field-with-suffix ">
            <input type="text" name="<?php echo $options['input_name']; ?>[line_height]" value="<?php echo $options['value']['line_height']; ?>" class="line-height"/><span class='bf-prefix-suffix bf-suffix'><?php _e( 'Pixel', 'better-studio' ); ?></span>
        </div>
    </div>

    <?php }


    $color = false;

    if( isset( $options[ $std_id ] ) ){
        if( isset( $options[ $std_id ]['color'] ) ){
            $color = true;
        }
    }
    elseif( isset( $options[ 'std' ] ) ){
        if( isset( $options[ 'std' ]['color'] ) ){
            $color = true;
        }
    }

    if( $color && ! isset( $options['value']['color'] ) ){
        $options['value']['color'] = $options[ 'std' ]['color'];
    }

    if( $color ){

        echo '<div class="typo-field-container text-color-container"><label>' . __( 'Color:', 'better-studio') . '</label>';
        echo '<div class="bf-clearfix bf-color-picker-container">';
        $input   = Better_Framework::html()->add( 'input' )->type( 'text' )->name( $options['input_name'] . '[color]' )->class( 'bf-color-picker' );

        $preview = Better_Framework::html()->add( 'div' )->class( 'bf-color-picker-preview' );

        if( ! empty( $options['value']['color']  ) ){
            $input->value( $options['value']['color'] )->css('border-color', $options['value']['color']);
            $preview->css( 'background-color', $options['value']['color'] );
        }

        echo $input->display();
        echo $preview->display();
        echo '</div></div>';

    } ?>

</div>