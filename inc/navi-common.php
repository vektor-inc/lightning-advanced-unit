<?php

/* 　このプラグイン内では既に利用していないが、拡張スキンなどで利用されているかもしれないので一応保留 */
function ltg_adv_is_slide_menu() {
	$options = get_option( 'lightning_theme_options' );
	if ( ! isset( $options['menu_type'] ) || ( $options['menu_type'] == 'side_slide' ) ) {
		return true;
	} else {
		return false;
	}
}


$options = get_option( 'lightning_theme_options' );
// print '<pre style="text-align:left">';print_r($a);print '</pre>';
if ( ! isset( $options['menu_type'] ) || ( $options['menu_type'] == 'vk_mobile_nav' ) ) {
	require_once( LIGHTNING_ADVANCED_DIR . 'inc/vk-mobile-nav-config.php' );
} elseif ( isset( $options['menu_type'] ) && ( $options['menu_type'] == 'side_slide' ) ) {
	// 	スライドメニューをフックで解除に出来るように plugin_loaded を追加
	// add_action( 'plugins_loaded', 'lightning_adv_unit_setup' );
	// function lightning_adv_unit_setup() {
	// if ( apply_filters( 'lightning_slide_nav_load', true ) ) {
		require_once( LIGHTNING_ADVANCED_DIR . 'inc/navigation/navigation.php' );
	// }
	// }
}

/*-------------------------------------------*/
/*  Customizer
/*-------------------------------------------*/
add_action( 'customize_register', 'lightning_adv_unit_customize_register_menu_type' );
function lightning_adv_unit_customize_register_menu_type( $wp_customize ) {
	$wp_customize->add_setting(
		'lightning_theme_options[menu_type]', array(
			'default'           => 'vk_mobile_nav',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'lightning_sanitize_radio',
		)
	);
	$choices_array = array(
		'vk_mobile_nav'      => __( 'VK Mobile Nav(Recommend)', LIGHTNING_ADVANCED_TEXTDOMAIN ),
		'vertical_show_hide' => __( 'Vertical Show Hide (Lightning default)', LIGHTNING_ADVANCED_TEXTDOMAIN ),
		'side_slide'         => __( 'Side Slide(Not recommend)', LIGHTNING_ADVANCED_TEXTDOMAIN ),
	);
	$choices_array = apply_filters( 'ligthning_menu_choices_array_custom', $choices_array ); // 2017年3月になったら削除
	$choices_array = apply_filters( 'lightning_menu_choices_array_custom', $choices_array );
	$wp_customize->add_control(
		'lightning_theme_options[menu_type]', array(
			'label'    => __( 'Menu Type ( Mobile mode )', LIGHTNING_ADVANCED_TEXTDOMAIN ),
			'section'  => 'lightning_design',
			'settings' => 'lightning_theme_options[menu_type]',
			'type'     => 'radio',
			'choices'  => $choices_array,
			'priority' => 600,
		)
	);
}
