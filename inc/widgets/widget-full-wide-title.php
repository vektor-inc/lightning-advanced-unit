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
	}

	public static function default_options( $args=array() )
	{
		$defaults = array(
			'media_image' => '',
			'media_alt' => '',
			'title_bg_color' => '',
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

		// media uploader imagealt input area
		echo '<input type="hidden" class="pr_media_alt" id="'.$this->get_field_id( 'media_alt' ).'-alt" name="'.$this->get_field_name( 'media_alt' ).'" value="'.esc_attr( $instance[ 'media_alt' ] ).'" />';

		// media uploader select btn
		echo '<input type="button" class="media_select" value="'.__( 'Select image', 'vkExUnit' ).'" onclick="clickSelectPrBroks(event.target);" />';

		// media uploader clear btn
		echo '<input type="button" class="media_clear" value="'.__( 'Clear image', 'vkExUnit' ).'" onclick="clickClearPrBroks(event.target);" />'.
		'<br />'.__( 'When you have an image. Image is displayed with priority', 'vkExUnit' ).'</p>';

		// media image display
		echo '<div class="media image_pr">';
		if ( ! empty( $instance[ 'media_image' ] ) ) {
			echo '<img class="media_img" src="'.esc_url( $instance[ 'media_image' ] ).'" alt="'. esc_attr( $instance[ 'media_alt' ] ).'" />';
		}
		echo '</div>';

		// title bg color
		echo '<p class="color_picker_wrap">'.
			'<label for="'.$this->get_field_id( 'title_bg_color' ).'">'.__( 'Icon color:', 'vkExUnit' ).'</label><br/>'.
			'<input type="text" id="'.$this->get_field_id( 'title_bg_color' ).'" class="color_picker" name="'.$this->get_field_name( 'title_bg_color' ).'" value="'. esc_attr( $instance[ 'title_bg_color' ] ).'" /></p>';


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
	public function update( $new_instance, $old_instance )
	{
		$instance[ 'media_image' ] = $new_instance[ 'media_image' ];
		$instance[ 'media_alt' ] = $new_instance[ 'media_alt' ];
		$instance[ 'title_bg_color' ] = $new_instance[ 'title_bg_color' ];
		$instance[ 'title' ] = $new_instance[ 'title' ];
		$instance[ 'text' ] = $new_instance[ 'text' ];
		return $new_instance;
	}

	public function widget( $args, $instance )
	{
		print '<pre style="text-align:left">';print_r($instance);print '</pre>';
		echo $args ['before_widget'];
		echo $args ['before_title'];
		echo esc_html( $instance['title'] );
		echo $args ['after_title'];
		echo esc_html( $instance['text'] );
		echo $args ['after_widget'];
	}
}
