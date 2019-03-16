<?php
/**
 * ystandard子テーマの関数
 */

// psdファイルのアップロードを可能にする
function allow_upload_psd( $mimes ) {
    $mimes['psd'] = 'image/x-photoshop'; 
    return $mimes;
}
add_filter( 'upload_mimes', 'allow_upload_psd' );

