<?php

/*-------------------------------------------*/
/*  LTG Full Wide Title widget
/*-------------------------------------------*/

add_action(
	'widgets_init',
	create_function( '', 'return register_widget( "LTG_Full_Wide_Title" );' )
);

class LTG_Full_Wide_Title extends WP_Widget {
	function __construct()
	{
		$widget_id = 'ltg_full_wide_title';
		$widget_name = LIGHTNING_ADVANCED_SHORT_NAME. ' ' . __( 'Full Wide Title', LIGHTNING_ADVANCED_TEXTDOMAIN );
		$widget_description = array( 'description' => 'Full Wide Title' );

		parent::__construct (
			$widget_id,
			$widget_name,
			$widget_description
		);
		add_action( 'customize_preview_init', array( $this, 'add_customizer_script' ) );
	}

	public static function default_options( $args=array() )
	{
		$defaults = array(
			'media_image_id'    => Null,
			'media_image' => '',
			'title_bg_color' => '',
			'title_font_color' => '',
			'title' => '',
			'after_widget' => '',
		);
		return wp_parse_args( (array) $args, $defaults );
	}

	public function form ( $instance )
	{
		$instance = self::default_options( $instance );

		// タイトルの入力
		if ( isset ( $instance['title']) && $instance['title'] ) {
			$title = $instance['title'];
		} else {
			$title = '';
		}

		$id = $this->get_field_id('title');
		$name = $this->get_field_name('title');

		echo '<p>';
		echo 'タイトル：<br>';
		printf (
			'<input type="text" id="%s" name="%s" value="%s" />',
			$id,
			$name,
			esc_attr( $title )
		);
		echo '</p>';

		$image = null;
		// ちゃんと数字が入っているかどうか？
		if ( is_numeric( $instance['media_image_id'] ) ) {
			// 数字だったら、その数字の画像を full サイズで取得
				$image = wp_get_attachment_image_src( $instance['media_image_id'], 'full' );
		}
?>

<div class="vkExUnit_banner_area" style="padding: 2em 0;">
<div class="_display" style="height:auto">
    <?php if ( $image ): ?>
        <img src="<?php echo esc_url( $image[0] ); ?>" style="width:100%;height:auto;" />
    <?php endif; ?>
</div>
<button class="button button-default button-block" style="display:block;width:100%;text-align: center; margin:4px 0;" onclick="javascript:vk_title_bg_image_addiditional(this);return false;"><?php _e('Set image', 'vkExUnit'); ?></button>
<button class="button button-default button-block" style="display:block;width:100%;text-align: center; margin:4px 0;" onclick="javascript:vk_title_bg_image_delete(this);return false;"><?php _e('Delete image', 'vkExUnit'); ?></button>
<div class="_form" style="line-height: 2em">
    <input type="hidden" class="__id" name="<?php echo $this->get_field_name( 'media_image_id' ); ?>" value="<?php echo esc_attr( $instance['media_image_id'] ); ?>" />
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
		console.log(w);
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
		// media uploader imageurl input area
		echo '<p><label for="'.$this->get_field_id( 'media_image' ).'">'.__( 'Select image:', 'vkExUnit' ).'</label><br/>'.
			'<input type="hidden" class="pr_media_image  '.$this->get_field_id( 'media_image' ).'" id="'.$this->get_field_id( 'media_image' ).'" name="'.$this->get_field_name( 'media_image' ).'" value="'.esc_attr( $instance[ 'media_image' ] ).'" />';

		// media uploader select btn
		echo '<input type="button" class="media_select" value="'.__( 'Select image', 'vkExUnit' ).'" onclick="clickSelectPrBroks(event.target);" />';

		// media uploader clear btn
		echo '<input type="button" class="media_clear" value="'.__( 'Clear image', 'vkExUnit' ).'" onclick="clickClearPrBroks(event.target);" />'.
		'<br />'.__( 'When you have an image. Image is displayed with priority', 'vkExUnit' ).'</p>';

		// media image display
		echo '<div class="media image_pr">';
		if ( ! empty( $instance[ 'media_image' ] ) ) {
			echo '<img class="media_img" src="'.esc_url( $instance[ 'media_image' ] ).'" />';
		}
		echo '</div>';

		// title bg color
		echo '<p class="color_picker_wrap">'.
			'<label for="'.$this->get_field_id( 'title_bg_color' ).'">'.__( 'Title background color:', 'vkExUnit' ).'</label><br/>'.
			'<input type="text" id="'.$this->get_field_id( 'title_bg_color' ).'" class="color_picker" name="'.$this->get_field_name( 'title_bg_color' ).'" value="'. esc_attr( $instance[ 'title_bg_color' ] ).'" /></p>';

		// title font color
		echo '<p class="color_picker_wrap">'.
			'<label for="'.$this->get_field_id( 'title_font_color' ).'">'.__( 'Text color of the title:', 'vkExUnit' ).'</label><br/>'.
			'<input type="text" id="'.$this->get_field_id( 'title_font_color' ).'" class="color_picker" name="'.$this->get_field_name( 'title_font_color' ).'" value="'. esc_attr( $instance[ 'title_font_color' ] ).'" /></p>';


		// コンテンツの入力
		if ( isset( $instance['text'] ) && $instance['text'] ) {
			$text = $instance['text'];
		} else {
			$text = '';
		}

		$id = $this->get_field_id('text');
		$name = $this->get_field_name('text');

		echo '<p>';
		echo 'コンテンツ：<br>';
		printf (
			'<textarea id="%s" name="%s">%s</textarea>',
			$id,
			$name,
			esc_textarea( $text )
		);
		echo '</p>';
	}

		/*-------------------------------------------*/
		/*  update
		/*-------------------------------------------*/

		public function update( $new_instance, $old_instance )
		{
			$instance[ 'media_image_id' ] = $new_instance[ 'media_image_id' ];
			$instance[ 'media_image' ] = $new_instance[ 'media_image' ];
			$instance[ 'title_bg_color' ] = $new_instance[ 'title_bg_color' ];
			$instance[ 'title_font_color' ] = $new_instance[ 'title_font_color' ];
			$instance[ 'title' ] = $new_instance[ 'title' ];
			$instance[ 'text' ] = $new_instance[ 'text' ];
			return $new_instance;
		}


	 public static function widget_outer_style( $instance ){
		 $widget_outer_style = 'border:1px solid #f00;';

		 // 画像IDから画像のURLを取得
		 if ( ! empty( $instance['media_image_id'] ) ) {
			 $image = wp_get_attachment_image_src( $instance['media_image_id'], 'full' );
			 $image = $image[0];
		 } else {
			 $image = null;
		 }

		 // 画像が登録されている場合
		 if ( ! empty( $image ) && empty( $instance[ 'title_bg_color' ] ) ) {
			 $widget_outer_style = 'background: url(\''.esc_url( $image ).'\');';
			 // 背景色が登録されている場合（画像は登録されていない）
		 } else if ( ! empty( $instance[ 'title_bg_color' ] ) && empty( $image ) ) {
			 $widget_outer_style = 'background: '.esc_url( $instance[ 'title_bg_color' ] ).';';
			 //  画像も背景色もどちらも登録されている場合
		 } else if ( ! empty( $image ) && ! empty( $instance[ 'title_bg_color' ] ) ) {
			 $widget_outer_style = 'background: url(\''.esc_url( $image ).'\');';
			 // その他（画像も背景色も登録されていない）
		 } else if ( empty( $image) && empty( $instance[ 'title_bg_color' ] ) ) {
			 $widget_outer_style = '';
		 }
		 return $widget_outer_style;
	 }

	 public static function widget_font_style( $instance ){
		 $widget_font_style = 'border:1px solid #f00;';
		 // 色が登録されている場合
		 if ( ! empty( $instance[ 'title_font_color' ] ) ) {
			 $widget_font_style = 'color:' .$instance[ 'title_font_color' ].';';
		 } else {
			 // その他（色が登録されていない）
			 $widget_font_style = '';
		 }
		 return $widget_font_style;
	 }

		public function widget( $args, $instance )
		{
			print '<pre style="text-align:left">';print_r($instance);print '</pre>';
			echo $args ['before_widget'];
			// echo $args ['before_title'];
			echo '<div class="" style="'.$this->widget_outer_style($instance).'">';
			echo '<h3 style="'.$this->widget_font_style($instance).'">'.esc_html( $instance['title'] ).'</h3>';
			echo '</div>';
			// サブテキストがある場合
			echo '<p class="widget-title-caption">'.esc_html( $instance['text'] ).'</p>';
			// echo $args ['after_title'];
			echo $args ['after_widget'];
		}

		static function add_customizer_script() {
		    wp_register_script( 'ltg_full_wide_title_widget_customizer_js' , plugin_dir_url( __FILE__ ).'/widget-full-wide-title.js', array( 'jquery','customize-preview' ), LIGHTNING_ADVANCED_VERSION, true );
		    wp_enqueue_script( 'ltg_full_wide_title_widget_customizer_js' );
		}
}
