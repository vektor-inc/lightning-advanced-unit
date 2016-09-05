<?php
/*-------------------------------------------*/
/*  Customizer
/*-------------------------------------------*/
add_action( 'customize_register', 'lightning_adv_unit_customize_register_sidebar_position' );
function lightning_adv_unit_customize_register_sidebar_position($wp_customize) {
	$wp_customize->add_setting( 'lightning_theme_options[sidebar_position]',  array(
        'default'           => 'right',
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'lightning_sanitize_radio',
    ));
	$wp_customize->add_control( 'lightning_theme_options[sidebar_position]',array(
		'label'     => __('Sidebar position ( PC mode )', LIGHTNING_ADVANCED_TEXTDOMAIN),
		'section'   => 'lightning_design',
		'settings'  => 'lightning_theme_options[sidebar_position]',
		'type' => 'radio',
		'choices' => array(
			'right' => __('Right', LIGHTNING_ADVANCED_TEXTDOMAIN),
			'left' => __('Left', LIGHTNING_ADVANCED_TEXTDOMAIN),
			),
		'priority' => 610,
	));
}

/*-------------------------------------------*/
/*  Position Change
/*-------------------------------------------*/
add_action( 'wp_head', 'lightning_adv_unit_sidebar_position_custom', 2 );
function lightning_adv_unit_sidebar_position_custom(){
	$options = get_option( 'lightning_theme_options' );
	if ( isset($options['sidebar_position'] ) && $options['sidebar_position'] === "left" ){
		$custom_css = "@media (min-width: 992px) { .siteContent .subSection { float:left;margin-left:0; } .siteContent .mainSection { float:right; } }";
		wp_add_inline_style( 'lightning-design-style', $custom_css );
	}
}