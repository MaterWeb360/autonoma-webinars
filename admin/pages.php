<?php
/* *
 *  Crear páginas automáticamente
 * */
function crear_pagina($titulo_pagina, $slug_pagina)
{
    $pagina_existente = get_page_by_path($slug_pagina, OBJECT, 'page');

    if (!$pagina_existente) {
        $pagina = array(
            'post_title'    => $titulo_pagina,
            'post_name'     => sanitize_title($slug_pagina),
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page'
        );
        wp_insert_post($pagina);
    }
}

function crear_paginas()
{
    crear_pagina('Inicio', 'inicio');
    crear_pagina('Gracias', 'gracias');
}
add_action('after_switch_theme', 'crear_paginas');


/* *
 *  Establecer la página de inicio como página de portada estática
 * */
function establecer_pagina_inicio()
{
    $args = array(
        'post_type' => 'page',
        'title' => 'Inicio',
        'posts_per_page' => 1
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $pagina_inicio = $query->posts[0];
        $pagina_id = $pagina_inicio->ID;

        // Actualiza la configuración de WordPress
        update_option('show_on_front', 'page');
        update_option('page_on_front', $pagina_id);
    }

    wp_reset_postdata();
}
add_action('after_switch_theme', 'establecer_pagina_inicio');
