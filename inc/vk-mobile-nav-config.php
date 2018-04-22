<?php

/*-------------------------------------------*/
/*  Load modules
/*-------------------------------------------*/
if ( ! class_exists( 'Vk_Mobile_Nav' ) ) {
	require_once( 'vk-mobile-nav/class-vk-mobile-nav.php' );

	global $vk_mobile_nav_textdomain;
	$vk_mobile_nav_textdomain = 'lightning-adv-unit';

}

// ページ下部に固定表示するメニュー
if ( ! class_exists( 'Vk_Mobile_Fix_Nav' ) ) {
	require_once( 'vk-mobile-nav/class-vk-mobile-fix-nav.php' );

	global $vk_mobile_fix_nav_textdomain;
	$vk_mobile_fix_nav_textdomain = 'lightning-adv-unit';
}
