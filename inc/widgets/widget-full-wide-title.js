/**
	 * このファイルはテーマカスタマイザーライブプレビューをライブにします。
	 * テーマ設定で 'postMessage' を指定し、ここで制御します。
	 * JavaScript はコントロールからテーマ設定を取得し、
	 * jQuery を使ってページに変更を反映します。
	 */
	( function( $ ) {

		     console.log('_|＼○_ﾋｬｯ ε=＼＿○ﾉ ﾎｰｳ!!');
		var contact_txt = jQuery('.headerTop_contactBtn a').html();
		var contact_url = jQuery('.headerTop_contactBtn a').attr("href");

		 // テキストが変更された時
		 wp.customize( 'lightning_theme_options[header_top_contact_txt]', function( contact_txt_value ) {
			 contact_txt_value.bind( function( contact_txt_new_val ) {
				 // グローバルのテキストを書き換えておく
				 // contact_txt = contact_txt_value.get();
				 contact_txt = contact_txt_new_val;
				 // console.log( contact_txt_new_val + ' : ' + contact_url );
				 header_top_contact_btn( contact_txt, contact_url );
			 } );
		 } );
	} )( jQuery );
