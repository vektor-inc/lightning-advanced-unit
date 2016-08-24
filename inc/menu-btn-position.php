<?php
/*-------------------------------------------*/
/*  Customizer
/*-------------------------------------------*/
add_action( 'customize_register', 'lightning_adv_unit_customize_register_menu_btn_position' );
function lightning_adv_unit_customize_register_menu_btn_position($wp_customize) {
	$wp_customize->add_setting( 'lightning_theme_options[menu_btn_position]',  array(
        'default'           => 'left',
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'lightning_sanitize_radio',
    ));
	$wp_customize->add_control( 'lightning_theme_options[menu_btn_position]',array(
		'label'     => __('Menu button position ( Mobile mode )', LIGHTNING_ADVANCED_TEXTDOMAIN),
		'section'   => 'lightning_design',
		'settings'  => 'lightning_theme_options[menu_btn_position]',
		'type' => 'radio',
		'choices' => array(
			'left' => __('Left', LIGHTNING_ADVANCED_TEXTDOMAIN),
			'right' => __('Right', LIGHTNING_ADVANCED_TEXTDOMAIN),
			),
		'priority' => 601,
	));
}

/*-------------------------------------------*/
/*  Position Change
/*-------------------------------------------*/
add_filter( 'lightning_menu_btn_position', 'lightning_adv_unit_menu_btn_position_custom' );
function lightning_adv_unit_menu_btn_position_custom($menu_btn_position){
	$options = get_option('lightning_theme_options');
	if (isset($options['menu_btn_position']) && $options['menu_btn_position']){
		$menu_btn_position = $options['menu_btn_position'];
	}
	return $menu_btn_position;
}
