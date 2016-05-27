<?php
/*-------------------------------------------*/
/*	Load js & CSS
/*-------------------------------------------*/
add_action( 'wp_head','ltg_adv_nav_add_js' );
function ltg_adv_nav_add_js() {
	wp_register_script( 'ltg_adv_nav_js' , LIGHTNING_ADVANCED_URL.'plugins/navigation/js/navigation.js', array( 'jquery' ), LIGHTNING_ADVANCED_VERSION );
	wp_enqueue_script( 'ltg_adv_nav_js' );
  wp_enqueue_style( 'ltg_adv_nav_style_css', LIGHTNING_ADVANCED_URL.'plugins/navigation/css/navigation.css', array(), LIGHTNING_ADVANCED_VERSION, 'all' );
}

/*-------------------------------------------*/
/*	insert_header_before_html
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
/*	insert_footer_after_html
/*-------------------------------------------*/
add_action( 'lightning_footer_after', 'ltg_adv_insert_footer_after_html' );
function ltg_adv_insert_footer_after_html(){ ?>
  </div><!-- [ /#wrap ] -->
  </div><!-- [ /#bodyInner ] -->
<?php
}
