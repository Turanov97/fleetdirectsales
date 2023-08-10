<?php

require_once __DIR__ . '/inc/inc.php';

function wpdocs_theme_name_scripts() {
    wp_enqueue_style( 'style-name', get_stylesheet_uri() );
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('main-child', get_stylesheet_directory_uri() . '/assets/front/js/main.js', array('jquery'), null, true);
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );


if (!function_exists('write_log')) {

    function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

}

function enqueue_custom_editor_scripts() {
    wp_enqueue_script('jquery-ui-tabs'); // Загружаем jQuery UI Tabs
    wp_enqueue_style('custom-editor-style', get_stylesheet_directory_uri() . '/assets/admin/css/custom-editor-style.css');
    wp_enqueue_script('custom-editor-script', get_stylesheet_directory_uri() . '/assets/admin/js/custom-editor-script.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_custom_editor_scripts');
