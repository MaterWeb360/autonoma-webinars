<?php
function instalar_plugins_seguridad()
{
    // Verificar nonce para seguridad
    check_ajax_referer('instalar_plugins_nonce', 'nonce');

    // Verificar permisos
    if (!current_user_can('install_plugins')) {
        wp_send_json_error(array('message' => 'No tienes permiso para realizar esta acción.'));
        wp_die();
    }

    $plugins_slugs = array(
        'tinymce-advanced',
        'svg-support',
        'wps-hide-login',
        'limit-login-attempts-reloaded',
        'wp-security-audit-log',
        'advanced-google-recaptcha',
        'wordfence'
    );

    foreach ($plugins_slugs as $plugin_slug) {
        if (! function_exists('is_plugin_active')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }

        // Verificar si el plugin ya está instalado
        if (is_plugin_active("{$plugin_slug}/{$plugin_slug}.php")) {
            continue;
        }

        if (! function_exists('plugins_api')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
        }

        $plugin_info = plugins_api('plugin_information', array(
            'slug'   => $plugin_slug,
            'fields' => array('sections' => false),
        ));

        if (is_wp_error($plugin_info)) {
            error_log('Error al obtener información del plugin: ' . $plugin_slug);
            continue;
        }

        if (! function_exists('request_filesystem_credentials')) {
            include_once(ABSPATH . 'wp-admin/includes/file.php');
        }
        if (! class_exists('Plugin_Upgrader')) {
            include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
        }

        // Instalar el plugin
        $upgrader = new Plugin_Upgrader();
        $installed = $upgrader->install($plugin_info->download_link);

        if ($installed) {
            error_log('Plugin instalado: ' . $plugin_slug);
        } else {
            error_log('Error al instalar el plugin: ' . $plugin_slug);
        }
    }

    wp_send_json_success(array('message' => 'Plugins de seguridad instalados, pero no activados.'));
}
add_action('wp_ajax_instalar_plugins_seguridad', 'instalar_plugins_seguridad');
