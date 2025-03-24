<?php
/**
 * Iniciador de los campos del tema
 */

function fields_aedon()
{
    // Configuración del tema
    require TEMA_FIELDS . '/global/cf-global.php';

    // Paginas
    require TEMA_FIELDS . '/pages/cf-inicio.php';
    require TEMA_FIELDS . '/pages/cf-gracias.php';
}
add_action('carbon_fields_register_fields', 'fields_aedon');

function crb_load()
{
    require_once get_template_directory() . '/vendor/autoload.php';
    \Carbon_Fields\Carbon_Fields::boot();
}
add_action('after_setup_theme', 'crb_load');

/* *
 *
 * Llamadas abreviadas
 * */
function elCampo($campo, $item = null)
{
    if (is_array($campo)) {
        return $campo[$item];
    } else {
        return carbon_get_post_meta(get_the_ID(), $campo);
    }
}

function tinyCampo($campo, $item = null)
{
    if (is_array($campo)) {
        return apply_filters('the_content', $campo[$item]);
    } else {
        return apply_filters('the_content', carbon_get_post_meta(get_the_ID(), $campo));
    }
}

function fileCampo($campo, $item = null)
{
    if (is_array($campo)) {
        return wp_get_attachment_url($campo[$item]);
    } else {
        return wp_get_attachment_url(carbon_get_post_meta(get_the_ID(), $campo));
    }
}

function globalCampo($campo)
{
    return carbon_get_theme_option($campo);
}
