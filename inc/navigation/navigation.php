<?php

/*-------------------------------------------*/
/*  Customizer
/*-------------------------------------------*/
add_action( 'customize_register', 'lightning_adv_unit_customize_register_menu_type' );
function lightning_adv_unit_customize_register_menu_type($wp_customize) {
  $wp_customize->add_setting( 'lightning_theme_options[menu_type]',  array(
        'default'           => 'side_slide',
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'lightning_sanitize_radio',
    ));
  $choices_array = array(
      'side_slide' => __('Side Slide', LIGHTNING_ADVANCED_TEXTDOMAIN),
      'vertical_show_hide' => __('Vertical Show Hide (Lightning default)', LIGHTNING_ADVANCED_TEXTDOMAIN),
      );
  $choices_array = apply_filters( 'ligthning_menu_choices_array_custom', $choices_array ); // 2017年3月になったら削除
  $choices_array = apply_filters( 'lightning_menu_choices_array_custom', $choices_array );
  $wp_customize->add_control( 'lightning_theme_options[menu_type]',array(
    'label'     => __('Menu Type ( Mobile mode )', LIGHTNING_ADVANCED_TEXTDOMAIN),
    'section'   => 'lightning_design',
    'settings'  => 'lightning_theme_options[menu_type]',
    'type' => 'radio',
    'choices' => $choices_array,
    'priority' => 600,
  ));
}

function ltg_adv_is_slide_menu(){
  $options = get_option('lightning_theme_options');
  if ( !isset( $options['menu_type'] ) ||  ( $options['menu_type'] == 'side_slide' ) ) {
    return true;
  } else {
    return false;
  }
}

/*-------------------------------------------*/
/*	add body class
/*-------------------------------------------*/
add_filter( 'body_class', 'ltg_adv_add_body_class_menu_slide' );
function ltg_adv_add_body_class_menu_slide( $class ){
	if ( ltg_adv_is_slide_menu() ){
		if( apply_filters( 'lightning_slide_menu_enable', true ) ) {
			$class[] = 'menu-slide';
		}
	}
	return $class;
}

/*-------------------------------------------*/
/*  Load js & CSS
/*-------------------------------------------*/
add_action( 'wp_enqueue_scripts','ltg_adv_nav_add_script',100 );
function ltg_adv_nav_add_script() {
  if ( ltg_adv_is_slide_menu() ) {
    wp_enqueue_style( 'ltg_adv_nav_style_css', LIGHTNING_ADVANCED_URL.'inc/navigation/css/navigation.css', array( 'lightning-design-style' ), LIGHTNING_ADVANCED_VERSION, 'all' );
  }
}

/*-------------------------------------------*/
/*  insert_header_before_html
/*-------------------------------------------*/
add_action( 'lightning_header_before', 'ltg_adv_insert_header_before_html' );
function ltg_adv_insert_header_before_html(){
  if ( ltg_adv_is_slide_menu() ) {
    echo '<div id="bodyInner">';
        echo '<section id="navSection" class="navSection">';
        echo get_search_form();
        echo '</section>';
    echo '<div id="wrap" class="wrap">';
  }
}

/*-------------------------------------------*/
/*  insert_footer_after_html
/*-------------------------------------------*/
add_action( 'lightning_footer_after', 'ltg_adv_insert_footer_after_html' );
function ltg_adv_insert_footer_after_html(){
  if ( ltg_adv_is_slide_menu() ) {
    echo '</div><!-- [ /#wrap ] -->';
    echo '</div><!-- [ /#bodyInner ] -->';
  }
}
