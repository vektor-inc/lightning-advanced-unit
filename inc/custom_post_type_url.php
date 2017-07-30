<?php
/*-------------------------------------------*/
/*  lightning_adv_unit_get_custom_types_labels
/*-------------------------------------------*/
function lightning_adv_unit_get_custom_types_labels() {

    //gets all custom post types set PUBLIC
    $args = array(
        'public'   => true,
        '_builtin' => false,
    );

    $custom_types = get_post_types( $args, 'objects' );
    $custom_types_labels = array();

    foreach ( $custom_types as $custom_type ) {
        $custom_types_labels[ $custom_type->name ] = $custom_type->label;
    }

    return $custom_types_labels;
}

/*-------------------------------------------*/
/*  lightning_adv_unit_custom_post_type_set_rewrite
/*-------------------------------------------*/
add_action( 'generate_rewrite_rules', 'lightning_adv_unit_custom_post_type_set_rewrite' );
function lightning_adv_unit_custom_post_type_set_rewrite( $wp_rewrite ){

    // 存在するカスタム分類を取得
    $post_types = lightning_adv_unit_get_custom_types_labels();

    foreach ( $post_types as $name => $label ){
        $new_rules[$name.'\/page\/?([0-9]{1,})\/?$'] = 'index.php?post_type='.$name.'&paged=$matches[1]';
        $new_rules[$name.'$'] = 'index.php?post_type='.$name;
    }
    $wp_rewrite->rules = array_merge($new_rules, $wp_rewrite->rules);

}
