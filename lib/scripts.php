<?php
function add_scripts() {
	// WordPress本体のjquery.jsを読み込まない
wp_deregister_script('jquery');
// jQueryの読み込み
// wp_enqueue_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery.min.js', "", "", false );
// wp_enqueue_script( 'velocity', get_template_directory_uri() . '/assets/js/velocity.js', "", '', false );
// wp_enqueue_script( 'common', get_template_directory_uri() . '/assets/js/common.js', "", '', false );
// wp_enqueue_script( 'iscroll', get_template_directory_uri() . '/assets/js/iscroll.js', "", '', false );
}

add_action('wp_print_scripts', 'add_scripts');
