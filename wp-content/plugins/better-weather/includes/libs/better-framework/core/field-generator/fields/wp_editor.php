<?php
$value = empty( $options['value'] ) ? '' : $options['value'];

wp_editor( $value, $options['id'] );