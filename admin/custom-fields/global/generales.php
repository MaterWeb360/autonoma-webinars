<?php

use Carbon_Fields\Field;

$basic_options_container->add_tab('Generales', [
    Field::make('separator', 'g-plugins-sep', 'Plugins de seguridad')
        ->set_classes('separator_theme'),
    Field::make('html', 'crb_information_text')
        ->set_html('<button id="btn-seguridad">Instalar plugins de seguridad</button><div id="plugins-proceso"></div>')
        ->help_text('Solo debe activarse una vez'),

    Field::make('separator', 'g-separator_4', 'Logotipos')
        ->set_classes('separator_theme'),
    Field::make('image', 'g-logotipo-blanco', 'Logotipo')
        ->set_type(array('image'))
        ->set_value_type('url'),
    Field::make('image', 'g-favicon', 'Favicon')
        ->set_type(array('image'))
        ->set_value_type('url')
        ->set_help_text('Tamaño de imagen recomendado: 150 × 150 px'),

    Field::make('separator', 'g-separator-fo', 'Footer')
        ->set_classes('separator_theme'),
    Field::make('text', 'g-direccion', 'Dirección'),
    Field::make('text', 'g-telefono', 'Teléfono'),
    Field::make('text', 'g-email', 'Email'),

    // Field::make('separator', 'g-utms-sep', 'UTMS')
    //     ->set_classes('separator_theme'),
    // Field::make('text', 'g_utm_source', 'UTM Source')
    //     ->set_width(33),
    // Field::make('text', 'g_utm_medium', 'UTM Medium')
    //     ->set_width(33),
    // Field::make('text', 'g_utm_campaign', 'UTM Campaign')
    //     ->set_width(34),
    // Field::make('text', 'g_utm_term', 'UTM Term')
    //     ->set_width(33),
    // Field::make('text', 'g_utm_content', 'UTM Content')
    //     ->set_width(33),
    // Field::make('text', 'g_zc_gad', 'ZC Gad')
    //     ->set_width(34),

    Field::make('separator', 'g-scripts-sep', 'Scripts')
        ->set_classes('separator_theme'),
    Field::make('textarea', 'g_script_header', 'Scripts Cabecera')
        ->set_width(50),
    Field::make('textarea', 'g_script_footer', 'Scripts Footer')
        ->set_width(50)
]);
