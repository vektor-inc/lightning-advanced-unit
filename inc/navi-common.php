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

/*
@since 2018.4.16
メニュー未設定時の対策
 */
$skin = get_option( 'lightning_design_skin' );
if ( $skin == 'variety' || $skin == 'charm' || $skin == 'fort' || $skin == 'pale' ) {
	/*-------------------------------------------*/
	/*  メニュータイプが未指定の時はVK Mobile Navに指定
	/*-------------------------------------------*/
	if ( empty( $options['menu_type'] ) ) {
		$options['menu_type'] = 'vk_mobile_nav';
		update_option( 'lightning_theme_options', $options );
	}
}

if ( isset( $options['menu_type'] ) && ( $options['menu_type'] == 'vk_mobile_nav' ) ) {

	/*-------------------------------------------*/
	/*  VK Mobile Nav の時
	/*-------------------------------------------*/

	// VK Mobile Nav 読み込み
	require_once( LIGHTNING_ADVANCED_DIR . 'inc/vk-mobile-nav-config.php' );

	// メニュー開閉ボタンや標準ナビの表示制御
	add_action( 'wp_head', 'lightning_adv_unit_disable_default_menu_css', 4 );
	function lightning_adv_unit_disable_default_menu_css() {

		global $vk_mobile_nav;
		add_action( 'lightning_header_before', array( $vk_mobile_nav, 'menu_set_html' ) );
		// add_action( 'wp_footer', array( $vk_mobile_nav, 'menu_set_html' ) );

		// Lightning標準のメニューボタンを消す
		$dynamic_css = '.menuBtn { display:none; }';

		// モバイルデバイスの時は幅が広くてもPCメニューを強制非表示
		$dynamic_css .= 'body.device-mobile .gMenu_outer{ display:none; }';

		// delete before after space
		$dynamic_css = trim( $dynamic_css );
		// convert tab and br to space
		$dynamic_css = preg_replace( '/[\n\r\t]/', '', $dynamic_css );
		// Change multiple spaces to single space
		$dynamic_css = preg_replace( '/\s(?=\s)/', '', $dynamic_css );

		wp_add_inline_style( 'lightning-design-style', $dynamic_css );
	}
} elseif ( isset( $options['menu_type'] ) && ( $options['menu_type'] == 'side_slide' ) ) {

	/*-------------------------------------------*/
	/*  旧スライドメニューの時
	/*-------------------------------------------*/

	// 	スライドメニューをフックで解除に出来るように plugin_loaded を追加
	add_action( 'plugins_loaded', 'lightning_adv_unit_load_slide_nav' );
	function lightning_adv_unit_load_slide_nav() {
		if ( apply_filters( 'lightning_slide_nav_load', true ) ) {
			require_once( LIGHTNING_ADVANCED_DIR . 'inc/navigation/navigation.php' );
		}
	}
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
	$choices_array = apply_filters( 'lightning_menu_choices_array_custom', $choices_array );
	$wp_customize->add_control(
		'lightning_theme_options[menu_type]', array(
			'label'       => __( 'Menu Type ( Mobile mode )', LIGHTNING_ADVANCED_TEXTDOMAIN ),
			'section'     => 'lightning_design',
			'settings'    => 'lightning_theme_options[menu_type]',
			'type'        => 'radio',
			'description' => '<p style="color:red">' . __( 'It will not take effect unless you save and reload the page.', LIGHTNING_ADVANCED_TEXTDOMAIN ) . '</p>',
			'choices'     => $choices_array,
			'priority'    => 600,
		)
	);
}
