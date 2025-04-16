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
        Field::make('text', 'url_api', 'URL API')
            ->set_help_text('Aqui se debe colocar la url a donde se enviaran los datos del formulario')
            ->set_width(100),
        Field::make('complex', 'complex_form_2', __('Campos de formulario'))
            ->setup_labels(['plural_name' => 'Campos de formulario', 'singular_name' => 'Campo de formulario'])
            ->set_collapsed(true)
            ->add_fields(array(

                //1ERA SELECCIÓN DE TIPO DE CAMPOS - 1ER PASO
                Field::make('select', 'campos', __('Elegir campo'))
                    ->set_width(100)
                    ->set_options([
                        '1' => 'Campo de Texto',
                        '2' => 'Campo checkbox',
                        '3' => 'Campo de Selección',
                        '4' => 'Campo de Opciones',
                        '5' => 'Campo Oculto',
                        '6' => 'Campo de Selección de Carreras',
                    ]),
                //Placeholder
                Field::make('text', 'campo_placeholder', 'Título del campo')
                    ->set_help_text('Escribe el texto que describe al campo')
                    ->set_width(50)
                    ->set_required(true)
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => ['1','2','3','4','6'],
                            'compare' => 'IN',
                        ],
                    ]), 
                //Name del campo
                Field::make('text', 'campo_name', 'Identificador del campo')
                    ->set_width(27) 
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => ['5','4','1','3'],
                            'compare' => 'IN',
                        ],
                    ]), 
               
                //Name opciones (solo seleccionables)
                Field::make('text', 'campo_name_option', 'Identificador de las opciones')
                    ->set_width(27) 
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => ['4','3'],
                            'compare' => 'IN',
                        ],
                    ]),
               
                //valor guardado (solo oculto)
                Field::make('text', 'campo_value', 'Dato/código guardado o a guardar')
                    ->set_help_text('Ejm: 0, 10, 21, 17')
                    ->set_width(27)
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => [ '5'],
                            'compare' => 'IN',
                        ],
                    ]),
                //Tamaño del campo
                Field::make('select', 'campo_tamano', 'Tamaño')
                    ->set_width(8)
                    ->set_conditional_logic(array(
                        'relation' => 'AND',
                        array(
                            'field' => 'campos',
                            'value' => ['1','3','6'],
                            'compare' => 'IN',
                        ),
                    ))
                    ->set_options(array(
                        '48%' => '50%',
                        '100%' => '100%',
                    )),
                //Tipo (solo texto)
                Field::make('select', 'campo_tipo', __('Tipo de campo'))
                    ->set_help_text('Dato importante para la validación del campo')
                    ->set_width(15)
                    ->set_options([
                        'email' => 'E-mail',
                        'number' => 'Celular',
                        'text' => 'Texto',
                    ])
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => '1',
                            'compare' => '=',
                        ],
                    ]),
                //CAMPO SELECT
                Field::make('complex', 'campo_select', __('Campo de selección'))
                    ->setup_labels(['plural_name' => 'Selecciones', 'singular_name' => 'Selección'])
                    ->set_help_text('Agregar Items al Seleccionable')
                    ->set_width(100)
                    ->set_layout('tabbed-vertical')
                    ->set_conditional_logic(array(
                        'relation' => 'AND',
                        array(
                            'field' => 'campos',
                            'value' => '3',
                            'compare' => '=',
                        ),
                    ))
                    ->add_fields(array(
                        
                        //PLACEHOLDER - TEXT PARA ESCRIBIR LA PRIMERA OPCION DEL SELECT 
                        Field::make('text', 'campo_select_placeholder', __('Nombre del seleccionable'))
                            ->set_width(50)
                            ->set_conditional_logic(array(
                                'relation' => 'AND',
                                array(
                                    'field' => 'parent.campos',
                                    'value' => '3',
                                    'compare' => '=',
                                ),
                            )),
                        
                        //VALUE - TEXT PARA ESCRIBIR EL CODIGO A GUARDAR
                        Field::make('text', 'campo_select_value', __('Texto o código a guardar'))
                            ->set_width(50)
                            ->set_conditional_logic(array(
                                'relation' => 'AND',
                                array(
                                    'field' => 'parent.campos',
                                    'value' => '3',
                                    'compare' => '=',
                                ),
                            )),
            
                             
                    ))
                    ->set_header_template('Opción <%- $_index + 1 %>'),
                
                //SELECCIONABLE DE CARRERAS
                Field::make('association', 'campo_carreras', __('Escoger carreras o programas'))
                   ->set_types([
                       [
                           'type'      => 'post',
                           'post_type' => 'carreras', 
                       ],
                   ])
                   ->set_help_text('Selecciona hasta 3 carreras')
                   ->set_conditional_logic([
                       'relation' => 'AND',
                       [
                           'field'   => 'campos',
                           'value'   => ['6'],
                           'compare' => 'IN',
                       ],
                    ]),
                //RADIO    
                Field::make('complex', 'campo_radio', __('Grupo de Radio Buttons'))
                    ->setup_labels(['plural_name' => 'Opciones de Radio', 'singular_name' => 'Opción'])
                    ->set_help_text('Configuración completa para grupo de radio buttons con subcampos dinámicos')
                    ->set_width(100)
                    ->set_layout('tabbed-vertical')
                    ->set_conditional_logic(array(
                        'relation' => 'AND',
                        array(
                            'field' => 'campos',
                            'value' => '4',
                            'compare' => '=',
                        ),
                    ))
                    ->add_fields(array(
                        // 1. CAMPOS PRINCIPALES DEL GRUPO RADIO
                        Field::make('text', 'radio_grupo_label', __('Nombre del grupo'))
                            ->set_width(50),
                            
                        Field::make('text', 'radio_grupo_value', __('Texto o código a guardar'))
                            ->set_width(50),

                        Field::make('text', 'radio_subopcion_nombre', __('Identificador del campo'))
                            ->set_help_text('Ejm: cModalidad,cSubPrograma')
                            ->set_width(50),
                        Field::make('text', 'radio_subopcion_valor', __('Identificador de las opciones'))
                            ->set_width(50),
                        //placheolder para el select 
                        Field::make('text', 'radio_select_placeholder', 'Primer texto del seleccionable')
                            ->set_help_text('Este es el primer texto del seleccionable')
                            ->set_width(50)
                            ->set_required(true)
                            ->set_conditional_logic([
                                'relation' => 'AND',
                                [
                                    'field' => 'radio_campos',
                                    'value' => ['2'],
                                    'compare' => 'IN',
                                ],
                                [
                                    'field' => 'radio_check_activar_campos',
                                    'value' => '1',
                                    'compare' => '=',
                                ],
                            ]),
                        
                            
                                        
                                            
            
            
            
                       ))
                    ->set_header_template('
                        <% if (radio_grupo_label) { %>
                            Grupo: <%- radio_grupo_label %> 
                        <% } else { %>
                            Nuevo Grupo de Radio Buttons
                        <% } %>
                    '),
                //CHECKBOX
                Field::make('text', 'check_resaltado', __('Colocar aqui nuevamente el texto que llevará el enlace'))
                    ->set_width(33)
                    ->set_conditional_logic(array(
                        'relation' => 'AND',
                        array(
                            'field' => 'campos',
                            'value' => '2',
                            'compare' => '=',
                        ),
                    )),
                Field::make('text', 'check_enlace', __('Colocar el enlace para el texto resaltado'))
                    ->set_width(33)
                    ->set_conditional_logic(array(
                        'relation' => 'AND',
                        array(
                            'field' => 'campos',
                            'value' => '2',
                            'compare' => '=',
                        ),
                    )),
                Field::make('text', 'check_name', __('Identificador del campo'))
                    ->set_width(50)
                    ->set_conditional_logic(array(
                        'relation' => 'AND',
                        array(
                            'field' => 'campos',
                            'value' => '2',
                            'compare' => '=',
                        ),
                    )),
                Field::make('checkbox', 'check_required', '¿Este checkbox es requerido para enviar el formulario?')
                    ->set_width(50)
                    ->set_conditional_logic(array(
                        'relation' => 'AND',
                        array(
                            'field' => 'campos',
                            'value' => '2',
                            'compare' => '=',
                        ),
                    )),

            ))
            ->set_header_template('Campo: <%- campo_placeholder%> | Tipo: <% switch(campos){
            case "1" : %> Campo de Texto
            <% break; case "2" : %> Campo Checkbox
            <% break; case "3" : %> Campo de Selección
            <% break; case "4" : %> Campo de Opciones
            <% break; case "5" : %> Campo Oculto
            <% break; case "6" : %> Campo de Selección de Carreras
            <% } %>'),
    
        Field::make('text', 'boton', 'Texto del botón del formulario')
            ->set_help_text('Ejm: Enviar, Enviar datos, etc')
            ->set_width(100),    
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
