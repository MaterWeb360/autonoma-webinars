<?php

/**
 * Lista de enqueue scripts, actions y hooks FRONT
 **/
function tema_enqueue_scripts()
{
    // CSS files
    wp_enqueue_style(
        'theme-css',
        get_stylesheet_uri(),
        [],
        '1.0.0',
        'all'
    );

    wp_enqueue_style(
        'tema-theme-style',
        TEMA_P_DIST . '/main.css',
        [],
        '1.0',
        'all'
    );

    // JS files
    wp_enqueue_script(
        'jquery-cloudfront',
        'https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=67a100d7638ec16f941cd508',
        ['jquery'],
        '3.5.1',
        true
    );

    //wp_enqueue_script(
    //    'tema-parsley',
    //    'https://parsleyjs.org/dist/parsley.js',
    //    ['jquery'],
    //    '1.0',
    //    true
    //);

    wp_enqueue_script(
        'tema-scripts',
        TEMA_P_DIST . '/main.js',
        ['jquery'],
        '1.0',
        true
    );

    add_filter('style_loader_tag', __NAMESPACE__ . '\enqueue_crossorigin_integrity', 10, 2);
    add_filter('script_loader_tag', __NAMESPACE__ . '\enqueue_crossorigin_integrity', 10, 2);
}
add_action('wp_enqueue_scripts', 'tema_enqueue_scripts');

/**
 * crossorigin and integrity
 **/
function enqueue_crossorigin_integrity($html, $handle): string
{
    switch ($handle) {
        case 'jquery-cloudfront':
            $html = str_replace('></script>', ' integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>', $html);
            break;
    }
    return $html;
}
