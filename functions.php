<?php

/**
 * Constantes tema
 **/
define('TEMA_PUBLIC', get_template_directory() . '/public');
define('TEMA_P_DIST', get_template_directory_uri() . '/public/assets/dist');
define('TEMA_P_IMG', get_template_directory_uri() . '/public/assets/imgs');
define('TEMA_P_VIDEO', get_template_directory_uri() . '/public/assets/video');
define('TEMA_P_FONTS', get_template_directory_uri() . '/public/assets/fonts');

define('TEMA_P_PAGES', get_template_directory() . '/public/pages');

define('TEMA_P_PARTIALS', 'public/partials');
define('TEMA_P_HEADER', 'public/partials/header/header');
define('TEMA_P_FOOTER', 'public/partials/footer/footer');
define('TEMA_P_CONTENT', 'public/partials/content/content');

define('TEMA_ADMIN', get_template_directory() . '/admin');
define('TEMA_A_DIST', get_template_directory_uri() . '/admin/assets/dist');
define('TEMA_A_IMG', get_template_directory_uri() . '/admin/assets/imgs');
define('TEMA_A_FONTS', get_template_directory_uri() . '/admin/assets/fonts');

define('TEMA_LOGIN', get_template_directory() . '/login');
define('TEMA_L_DIST', get_template_directory_uri() . '/login/assets/dist');
define('TEMA_L_IMG', get_template_directory_uri() . '/login/assets/imgs');
define('TEMA_L_FONTS', get_template_directory_uri() . '/login/assets/fonts');

define('TEMA_INC', get_template_directory() . '/includes');
define('TEMA_HELPERS', get_template_directory() . '/helpers');
define('TEMA_LIBS', get_template_directory_uri() . '/libraries');
define('TEMA_FIELDS', get_template_directory() . '/admin/custom-fields');
define('TEMA_VIEWS', get_template_directory() . '/admin/views');

define('TEMA_LANG', get_template_directory() . '/languages');

$GLOBALS['TEMA_P_IMG'] = TEMA_P_IMG;

/**
 * Includes
 **/
require_once TEMA_INC . '/includes.php';
/**
 * Admin
 **/
require_once TEMA_ADMIN . '/admin.php';
/**
 * Public
 **/
require_once TEMA_PUBLIC . '/public.php';

/**
 * Login
 **/
require_once TEMA_LOGIN . '/login.php';
/**
 * Helpers
 **/
require_once TEMA_HELPERS . '/helpers.php';
