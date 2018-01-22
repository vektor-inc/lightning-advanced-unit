<?php
/*-------------------------------------------*/
/*	add body class
/*-------------------------------------------*/
add_filter( 'body_class', 'ltg_adv_add_body_class_menu_slide' );
function ltg_adv_add_body_class_menu_slide( $class ) {
	if ( apply_filters( 'lightning_slide_menu_enable', true ) ) {
		$class[] = 'menu-slide';
	}
	return $class;
}

/*-------------------------------------------*/
/*  Load js & CSS
/*-------------------------------------------*/
add_action( 'wp_enqueue_scripts', 'ltg_adv_nav_add_script', 100 );
function ltg_adv_nav_add_script() {
		wp_enqueue_style( 'ltg_adv_nav_style_css', LIGHTNING_ADVANCED_URL . 'inc/navigation/css/navigation.css', array( 'lightning-design-style' ), LIGHTNING_ADVANCED_VERSION, 'all' );
		wp_register_script( 'ltg_adv_unit_navi_script', LIGHTNING_ADVANCED_URL . 'inc/navigation/js/navigation.min.js', array( 'jquery', 'lightning-js' ), LIGHTNING_ADVANCED_VERSION );
		wp_enqueue_script( 'ltg_adv_unit_navi_script' );
}

/*-------------------------------------------*/
/*  insert_header_before_html
/*-------------------------------------------*/
add_action( 'lightning_header_before', 'ltg_adv_insert_header_before_html' );
function ltg_adv_insert_header_before_html() {
		echo '<div id="bodyInner">';
		echo '<section id="navSection" class="navSection">';
		echo get_search_form();
		echo '</section>';
		echo '<div id="wrap" class="wrap">';
}

/*-------------------------------------------*/
/*  insert_footer_after_html
/*-------------------------------------------*/
add_action( 'lightning_footer_after', 'ltg_adv_insert_footer_after_html' );
function ltg_adv_insert_footer_after_html() {
		echo '</div><!-- [ /#wrap ] -->';
		echo '</div><!-- [ /#bodyInner ] -->';
}
