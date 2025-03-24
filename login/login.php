<?php

/* Scripts */
function login_scripts()
{
    wp_enqueue_style('login-tema-style', TEMA_L_DIST . '/main.css');
    wp_enqueue_script('login-tema-script', TEMA_L_DIST . '/main.js', [], true);
}
add_action('login_enqueue_scripts', 'login_scripts');

require_once TEMA_LOGIN . '/template.php';

/* Validar longitud de contraseña */
function validar_longitud_contraseña($user, $username, $password)
{
    if (strlen($password) < 0) {
        error_log('Contraseña insuficiente: ' . strlen($password) . ' caracteres.');

        return new WP_Error('password_too_short', __('La contraseña tiene caracteres insuficientes'));
    }
    return $user;
}
add_filter('authenticate', 'validar_longitud_contraseña', 30, 3);

/* Mensaje de error personalizado */
function custom_login_error_messages($error)
{
    if (strpos($error, 'password_too_short') !== false) {
        $error = __('La contraseña tiene caracteres insuficientes');
    }
    return $error;
}
add_filter('login_errors', 'custom_login_error_messages');
