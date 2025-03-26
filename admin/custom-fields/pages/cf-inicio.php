<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('post_meta', 'header', 'Cabecera')
    ->where('post_type', '=', 'page')
    ->where('post_id', '!=', function() {
        $gracias_page = get_page_by_path('gracias'); 
        return $gracias_page ? $gracias_page->ID : 0;
    })
    ->add_fields([
        Field::make('text', 'he-etiqueta', 'Etiqueta superior'),
        Field::make('textarea', 'he-titulo', 'Título')
            ->set_rows(2)
            ->help_text('Para resaltar texto en naranja, encerrarlo en * (Ejm: *texto reslatado*)'),
        Field::make('text', 'he-subtitulo', 'Subtitulo'),
        Field::make('image', 'he-img', 'Imagen de fondo')
            ->set_width(50),
        Field::make('image', 'he-img-mobile', 'Imagen de fondo mobile')
            ->set_width(50)
    ]);

Container::make('post_meta', 'formulario', 'Formulario')
    ->where('post_type', '=', 'page')
    ->where('post_id', '!=', function() {
        $gracias_page = get_page_by_path('gracias'); 
        return $gracias_page ? $gracias_page->ID : 0;
    })
    ->add_fields([
        Field::make('complex', 'complex_form_2', __('Campos de formulario'))
            ->setup_labels(['plural_name' => 'Campos de formulario', 'singular_name' => 'Campo de formulario'])
            ->set_collapsed(true)
            ->add_fields(array(

                Field::make('select', 'campos', __('Elegir campo'))
                    ->set_width(100)
                    ->set_options([
                        '1' => 'Campo general texto (input text)',
                        '3' => 'Campo general selección (select)',
                        '4' => 'Campo de opciones (radios)',
                        '5' => 'Campo oculto (input text hidden)',
                    ]),

                Field::make('text', 'placehonder_campo', 'Mensaje del campo (placeholder)')
                    ->set_help_text('Mensaje del campo que aparecerá como indicación. Ejemplo: "Ingresar apellidos", "Ingresar DNI"')
                    ->set_width(27)
                    ->set_required(true)
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => ['1', '2', '3', '4'],
                            'compare' => 'IN',
                        ],
                    ]),

                Field::make('text', 'nombre_campo', 'Nombre del campo (name)')
                    ->set_help_text('Nombre de valor del campo, NO utilizar espacios en blanco. Ejemplo: "Apellidos", "DNI", "primer_nombre"')
                    ->set_width(27)
                    ->set_required(true)
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => ['1', '2', '3', '4', '5'],
                            'compare' => 'IN',
                        ],
                    ]),

                Field::make('text', 'valor_campo', 'Valor del campo predeterminado (value)')
                    ->set_help_text('Asignar un valor predeterminado para el campo')
                    ->set_width(30)
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => '5',
                            'compare' => '=',
                        ],
                    ]),

                Field::make('select', 'tipo_texto_campo', 'Tipo de campo de texto')
                    ->set_width(26)
                    ->set_required(true)
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => '1',
                            'compare' => '=',
                        ],
                    ])
                    ->set_options([
                        '1a' => 'Texto',
                        '2b' => 'E-mail',
                        '3c' => 'Numerico'
                    ]),

                Field::make('text', 'limite_campo', 'Limite de digitos')
                    ->set_help_text('Cantidad de digitos permitidos')
                    ->set_width(10)
                    ->set_required(true)
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'tipo_texto_campo',
                            'value' => '3c',
                            'compare' => '=',
                        ],
                    ]),

                Field::make('select', 'tamano_campo', 'Tamaño de campo')
                    ->set_width(10)
                    ->set_required(true)
                    ->set_conditional_logic(array(
                        'relation' => 'AND',
                        array(
                            'field' => 'campos',
                            'value' => ['1', '2','3'],
                            'compare' => 'IN',
                        ),
                    ))
                    ->set_options(array(
                        '1t' => '50%',
                        '2t' => '100%',
                    )),

                Field::make('association', 'nombre_seleccion', __('Carreras'))
                    ->set_types([
                        [
                            'type'      => 'post',
                            'post_type' => 'carreras', // Asegúrate de que el post type se llame "carreras"
                        ],
                    ])
                    ->set_help_text('Selecciona hasta 3 carreras')
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field'   => 'campos',
                            'value'   => ['3'],
                            'compare' => 'IN',
                        ],
                    ]),
                

                Field::make('complex', 'opciones_campo', __('Opciones para selección unica'))
                    ->setup_labels(['plural_name' => 'Opciones', 'singular_name' => 'Opción'])
                    ->set_help_text('Ingresar la opción para mostrar')
                    ->set_width(100)
                    ->set_layout('tabbed-vertical')
                    ->set_required(true)
                    ->set_conditional_logic(array(
                        'relation' => 'AND',
                        array(
                            'field' => 'campos',
                            'value' => '4',
                            'compare' => '=',
                        ),
                    ))
                    ->add_fields(array(
                        Field::make('text', 'opcion_seleccion', __('Opción')),
                    ))
                    ->set_header_template('Opción <%- $_index + 1 %>'),

            ))
            ->set_header_template('Campo: <%- placehonder_campo%> | Tipo: <% switch(campos){
            case "1" : %> Campo Texto
            <% break; case "2" : %> Campo Número
            <% break; case "3" : %> Campo Selección
            <% break; case "4" : %> Campo Opciones
            <% break; case "5" : %> Campo Oculto
            <% break; case "6" : %> Selector de proyectos
            <% } %>')
    ]);

Container::make('post_meta', 'infoini', 'Información inicial')
    ->where('post_type', '=', 'page')
    ->where('post_id', '!=', function() {
        $gracias_page = get_page_by_path('gracias'); 
        return $gracias_page ? $gracias_page->ID : 0;
    })
    ->add_fields([
        Field::make('checkbox', 'in-show', '¿Ocultar Sección?')
            ->set_option_value('yes'),
        Field::make('textarea', 'in-titulo', 'Título de sección')
            ->set_rows(2),
        Field::make('textarea', 'in-informacion', 'Información'),
        Field::make('textarea', 'in-duracion', 'Duración')
            ->set_width(33)
            ->set_rows(2),
        Field::make('textarea', 'in-fecha', 'Fecha')
            ->set_width(33)
            ->set_rows(2),
        Field::make('textarea', 'in-ubicacion', 'Ubicación')
            ->set_width(33)
            ->set_rows(2),
    ]);

Container::make('post_meta', 'beneficios', 'Beneficios')
    ->where('post_type', '=', 'page')
    ->where('post_id', '!=', function() {
        $gracias_page = get_page_by_path('gracias'); 
        return $gracias_page ? $gracias_page->ID : 0;
    })
    ->add_fields([
        Field::make('checkbox', 'be-show', '¿Ocultar Sección?')
            ->set_option_value('yes'),
        Field::make('textarea', 'be-titulo', 'Título de sección')
            ->set_rows(2),
        Field::make('textarea', 'be-informacion', 'Información'),
        Field::make('image', 'be-imagen', 'Imagen lateral'),
    ]);

Container::make('post_meta', 'video', 'Video')
    ->where('post_type', '=', 'page')
    ->where('post_id', '!=', function() {
        $gracias_page = get_page_by_path('gracias'); 
        return $gracias_page ? $gracias_page->ID : 0;
    })
    ->add_fields([
        Field::make('checkbox', 'vi-show', '¿Ocultar Sección?')
            ->set_option_value('yes'),
        Field::make('textarea', 'vi-titulo', 'Título de sección')
            ->set_rows(2)
            ->help_text('Para resaltar texto en naranja, encerrarlo en * (Ejm: *texto reslatado*)'),
        Field::make('file', 'vi-video-pre', 'Video preview')
            ->set_type(['video']),
        Field::make('text', 'vi-video', 'Video modal')
            ->set_attribute('type', 'url')
            ->set_help_text('Solo acepta URLS de videos de youtube')
    ]);

Container::make('post_meta', 'expositor', 'Expositor')
    ->where('post_type', '=', 'page')
    ->where('post_id', '!=', function() {
        $gracias_page = get_page_by_path('gracias'); 
        return $gracias_page ? $gracias_page->ID : 0;
    })
    ->add_fields([
        Field::make('checkbox', 'ex-show', '¿Ocultar Sección?')
            ->set_option_value('yes'),
        Field::make('textarea', 'ex-titulo', 'Título de sección')
            ->set_rows(2)
            ->help_text('Para resaltar texto en negro, encerrarlo en * (Ejm: *texto reslatado*)'),
        Field::make('text', 'ex-nombre', 'Nombre del expositor'),
        Field::make('text', 'ex-puesto', 'Puesto laboral'),
        Field::make('textarea', 'ex-informacion', 'Información'),
        Field::make('image', 'ex-img', 'Imagen lateral')
    ]);

Container::make('post_meta', 'webinars', 'Webinars')
    ->where('post_type', '=', 'page')
    ->where('post_id', '!=', function() {
        $gracias_page = get_page_by_path('gracias'); 
        return $gracias_page ? $gracias_page->ID : 0;
    })
    ->add_fields([
        Field::make('checkbox', 'we-show', '¿Ocultar Sección?')
            ->set_option_value('yes'),
        Field::make('textarea', 'we-titulo', 'Título de sección')
            ->set_rows(2)
            ->help_text('Para resaltar texto en negro, encerrarlo en * (Ejm: *texto reslatado*)'),
        Field::make('textarea', 'we-informacion', 'Información'),
        Field::make('complex', 'we-webinars', 'Lista de webinars')
            ->setup_labels(['plural_name' => 'Webinars', 'singular_name' => 'Webinar'])
            ->set_layout('tabbed-vertical')
            ->add_fields([
                Field::make('date_time', 'fecha', 'Fecha y hora'),
                Field::make('text', 'ubicacion', 'Ubicación'),
                Field::make('text', 'titulo', 'Título'),
                Field::make('text', 'descripcion', 'Descripción'),
                Field::make('text', 'url', 'Enlace URL')
                    ->set_attribute('type', 'url'),
                Field::make('image', 'imagen', 'Imagen')
            ])
    ]);

Container::make('post_meta', 'carreras', 'Carreras')
    ->where('post_type', '=', 'page')
    ->where('post_id', '!=', function() {
        $gracias_page = get_page_by_path('gracias'); 
        return $gracias_page ? $gracias_page->ID : 0;
    })
    ->add_fields([
        Field::make('checkbox', 'ca-show', '¿Ocultar Sección?')
            ->set_option_value('yes'),
        Field::make('textarea', 'ca-titulo', 'Título de sección')
            ->set_rows(2)
            ->help_text('Para resaltar texto en negro, encerrarlo en * (Ejm: *texto reslatado*)'),
        Field::make('complex', 'ca-lista', 'Lista de carreras')
            ->setup_labels(['plural_name' => 'Carreras', 'singular_name' => 'Carrera'])
            ->set_layout('tabbed-vertical')
            ->add_fields([
                Field::make('text', 'titulo', 'Titulo'),
                Field::make('text', 'url', 'Enlace URL')
                    ->set_attribute('type', 'url'),
                Field::make('image', 'imagen', 'Imagen de fondo')
            ])
    ]);
