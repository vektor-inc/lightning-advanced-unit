<?php

/*
  LTG Full Wide Title widget
/*-------------------------------------------*/

add_action(
	'widgets_init',
	function() {
		register_widget( 'LTG_Full_Wide_Title' );
	}
);

class LTG_Full_Wide_Title extends WP_Widget {
	function __construct() {
		$widget_id          = 'ltg_full_wide_title';
		$widget_name        = LIGHTNING_ADVANCED_SHORT_NAME . ' ' . __( 'Full Wide Title', LIGHTNING_ADVANCED_TEXTDOMAIN );
		$widget_description = array( 'description' => __( 'This widget is used for single column only.', LIGHTNING_ADVANCED_TEXTDOMAIN ) );

		parent::__construct(
			$widget_id,
			$widget_name,
			$widget_description
		);

	}

	public static function default_options( $args = array() ) {
		$defaults = array(
			'media_image_id'     => null,
			'title_bg_color'     => '',
			'title_font_color'   => '',
			'title'              => '',
			'after_widget'       => '',
			'title_shadow_use'   => false,
			'title_shadow_color' => '#000',
			'margin_top'         => '0',
			'margin_bottom'      => '40px',
			'bg_parallax'        => false,
		);
		return wp_parse_args( (array) $args, $defaults );
	}

	/*
	  form
	/*-------------------------------------------*/
	public function form( $instance ) {
		$options = self::default_options( $instance );
		// ※ wp_parse_args()かけてるのでisset不要

		echo '<p>';
		echo __( 'Title:', LIGHTNING_ADVANCED_TEXTDOMAIN ) . '<br>';
		$id   = $this->get_field_id( 'title' );
		$name = $this->get_field_name( 'title' );
		echo '<input type="text" id="' . $id . '" name="' . $name . '" value="' . esc_attr( $options['title'] ) . '" />';
		echo '</p>';

		// サブタイトルの入力
		if ( isset( $options['text'] ) && $options['text'] ) {
			$text = $options['text'];
		} else {
			$text = '';
		}

		$id   = $this->get_field_id( 'text' );
		$name = $this->get_field_name( 'text' );

		echo '<p>';
		echo __( 'Sub title:', LIGHTNING_ADVANCED_TEXTDOMAIN ) . '<br>';
		echo '<textarea id="' . $id . '" name="' . $name . '" style="width:100%;">' . esc_textarea( $text ) . '</textarea>';
		echo '</p>';

		// title font color
		echo '<p class="color_picker_wrap">' .
			'<label for="' . $this->get_field_id( 'title_font_color' ) . '">' . __( 'Text color of the title:', LIGHTNING_ADVANCED_TEXTDOMAIN ) . '</label><br/>' .
			'<input type="text" id="' . $this->get_field_id( 'title_font_color' ) . '" class="color_picker" name="' . $this->get_field_name( 'title_font_color' ) . '" value="' . esc_attr( $options['title_font_color'] ) . '" /></p>';

		// Shadow Use
		$checked = ( $options['title_shadow_use'] ) ? ' checked' : '';
		echo '<p><input type="checkbox" id="' . $this->get_field_id( 'title_shadow_use' ) . '" name="' . $this->get_field_name( 'title_shadow_use' ) . '" value="true"' . $checked . ' >';
		echo '<label for="' . $this->get_field_id( 'title_shadow_use' ) . '">' . __( 'Text shadow', LIGHTNING_ADVANCED_TEXTDOMAIN ) . '</label><br/></p>';

		// Shadow color
		echo '<p class="color_picker_wrap">' .
			'<label for="' . $this->get_field_id( 'title_shadow_color' ) . '">' . __( 'Text shadow color:', LIGHTNING_ADVANCED_TEXTDOMAIN ) . '</label><br/>' .
			'<input type="text" id="' . $this->get_field_id( 'title_shadow_color' ) . '" class="color_picker" name="' . $this->get_field_name( 'title_shadow_color' ) . '" value="' . esc_attr( $options['title_shadow_color'] ) . '" /></p>';

		// bg color
		echo '<p class="color_picker_wrap">' .
			'<label for="' . $this->get_field_id( 'title_bg_color' ) . '">' . __( 'Title background color:', LIGHTNING_ADVANCED_TEXTDOMAIN ) . '</label><br/>' .
			'<input type="text" id="' . $this->get_field_id( 'title_bg_color' ) . '" class="color_picker" name="' . $this->get_field_name( 'title_bg_color' ) . '" value="' . esc_attr( $options['title_bg_color'] ) . '" /></p>';

		$image = null;
		// ちゃんと数字が入っているかどうか？
		if ( is_numeric( $options['media_image_id'] ) ) {
			// 数字だったら、その数字の画像を full サイズで取得
				$image = wp_get_attachment_image_src( $options['media_image_id'], 'full' );
		}
		?>

<div class="vkExUnit_banner_area" style="padding: 0.7em 0;">
<div class="_display" style="height:auto">
		<?php if ( $image ) : ?>
		<img src="<?php echo esc_url( $image[0] ); ?>" style="width:100%;height:auto;" />
	<?php endif; ?>
</div>
<button class="button button-default button-block" style="display:block;width:100%;text-align: center; margin:4px 0;" onclick="javascript:vk_title_bg_image_addiditional(this);return false;"><?php _e( 'Set image', LIGHTNING_ADVANCED_TEXTDOMAIN ); ?></button>
<button class="button button-default button-block" style="display:block;width:100%;text-align: center; margin:4px 0;" onclick="javascript:vk_title_bg_image_delete(this);return false;"><?php _e( 'Delete image', LIGHTNING_ADVANCED_TEXTDOMAIN ); ?></button>
<div class="_form" style="line-height: 2em">
	<input type="hidden" class="__id" name="<?php echo $this->get_field_name( 'media_image_id' ); ?>" value="<?php echo esc_attr( $options['media_image_id'] ); ?>" />
</div>
</div>
<script type="text/javascript">
// 背景画像登録処理
if ( vk_title_bg_image_addiditional == undefined ){
var vk_title_bg_image_addiditional = function(e){
		// プレビュー画像を表示するdiv
	var d=jQuery(e).parent().children("._display");
		// 画像IDを保存するinputタグ
	var w=jQuery(e).parent().children("._form").children('.__id')[0];
	var u=wp.media({library:{type:'image'},multiple:false}).on('select', function(e){
		u.state().get('selection').each(function(f){
					d.children().remove();
					d.append(jQuery('<img style="width:100%;mheight:auto">').attr('src',f.toJSON().url));
					jQuery(w).val(f.toJSON().id).change();
				});
	});
	u.open();
};
}
// 背景画像削除処理
if ( vk_title_bg_image_delete == undefined ){
var vk_title_bg_image_delete = function(e){
		// プレビュー画像を表示するdiv
		var d=jQuery(e).parent().children("._display");
		// 画像IDを保存するinputタグ
		var w=jQuery(e).parent().children("._form").children('.__id')[0];

		// プレビュー画像のimgタグを削除
		d.children().remove();
		// w.attr("value","");
		jQuery(e).parent().children("._form").children('.__id').attr("value","").change();
};
}
</script>

		<?php

		// Shadow Use
		$checked = ( $options['bg_parallax'] ) ? ' checked' : '';
		echo '<p><input type="checkbox" id="' . $this->get_field_id( 'bg_parallax' ) . '" name="' . $this->get_field_name( 'bg_parallax' ) . '" value="true"' . $checked . ' >';
		echo '<label for="' . $this->get_field_id( 'bg_parallax' ) . '">' . __( 'Set to parallax', LIGHTNING_ADVANCED_TEXTDOMAIN ) . '</label><br/></p>';

		echo '<p>';
		echo __( 'Margin Top', LIGHTNING_ADVANCED_TEXTDOMAIN ) . ' : ';
		$id   = $this->get_field_id( 'margin_top' );
		$name = $this->get_field_name( 'margin_top' );
		echo '<input type="text" id="' . $id . '" name="' . $name . '" value="' . esc_attr( $options['margin_top'] ) . '" /><br />';
		echo __( 'Ex', LIGHTNING_ADVANCED_TEXTDOMAIN ) . ') 0;';
		echo '</p>';

		echo '<p>';
		echo __( 'Margin Bottom', LIGHTNING_ADVANCED_TEXTDOMAIN ) . ' : ';
		$id   = $this->get_field_id( 'margin_bottom' );
		$name = $this->get_field_name( 'margin_bottom' );
		echo '<input type="text" id="' . $id . '" name="' . $name . '" value="' . esc_attr( $options['margin_bottom'] ) . '" /><br />';
		echo __( 'Ex', LIGHTNING_ADVANCED_TEXTDOMAIN ) . ') 40px';
		echo '</p>';

	}

		/*
		-------------------------------------------*/
		/*
		  update
		/*-------------------------------------------*/

	public function update( $new_instance, $old_instance ) {
		$instance['media_image_id']     = $new_instance['media_image_id'];
		$instance['title_bg_color']     = sanitize_hex_color( $new_instance['title_bg_color'] );
		$instance['title_font_color']   = sanitize_hex_color( $new_instance['title_font_color'] );
		$instance['title']              = wp_kses_post( $new_instance['title'] );
		$instance['text']               = wp_kses_post( $new_instance['text'] );
		$instance['title_shadow_use']   = ( $new_instance['title_shadow_use'] ) ? true : false;
		$instance['title_shadow_color'] = sanitize_hex_color( $new_instance['title_shadow_color'] );
		$instance['margin_top']         = esc_attr( $new_instance['margin_top'] );
		$instance['margin_bottom']      = esc_attr( $new_instance['margin_bottom'] );
		return $new_instance;
	}

	/*
	-------------------------------------------*/
	/*
	  functions
	/*-------------------------------------------*/
	public static function widget_outer_style( $instance ) {

		// 画像IDから画像のURLを取得
		if ( ! empty( $instance['media_image_id'] ) ) {
			$image = wp_get_attachment_image_src( $instance['media_image_id'], 'full' );
			$image = $image[0];
		} else {
			$image = null;
		}

		// 画像が登録されている場合
		if ( ! empty( $image ) && empty( $instance['title_bg_color'] ) ) {
			$widget_outer_style = 'background-image: url(\'' . esc_url( $image ) . '\');';
			// 背景色が登録されている場合（画像は登録されていない）
		} elseif ( ! empty( $instance['title_bg_color'] ) && empty( $image ) ) {
			$widget_outer_style = 'background: ' . sanitize_hex_color( $instance['title_bg_color'] ) . ';';
			// 画像も背景色もどちらも登録されている場合
		} elseif ( ! empty( $image ) && ! empty( $instance['title_bg_color'] ) ) {
			$widget_outer_style = 'background-image: url(\'' . esc_url( $image ) . '\');';
			// その他（画像も背景色も登録されていない）
		} elseif ( empty( $image ) && empty( $instance['title_bg_color'] ) ) {
			$widget_outer_style = '';
		}

		if ( isset( $instance['margin_top'] ) && $instance['margin_top'] != '' ) {
			$widget_outer_style .= 'margin-top:' . esc_attr( $instance['margin_top'] ) . ';';
		}
		if ( isset( $instance['margin_bottom'] ) && $instance['margin_bottom'] != '' ) {
			$widget_outer_style .= 'margin-bottom:' . esc_attr( $instance['margin_bottom'] ) . ';';
		}

		return $widget_outer_style;
	}

	public static function widget_font_style( $instance ) {
		$widget_font_style = '';
		// 色が登録されている場合
		if ( ! empty( $instance['title_font_color'] ) ) {
			$widget_font_style .= 'color:' . $instance['title_font_color'] . ';';
		} else {
			// その他（色が登録されていない）
			$widget_font_style .= '';
		}

		// シャドウ
		if ( isset( $instance['title_shadow_use'] ) && $instance['title_shadow_use'] ) {
			if ( ! empty( $instance['title_shadow_color'] ) ) {
				$widget_font_style .= 'text-shadow:0 0 0.3em ' . $instance['title_shadow_color'];
			} else {
				$widget_font_style .= 'text-shadow:0 0 0.3em #000';
			}
		}

		return $widget_font_style;
	}

	/*
	  widget
	/*-------------------------------------------*/
	public function widget( $args, $instance ) {
		$instance = self::default_options( $instance );

		// テーマ側から .widget に対してmargin-bottomが付けられてしまっているので、
		// ウィジェット個別で上下余白指定がある場合は .widgetの余白を打ち消す必要がある
		$widget_outer_style = '';
		if ( isset( $instance['margin_top'] ) && $instance['margin_top'] != '' ) {
			$widget_outer_style .= 'margin-top:0;';
		}
		if ( isset( $instance['margin_bottom'] ) && $instance['margin_bottom'] != '' ) {
			$widget_outer_style .= 'margin-bottom:0px;background-repeat:no-repeat;';
		}

		if ( $widget_outer_style ) {
			$dynamic_css = '#' . $args['widget_id'] . '.widget {' . $widget_outer_style . '}';
			// $dynamic_css = trim( $dynamic_css );
			// // convert tab and br to space
			// $dynamic_css = preg_replace( '/[\n\r\t]/', '', $dynamic_css );
			// // Change multiple spaces to single space
			// $dynamic_css = preg_replace( '/\s(?=\s)/', '', $dynamic_css );
			echo '<style type="text/css">' . $dynamic_css . '</style>';
			// wp_add_inline_style( 'lightning-design-style', $dynamic_css );
		}
		$add_class = '';
		if ( $instance['bg_parallax'] && $instance['media_image_id'] ) {
			$add_class = ' vk-prlx';
		}

		echo $args ['before_widget'];
		echo '<div class="widget_ltg_adv_full_wide_title_outer' . $add_class . '" style="' . esc_attr( $this->widget_outer_style( $instance ) ) . '">';
		echo '<h2 class="widget_ltg_adv_full_wide_title_title" style="' . esc_attr( $this->widget_font_style( $instance ) ) . '">' . wp_kses_post( $instance['title'] ) . '</h2>';
		// サブテキストがある場合
		if ( ! empty( $instance['text'] ) ) {
			echo '<p style="' . $this->widget_font_style( $instance ) . '" class="widget_ltg_adv_full_wide_title_caption">' . wp_kses_post( $instance['text'] ) . '</p>';
		}
		echo '</div>';
		echo $args ['after_widget'];
	}

}
