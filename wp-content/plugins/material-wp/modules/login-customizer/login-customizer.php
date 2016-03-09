<?php
/**
 *
 * LOGIN CUSTOMIZER
 * Adds all the custom functionality related with the custom login customizer panel
 *
 */

// Background Panel
$bg = $this->options->createThemeCustomizerSection(array(
  'name'  => __('Background', $this->td),
  'panel' => __('Material WP Login', $this->td),
));

// Block Panel
$block = $this->options->createThemeCustomizerSection(array(
  'name'  => __('Login Block', $this->td),
  'panel' => __('Material WP Login', $this->td),
));

// Background Panel
$inputs = $this->options->createThemeCustomizerSection(array(
  'name'  => __('Inputs', $this->td),
  'panel' => __('Material WP Login', $this->td),
));

/**
 * Lets start with the block settings options
 */
$block->createOption(array(
  'id'          => 'login-block-padding',
  'name'        => __('Block Padding', $this->td),
  'desc'        => __('Select the padding to be applied to the login block.', $this->td),
  'type'        => 'number',
  'unit'        => 'px',
  'default'     => 20,
  'livepreview' => 'alert("lol");',
));

$block->createOption(array(
  'id'          => 'login-block-background-color',
  'name'        => __('Block Background Color', $this->td),
  'desc'        => __('Select the background color to be applied to the login block.', $this->td),
  'type'        => 'color',
  'default'     => '#fff',
  'livepreview' => '$("#loginform").css("backgroundColor", value); console.log(value);',
));