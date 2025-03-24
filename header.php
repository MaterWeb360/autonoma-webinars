<?php

/** Constancia
 * attr data-wf-page, data-wf-site, data-w-id
 * de plantillas
 **/
$data_wf_page = '';
$extraclass = '';
$pageclass = '';
$data_wf_site = '67a100d7638ec16f941cd508';

// Favicon del frontend
$favicon = globalCampo('g-favicon');

$ubicacion = get_post_field('post_name', get_post());

if (is_front_page()) {
    $data_wf_page = '67a1021497306af2adfd2a68';
    // $pageclass = 'overflow-visible';
    // $extraclass = 'is-home';
} elseif (is_page()) {
}


/**
 * Template-parts: Header
 **/
get_template_part(TEMA_P_HEADER, 'head', [
    'wf-page' => $data_wf_page,
    'wf-site' => $data_wf_site,
    'favicon' => $favicon
]);

/**
 * Tag body HTML
 **/
?>

<body <?= body_class() ?> data-w-id="<?= $data_wf_body ?>">
    <div id="page" class="page-wrapper <?= $pageclass ?>">
        <main id="main" class="main-wrapper <?= $extraclass ?>">
            <?php
            get_template_part(TEMA_P_HEADER, 'nav', []);
