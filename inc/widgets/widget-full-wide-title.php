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
		$widget_description = array( 'description' => __( 'This widget is used for single column only.', LIGHTNING_ADVANCED_TEXTDOMAIN ) );

		parent::__construct (
			$widget_id,
			$widget_name,
			$widget_description
		);

	}

	public static function default_options( $args=array() )
	{
		$defaults = array(
			'media_image_id'   		=> Null,
			'title_bg_color'   		=> '',
			'title_font_color' 		=> '',
			'title'            		=> Null,
			'after_widget'     		=> '',
			'title_shadow_use' 		=> false,
			'title_shadow_color'	=> '#000',
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
		echo  __( 'Title:', LIGHTNING_ADVANCED_TEXTDOMAIN ).'<br>';
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

<div class="vkExUnit_banner_area" style="padding: 0.7em 0;">
<div class="_display" style="height:auto">
    <?php if ( $image ): ?>
        <img src="<?php echo esc_url( $image[0] ); ?>" style="width:100%;height:auto;" />
    <?php endif; ?>
</div>
<button class="button button-default button-block" style="display:block;width:100%;text-align: center; margin:4px 0;" onclick="javascript:vk_title_bg_image_addiditional(this);return false;"><?php _e('Set image', LIGHTNING_ADVANCED_TEXTDOMAIN ); ?></button>
<button class="button button-default button-block" style="display:block;width:100%;text-align: center; margin:4px 0;" onclick="javascript:vk_title_bg_image_delete(this);return false;"><?php _e('Delete image', LIGHTNING_ADVANCED_TEXTDOMAIN ); ?></button>
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
		// title bg color
		echo '<p class="color_picker_wrap">'.
			'<label for="'.$this->get_field_id( 'title_bg_color' ).'">'.__( 'Title background color:', LIGHTNING_ADVANCED_TEXTDOMAIN ).'</label><br/>'.
			'<input type="text" id="'.$this->get_field_id( 'title_bg_color' ).'" class="color_picker" name="'.$this->get_field_name( 'title_bg_color' ).'" value="'. esc_attr( $instance[ 'title_bg_color' ] ).'" /></p>';

		// title font color
		echo '<p class="color_picker_wrap">'.
			'<label for="'.$this->get_field_id( 'title_font_color' ).'">'.__( 'Text color of the title:', LIGHTNING_ADVANCED_TEXTDOMAIN ).'</label><br/>'.
			'<input type="text" id="'.$this->get_field_id( 'title_font_color' ).'" class="color_picker" name="'.$this->get_field_name( 'title_font_color' ).'" value="'. esc_attr( $instance[ 'title_font_color' ] ).'" /></p>';

		// Shadow Use
		$checked = ( $instance['title_shadow_use'] ) ? ' checked': '' ;
		echo '<p><input type="checkbox" id="'.$this->get_field_id( 'title_shadow_use' ).'" name="'.$this->get_field_name( 'title_shadow_use' ).'" value="true"'.$checked.' >';
		echo '<label for="'.$this->get_field_id( 'title_shadow_use' ).'">'. __( 'Text shadow', LIGHTNING_ADVANCED_TEXTDOMAIN ).'</label><br/></p>';

		// Shadow color
		echo '<p class="color_picker_wrap">'.
			'<label for="'.$this->get_field_id( 'title_shadow_color' ).'">'.__( 'Text shadow color:', LIGHTNING_ADVANCED_TEXTDOMAIN ).'</label><br/>'.
			'<input type="text" id="'.$this->get_field_id( 'title_shadow_color' ).'" class="color_picker" name="'.$this->get_field_name( 'title_shadow_color' ).'" value="'. esc_attr( $instance[ 'title_shadow_color' ] ).'" /></p>';

		// サブタイトルの入力
		if ( isset( $instance['text'] ) && $instance['text'] ) {
			$text = $instance['text'];
		} else {
			$text = '';
		}

		$id = $this->get_field_id('text');
		$name = $this->get_field_name('text');

		echo '<p>';
		echo  __( 'Sub title:', LIGHTNING_ADVANCED_TEXTDOMAIN ).'<br>';
		echo '<textarea id="'.$id.'" name="'.$name.'" style="width:100%;">'.esc_textarea( $text ).'</textarea>';
		echo '</p>';
	}

		/*-------------------------------------------*/
		/*  update
		/*-------------------------------------------*/

		public function update( $new_instance, $old_instance )
		{
			$instance[ 'media_image_id' ] = $new_instance[ 'media_image_id' ];
			$instance[ 'title_bg_color' ] = sanitize_hex_color( $new_instance[ 'title_bg_color' ] );
			$instance[ 'title_font_color' ] = sanitize_hex_color( $new_instance[ 'title_font_color' ] );
			$instance[ 'title' ] = wp_kses_post( $new_instance[ 'title' ] );
			$instance[ 'text' ] = wp_kses_post( $new_instance[ 'text' ] );
			$instance[ 'title_shadow_use' ] = ( $new_instance[ 'title_shadow_use' ] ) ? true : false;
			$instance[ 'title_shadow_color' ] = sanitize_hex_color( $new_instance[ 'title_shadow_color' ] );
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
			 $widget_outer_style = 'background-image: url(\''.esc_url( $image ).'\');';
			 // 背景色が登録されている場合（画像は登録されていない）
		 } else if ( ! empty( $instance[ 'title_bg_color' ] ) && empty( $image ) ) {
			 $widget_outer_style = 'background: '.sanitize_hex_color( $instance[ 'title_bg_color' ] ).';';
			 //  画像も背景色もどちらも登録されている場合
		 } else if ( ! empty( $image ) && ! empty( $instance[ 'title_bg_color' ] ) ) {
			 $widget_outer_style = 'background-image: url(\''.esc_url( $image ).'\');';
			 // その他（画像も背景色も登録されていない）
		 } else if ( empty( $image) && empty( $instance[ 'title_bg_color' ] ) ) {
			 $widget_outer_style = '';
		 }
		 return $widget_outer_style;
	 }

	 public static function widget_font_style( $instance ){
		 $widget_font_style = '';
		 // 色が登録されている場合
		 if ( ! empty( $instance[ 'title_font_color' ] ) ) {
			 $widget_font_style .= 'color:' .$instance[ 'title_font_color' ].';';
		 } else {
			 // その他（色が登録されていない）
			 $widget_font_style .= '';
		 }

		 // シャドウ
		 if ( isset( $instance[ 'title_shadow_use' ] ) && $instance[ 'title_shadow_use' ] ) {
			 if ( ! empty( $instance[ 'title_shadow_color' ] ) ){
				 $widget_font_style .= 'text-shadow:0 0 0.3em '.$instance[ 'title_shadow_color' ];
			 } else {
				 $widget_font_style .= 'text-shadow:0 0 0.3em #000';
			 }
		 }

		 return $widget_font_style;
	 }

		public function widget( $args, $instance )
		{
			$instance = self::default_options( $instance );
			echo $args ['before_widget'];
			echo '<div class="widget_ltg_adv_full_wide_title_outer" style="'.esc_attr( $this->widget_outer_style($instance) ).'">';
			echo '<h2 class="widget_ltg_adv_full_wide_title_title" style="'.esc_attr( $this->widget_font_style($instance) ).'">'.wp_kses_post( $instance['title'] ).'</h1>';
			// サブテキストがある場合
			if ( ! empty( $instance['text'] ) ){
				echo '<p style="'.$this->widget_font_style($instance).'" class="widget_ltg_adv_full_wide_title_caption">'.wp_kses_post( $instance['text'] ).'</p>';
			}
			echo '</div>';
			echo $args ['after_widget'];
		}

}
