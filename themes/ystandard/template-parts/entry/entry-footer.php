<?php
/**
 * 記事下表示テンプレート（親）
 *
 * @package ystandard
 * @author yosiakatsuki
 * @license GPL-2.0+
 */

/**
 * 読み込むテンプレートをまとめた配列を取得・展開
 *
 * 特にカスタマイズしていなければ、template-parts/entry/entry-footer-block の中のファイルを読み込む
 * 読み込むテンプレートのリストは inc/template/template.php内で作成
 */
$templates = ys_get_entry_footer_template();
foreach ( $templates as $key => $template ) {
	get_template_part( $template );
}