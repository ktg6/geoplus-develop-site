<?php
/**
 * Plugin Name:     yStandard Copyright Editor
 * Plugin URI:      https://github.com/yosiakatsuki/ystandard-copyright-editor
 * Description:     This plugin allows you to edit copyright on yStandard theme.
 * Author:          yosiakatsuki
 * Author URI:      https://yosiakatsuki.net/
 * Text Domain:     ystandard-copyright-editor
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         yStandard_Copyright_Editor
 */

/*
	Copyright (c) 2018 Yoshiaki Ogata (https://yosiakatsuki.net/)
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'YSTDCE_PATH', plugin_dir_path( __FILE__ ) );
define( 'YSTDCE_URL', plugin_dir_url( __FILE__ ) );

/**
 * yStandard_Copyright_Editor
 */
function ystdce_plugins_loaded() {
	load_plugin_textdomain(
		'ystandard-copyright-editor',
		false,
		basename( dirname( __FILE__ ) ) . '/languages/'
	);
}

add_action( 'plugins_loaded', 'ystdce_plugins_loaded' );

/**
 * Copyright text
 *
 * @param string $value value.
 *
 * @return string
 */
function ystdce_customizer_sanitize_copyright_text( $value ) {
	$allowed_html = array(
		'a' => array(
			'href'    => array(),
			'target'  => array(),
			'onclick' => array(),
			'title'   => array(),
			'rel'     => array(),
		),
	);

	return wp_kses( $value, $allowed_html );
}

/**
 * カスタマイザーに設定を追加
 *
 * @param  WP_Customize_Manager $wp_customize wp_customize.
 */
function ystdce_customizer_add_extension( $wp_customize ) {
	if ( ystdce_is_enable_ys_customizer() ) {
		$ys_customizer = new YS_Customizer( $wp_customize );

		/**
		 * セクション追加
		 */
		$ys_customizer->add_section(
			array(
				'section'     => 'ystdce_customizer_section_copyright_editor',
				'title'       => 'Copyright設定',
				'panel'       => 'ys_customizer_panel_extension',
				'description' => 'フッターCopyright部分の設定',
			)
		);

		/**
		 * コピーライトのデフォルトを取得
		 */
		$copy_default = '';
		if ( function_exists( 'ys_get_copyright_default' ) ) {
			$copy_default = ys_get_copyright_default();
		}
		/**
		 * コピーライト編集設定追加
		 */
		$ys_customizer->add_text(
			array(
				'id'                => 'ystdce_copyright',
				'default'           => $copy_default,
				'label'             => 'Copyrightの文章',
				'description'       => 'フッターの「Copyright &copy; ~~」の部分の文章を編集出来ます<br>{year}を文章中に書くと「' . date_i18n( 'Y' ) . '」（現在の年）に変換されます。',
				'sanitize_callback' => 'ystdce_customizer_sanitize_copyright_text',
			)
		);
		$ys_customizer->add_checkbox(
			array(
				'id'          => 'ystdce_show_poweredby',
				'label'       => 'Powered by 部分を表示する',
				'description' => '「yStandard Theme by yosiakatsuki Powered by WordPress」の表示・非表示を切り替え出来ます',
				'default'     => 1,
				'section'     => 'ystdce_customizer_section_copyright_editor',
			)
		);
	}
}

add_filter( 'ys_customizer_add_extension', 'ystdce_customizer_add_extension', 11 );

/**
 * Copyright上書き
 *
 * @param  string $copy Copyright.
 *
 * @return string
 */
function ystdce_copyright( $copy ) {
	$ystdce_copy = get_option( 'ystdce_copyright', '' );
	if ( $ystdce_copy ) {
		$copy = str_replace( '{year}', date_i18n( 'Y' ) , $ystdce_copy );
	}

	return $copy;
}

add_filter( 'ys_copyright', 'ystdce_copyright' );

/**
 * Powered By上書き
 *
 * @param $html
 *
 * @return string
 */
function ystdce_delete_poweredby( $html ) {
	if ( ! get_option( 'ystdce_show_poweredby', true ) ) {
		$html = '';
	}

	return $html;
}

add_filter( 'ys_poweredby', 'ystdce_delete_poweredby' );

/**
 * テーマのカスタマイザー追加機能が使えるか確認
 */
function ystdce_is_enable_ys_customizer() {
	if ( ! class_exists( 'YS_Customizer' ) ) {
		return false;
	}

	return true;
}


/**
 * 管理画面
 */
if ( is_admin() ) {
	/**
	 * 更新処理
	 */
	function ystdce_update_check() {
		require_once YSTDCE_PATH. 'library/plugin-update-checker/plugin-update-checker.php';
		$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
			'https://wp-ystandard.com/download/ystandard/plugin/ystandard-copyright-editor/ystandard-copyright-editor.json',
			YSTDCE_PATH . 'ystandard-copyright-editor.php',
			'yStandard Copyright Editor'
		);
	}
	add_action( 'after_setup_theme', 'ystdce_update_check' );
}
