
jQuery(document).ready(function(){
	if( !jQuery('body').hasClass('menu-slide') ){ return; }
	run_slide_menu_control();
});
jQuery(window).resize(function(){
	if( !jQuery('body').hasClass('menu-slide') ){ return; }
	run_menuResize();
});
/*-------------------------------------------*/
/*	メニューの開閉
/*	<div id="menu" onclick="showHide('menu');" class="itemOpen">MENU</div>
/*  * header.siteHeader を left で制御しているのは Safariでは
/*  position:fixed しているとウィンドウにfixしてしまってwrapを横にずらしてもついて来ないため
/*-------------------------------------------*/

function run_slide_menu_control(){
	jQuery('.menuBtn').prependTo('#bodyInner');
	jQuery('.menuBtn').each(function(){
		jQuery(this).click(function(){
			if ( jQuery(this).hasClass('menuBtn_left') ){
				var menuPosition = 'left';
			} else {
				var menuPosition = 'right';
			}
			// ※ この時点でLightning本体のmaster.jsによって既に menuOpenに新しく切り替わっている
			if ( jQuery(this).hasClass('menuOpen') ) {
				slide_menu_open(menuPosition);
			} else {
				slide_menu_close(menuPosition);
			}
		});
	});
}

function slide_menu_open(menuPosition){
	var navSection_open_position = 'navSection_open_' + menuPosition;
	jQuery('#navSection').addClass(navSection_open_position);

	var wrap_width = jQuery('body').width();
	jQuery('#bodyInner').css({"width":wrap_width});
	jQuery('#wrap').css({"width":wrap_width});

	var menu_width = wrap_width - 60 + 'px';

	jQuery('#headerTop').appendTo('#navSection');
	jQuery('#gMenu_outer').appendTo('#navSection');

	if ( menuPosition == 'right' ){
		jQuery('#wrap').stop().animate({
			// 右にメニューを表示するために左に逃げる
			"margin-left": "-" + menu_width,
		},200);
		jQuery('header.siteHeader').stop().animate({
			"left":"-"+menu_width,
		},200);
		jQuery('#navSection').css({"display":"block","width":menu_width, "right" :"-"+menu_width }).stop().animate({
			"right":0,
		},200);

	} else if ( menuPosition == 'left' ){
		jQuery('#wrap').stop().animate({
			"margin-left":menu_width,
		},200);
		jQuery('header.siteHeader').stop().animate({
			"left":menu_width,
		},200);
		jQuery('#navSection').css({"display":"block","width":menu_width, "left" :"-"+menu_width }).stop().animate({
			"left":0,
		},200,function(){
		});
	}
}
function slide_menu_close(menuPosition){

	if ( !menuPosition ){
		if ( jQuery('#navSection').hasClass('navSection_open_right') ){
			menuPosition = 'right';
		} else {
			menuPosition = 'left';
		}
	}

	var wrap_width = jQuery('body').width();
	jQuery('#bodyInner').css({"width":wrap_width});
	jQuery('#wrap').css({"width":wrap_width});

	var menu_width = wrap_width - 60 + 'px';

	jQuery('#wrap').stop().animate({ "margin-left":"0" },200);
	jQuery('header.siteHeader').stop().animate({ "left":"0" },200);

	if ( menuPosition == 'right' ) {jQuery('header.siteHeader').stop().animate({ "left":"0" },200);
		jQuery('#navSection').stop().animate({ "right":"-"+menu_width },200,function(){
			menuClose_common();
		});
	} else if ( menuPosition == 'left' ){
		jQuery('#navSection').stop().animate({ "left":"-"+menu_width },200,function(){
			menuClose_common();
		});
	}
}
function menuClose_common(){
	// アニメーションが終わってから実行
	jQuery('#navSection').removeClass('navSection_open_right');
	jQuery('#navSection').removeClass('navSection_open_left');
	jQuery('#navSection').css({ "right":"", "left":"", "display":"" });
	jQuery('#headerTop').prependTo('header.siteHeader');
	jQuery('#bodyInner').css({"width":""});
	jQuery('#wrap').css({"width":""});
	// judge animate execution
	if(jQuery('#navSection').is(':animated')){
		jQuery('#gMenu_outer').insertAfter('.navbar-header');
	}
}
function run_menuResize(){
	var wrap_width = jQuery('body').width();
	jQuery('#bodyInner').css({"width":wrap_width});
	// jQuery('#wrap').css({"width":wrap_width,"margin-left":"","margin-right":""});
	// menuClose_common();
	var headerHeight = jQuery('header.siteHeader').height;
	jQuery('#top__fullcarousel').css({"margin-top":headerHeight});
	if ( wrap_width > 991 ) {
		slide_menu_close();
	}
}

/*-------------------------------------------*/
/* スクロール時のサイドバー位置固定処理
/*-------------------------------------------*/
;(function($){

	/* 読み込み / リサイズ時の処理
	/*-------------------------------------------*/
	jQuery(document).ready(function(){

	});
	jQuery(window).resize(function(){

	});
  jQuery(window).scroll(function(){
		if( !$('body').hasClass('sidebar-fix') ){ return; }
		// サイドバーの位置を取得
		var sidebar_position_now = jQuery('.sideSection').offset();
		// サイドバーがなかったら処理中止
		if ( !sidebar_position_now ) { return }
    sideFix_scroll();
  });


	/* リセット処理
	/*-------------------------------------------*/
	function sideFix_reset(){
		// サイドバー上部の余白をリセット
		jQuery('.sideSection').css({ "margin-top" : "" });
		// jQuery('.sideSection').css({ "position":"relative", "bottom":"", "left":"" });
	}

	/* スクロール時の処理
	/*-------------------------------------------*/
	function sideFix_scroll(){

		// 画面の幅を取得
		var wrap_width = $('body').width();
		// 画面の高を取得
		var window_height = document.documentElement.clientHeight;

		// 画面幅が狭い（1カラム）の場合
		if ( wrap_width < 992 ) {
			// リセット処理
			sideFix_reset()
		// 画面幅が広い（２カラム）の場合
		} else {

		// サイドバーの位置を取得
		var sidebar_position_now = jQuery('.sideSection').offset();
		// コンテンツエリアの位置を取得
		var content_position_now = jQuery('.mainSection').offset();

		// サイドバーの高さを取得
		var sidebar_height = jQuery('.sideSection').outerHeight();
		// メインコンテンツの高さを取得
		var content_height = jQuery('.mainSection').outerHeight();
		// メインコンテンツとサイドバーの高さの差
		var height_difference = content_height - sidebar_height;

		// サイドバー下端までの距離（サイドバー上部とコンテンツエリア上部が同じ位置の場合のみ有効） = コンテンツエリアの位置（高さ）+ サイドバーの高さ
		var sidebar_bottom_position_default = content_position_now['top'] + sidebar_height;
		// コンテンツアリア下端までの距離 = サイトバーの位置（高さ）+ コンテントエリアの高さ
		var content_bottom_position_default = content_position_now['top'] + content_height;

		// サイドバー下端までの距離 = サイトバーの位置（高さ）+ サイドバーの高さ
		var sidebar_bottom_position_now = sidebar_position_now['top'] + sidebar_height;
		// コンテンツアリア下端までの距離 = サイトバーの位置（高さ）+ コンテントエリアの高さ
		var content_bottom_position_now = content_position_now['top'] + content_height;


		/*
		 * 初期状態で画面からサイドバーがはみだしている場合（ 画面の高さ < サイドバー下端までの距離 ）
		*/
		if ( window_height < sidebar_bottom_position_default ) {

			// 画面からはみ出しているサイドバーの高さ
			var sidebar_over_size = sidebar_bottom_position_default - window_height;

			// スクロール開始位置の状態ではみ出す量 = サイドバーの高さ - ウィンドウの高さ
			var sidebar_over_size_start = sidebar_height - window_height;

			/*
			 * 移動開始位置でもサイドバーが画面内からはみ出している場合
			*/
			if ( sidebar_height > window_height ) {

				// スクロール開始位置の時点でサイドバーが画面からはみ出している量 = 移動開始スクロール値 + 移動開始時にはみ出している量 + 余白
				var move_position_start = content_position_now['top'] + sidebar_over_size_start + 30;

				// ★ サイドバーの移動終了スクロール値 = コンテンツエリアまでの高さ + はみ出していたコンテンツの高さ + 余白
				var move_position_end = height_difference + content_position_now['top'] + sidebar_over_size_start + 30;

			/*
			 * 移動開始位置ではサイドバーが画面内に収まっている場合
			*/
			} else {

				// ★ サイドバーの移動開始スクロール値 = コンテンツエリアまでの高さ（サイドバー上部とコンテンツエリア上部が同じ位置の場合のみ有効）
				var move_position_start = content_position_now['top'];
				// ★ サイドバーの移動終了スクロール値 = メインコンテンツとサイドバーの高さの差 + コンテンツエリアまでの高さ（サイドバー上部とコンテンツエリア上部が同じ位置の場合のみ有効）
				var move_position_end = height_difference + content_position_now['top'];
			}

		/*
		 * 初期状態で画面からはみだしていない場合（ 画面の高さ > サイドバー下端までの距離 ）
		*/
		} else {

			// ★ サイドバーの移動開始スクロール値 = コンテンツエリアまでの高さ（サイドバー上部とコンテンツエリア上部が同じ位置の場合のみ有効）
			var move_position_start = content_position_now['top'];
			// ★ サイドバーの移動終了スクロール値 = メインコンテンツとサイドバーの高さの差 + コンテンツエリアまでの高さ（サイドバー上部とコンテンツエリア上部が同じ位置の場合のみ有効）
			var move_position_end = height_difference + content_position_now['top'];

		} // if ( sideFix.window_height < sidebar_bottom_position_default ) {


		/* スクロール動作条件
		/*-------------------------------------------*/
		//	サイドバーがメインコンテンツよりも高い場合は処理しない
		if ( sidebar_height > content_height ){ return; }

		// スクロール量を取得
		var scrollHeight = window.pageYOffset;

		// console.log('content_bottom_position_now : ' + content_bottom_position_now +  ' / sidebar_bottom_position_now : ' + sidebar_bottom_position_now );
		// console.log('move_position_end : ' + move_position_end +  ' / scrollHeight : ' + scrollHeight );
		// console.log('move_position_end : ' + move_position_end +  ' / scrollHeight : ' + scrollHeight );


		//　スクロール量がサイドバーの移動開始スクロール値より少ない場合
		if ( scrollHeight < move_position_start ){
			// リセット処理
			sideFix_reset();

		// スクロール量がサイドバーの移動開始スクロール値より大きい場合
		} else {

			// スクロールの高さより サイドバーの移動終了スクロール値 が大きい場合のみ処理する
			// if ( content_bottom_position_now > sidebar_bottom_position_now ){ // これがないと延々とスクロールする
			if ( scrollHeight < move_position_end ){ // これがないと延々とスクロールする

				// 移動開始

				// サイドバー上部に追加する余白 = スクロール量 - サイドバーの移動開始スクロール値
				var yohaku = scrollHeight - move_position_start;
				// サイドバー上部に余白を追加
				jQuery('.sideSection').css({ "margin-top" : yohaku });
				// jQuery('.sideSection').css({ "position":"fixed", "bottom":"30", "left":sidebar_position_now['left'],"width":sideFix.sidebar_width });

			} else {
				// スクロール量が終了ポイントを過ぎた時、下端が揃わないので強制的に揃える
				var yohaku = content_height - sidebar_height;
				jQuery('.sideSection').css({ "margin-top" : yohaku });
			} // if ( scrollHeight < move_position_start ){
		}
	}	// if ( sideFix.wrap_width < 992 ) {

	}

})(jQuery);
