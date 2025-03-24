<?php
/* *
 *  Lista de enqueue scripts, actions y hooks ADMIN
 * */
function tema_enqueue_scripts_admin()
{
    wp_enqueue_style(
        'tema-admin-style',
        TEMA_A_DIST . '/main.css',
        [],
        '1.0',
        'all'
    );
    wp_enqueue_script(
        'tema-admin-script',
        TEMA_A_DIST . '/main.js',
        ['jquery'],
        '1.0',
        true
    );

    wp_localize_script(
        'tema-admin-script',
        'ajaxData',
        [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('instalar_plugins_nonce'),
        ]
    );
}
add_action('admin_enqueue_scripts', 'tema_enqueue_scripts_admin');

/**
 * SVG
 **/
require_once TEMA_ADMIN . '/svg.php';

/**
 * Creacion de paginas
 **/
require_once TEMA_ADMIN . '/pages.php';

/**
 * Custom post types
 **/
require_once TEMA_FIELDS . '/custom-fields.php';
