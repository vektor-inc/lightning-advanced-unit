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
			$instance[ 'media_image' ] = $new_instance[ 'media_image' ];
			$instance[ 'title_bg_color' ] = $new_instance[ 'title_bg_color' ];
			$instance[ 'title_font_color' ] = $new_instance[ 'title_font_color' ];
			$instance[ 'title' ] = $new_instance[ 'title' ];
			$instance[ 'text' ] = $new_instance[ 'text' ];
			return $new_instance;
		}


	 public static function widget_outer_style( $instance ){
		 $widget_outer_style = 'border:1px solid #f00;';
		 // esc_url( $instance[ 'media_image' ] );
		 // 画像が登録されている場合
		 if ( ! empty( $instance[ 'media_image' ] ) && empty( $instance[ 'title_bg_color' ] ) ) {
			 $widget_outer_style = 'background: url(\''.esc_url( $instance[ 'media_image' ] ).'\');';
			 // 背景色が登録されている場合（画像は登録されていない）
		 } else if ( ! empty( $instance[ 'title_bg_color' ] ) && empty( $instance[ 'media_image' ] ) ) {
			 $widget_outer_style = 'background: '.esc_url( $instance[ 'title_bg_color' ] ).';';
			 //  画像も背景色もどちらも登録されている場合
		 } else if ( ! empty( $instance[ 'media_image' ] ) && ! empty( $instance[ 'title_bg_color' ] ) ) {
			 $widget_outer_style = 'background: url(\''.esc_url( $instance[ 'media_image' ] ).'\');';
			 // その他（画像も背景色も登録されていない）
		 } else if ( empty( $instance[ 'media_image' ]) && empty( $instance[ 'title_bg_color' ] ) ) {
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