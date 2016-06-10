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
  $wp_customize->add_control( 'lightning_theme_options[menu_type]',array(
    'label'     => __('Menu Type ( Mobile mode )', LIGHTNING_ADVANCED_TEXTDOMAIN),
    'section'   => 'lightning_design',
    'settings'  => 'lightning_theme_options[menu_type]',
    'type' => 'radio',
    'choices' => array(
      'side_slide' => __('Side Slide', LIGHTNING_ADVANCED_TEXTDOMAIN),
      'vertical_show_hide' => __('Vertical Show Hide (Lightning default)', LIGHTNING_ADVANCED_TEXTDOMAIN),
      ),
    'priority' => 300,
  ));
}

/*-------------------------------------------*/
/*  Change Menu Type
/*-------------------------------------------*/
$options = get_option('lightning_theme_options');
if ( ! ( isset( $options['menu_type'] ) && $options['menu_type'] == 'vertical_show_hide' ) ){
  /*-------------------------------------------*/
  /*  Load js & CSS
  /*-------------------------------------------*/
  add_action( 'wp_head','ltg_adv_nav_add_js' );
  function ltg_adv_nav_add_js() {
    wp_register_script( 'ltg_adv_nav_js' , LIGHTNING_ADVANCED_URL.'plugins/navigation/js/navigation.js', array( 'jquery' ), LIGHTNING_ADVANCED_VERSION );
    wp_enqueue_script( 'ltg_adv_nav_js' );
    wp_enqueue_style( 'ltg_adv_nav_style_css', LIGHTNING_ADVANCED_URL.'plugins/navigation/css/navigation.css', array(), LIGHTNING_ADVANCED_VERSION, 'all' );
  }

  /*-------------------------------------------*/
  /*  insert_header_before_html
  /*-------------------------------------------*/
  add_action( 'lightning_header_before', 'ltg_adv_insert_header_before_html' );
  function ltg_adv_insert_header_before_html(){ ?>
    <div id="bodyInner">
        <section id="navSection" class="navSection">
        <?php get_search_form(); ?>
        </section>
    <div id="wrap">
  <?php
  }

  /*-------------------------------------------*/
  /*  insert_footer_after_html
  /*-------------------------------------------*/
  add_action( 'lightning_footer_after', 'ltg_adv_insert_footer_after_html' );
  function ltg_adv_insert_footer_after_html(){ ?>
    </div><!-- [ /#wrap ] -->
    </div><!-- [ /#bodyInner ] -->
  <?php
  }
}