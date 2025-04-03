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

                //1ERA SELECCIÓN DE TIPO DE CAMPOS - 1ER PASO
                Field::make('select', 'campos', __('Elegir campo'))
                    ->set_width(100)
                    ->set_options([
                        '1' => 'Campo de Texto',
                        '3' => 'Campo de Selección',
                        '4' => 'Campo de Opciones',
                        '5' => 'Campo Oculto',
                        '6' => 'Campo de Selección de Carreras',
                    ]),
                
                //CAMPO TEXTO - NOMBRE DEL CAMPO (placeholder o label) (Para tipo: text, select, radio, select carreras)
                Field::make('text', 'campo_placeholder_label', 'Título del campo')
                    ->set_help_text('Guía para el usuario de lo que debe hacer en el campo; Ejm: Apellidos o Escribe tu nombre')
                    ->set_width(100)
                    ->set_required(true)
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => ['1','4'],
                            'compare' => 'IN',
                        ],
                    ]),
                //CAMPO TEXTO - NOMBRE DE la PRIMERA OPCION DEL CAMPO SELECCION (primera opción) (Para tipo: select)
                Field::make('text', 'campo_placeholder_select', 'Primera opción del select')
                    ->set_help_text('Aparecerá como primera opción del select, pero será NO SELECCIONABLE, es un título')
                    ->set_width(27)
                    ->set_required(true)
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => ['3','6'],
                            'compare' => 'IN',
                        ],
                    ]),
                //CAMPO TEXTO - NAME (Para tipo: text, select, radio, hidden, select carreras)
                Field::make('text', 'campo_name', 'Identificador de las opciones')
                    ->set_help_text('Ejm: nModalidad, nSubPrograma, nPrograma')
                    ->set_width(27) 
                    ->set_required(true)
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => ['1', '3', '4', '5','6'],
                            'compare' => 'IN',
                        ],
                    ]),
                //CAMPO TEXTO - VALUE (Para tipo:  radio, hidden)
                Field::make('text', 'campo_value', 'Dato/código guardado o a guardar')
                    ->set_help_text('Ejm: 0, 10, 21, 17')
                    ->set_width(27)
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => [ '4', '5'],
                            'compare' => 'IN',
                        ],
                    ]),
                //CAMPO TEXTO - NAME DE LAS OPCIONES DE UN SELECT (Para tipo: select)
                Field::make('text', 'campo_value_seleccionado', 'Identificador del campo')
                    ->set_help_text('Ejm: cModalidad,cSubPrograma')
                    ->set_width(50)
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => ['3','6'],
                            'compare' => 'IN',
                        ],
                    ]),
                
                //CAMPO SELECCIONABLE TAMAÑO - ELECCION DE TAMAÑO DE CAMPO (1,3)
                Field::make('select', 'campo_tamano', 'Tamaño')
                    ->set_width(8)
                    ->set_conditional_logic(array(
                        'relation' => 'AND',
                        array(
                            'field' => 'campos',
                            'value' => ['1','3','4','6'],
                            'compare' => 'IN',
                        ),
                    ))
                    ->set_options(array(
                        '1t' => '50%',
                        '2t' => '100%',
                    )),
                
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
                            ->set_help_text('El valor que se agregue aquí, viajará con el nombre del "Identificador del campo"')
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
                            ->set_help_text('El valor que se agregue aquí, viajará con el nombre del "Identificador de las opciones"')
                            ->set_width(50)
                            ->set_conditional_logic(array(
                                'relation' => 'AND',
                                array(
                                    'field' => 'parent.campos',
                                    'value' => '3',
                                    'compare' => '=',
                                ),
                            )),
                        //CAMPO TEXTO - VALUE CODIGO DE FORMULARIO (Para tipo: select)
                        Field::make('text', 'campo_cod_form', 'Código de formulario para el flujo')
                            ->set_help_text('Ejm: Aquí solo viajará el ---> cCodFormExterno')
                            ->set_width(50)
                            ->set_conditional_logic([
                                'relation' => 'AND',
                                [
                                    'field' => 'parent.campos',
                                    'value' => ['3','6'],
                                    'compare' => 'IN',
                                ],
                            ]),
                        //CHECKBOX - PARA ACTIVAR MAS CAMPOS DENTRO DEL SELECT
                        Field::make('checkbox', 'campo_check_activar_campos', __('¿Deseas abrir campos que dependan de esta selección?'))
                            ->set_option_value('1') // Asegurar que guarde '1' en lugar de 'true'
                            ->set_help_text('Marca esta opción para mostrar las carreras/programas.'),


                        
                        //SELECCIONABLE DE CAMPOS SI MARCA LA OPCION SI ARRIBA
                        Field::make('select', 'mas_campos_subselect', __('Elige el tipo de campo que se abrirá al hacer clic en la opción del select'))
                            ->set_width(100)
                            ->set_options([
                                '1' => 'Campo de Texto',
                                '3' => 'Campo de Selección Simple',
                                '4' => 'Campo de Selección multiple',
                                '6' => 'Campo de Selección de Carreras',
                            ])
                            ->set_conditional_logic([
                                'relation' => 'AND',
                                [
                                    'field' => 'campo_check_activar_campos',
                                    'value' => '1',
                                    'compare' => '=',
                                ],
                            ]),
                            //PARA TIPO TEXTO    
                                //PLACEHOLDER DE CAMPO TEXTO - NOMBRE DEL CAMPO
                                Field::make('text', 'campo_subselect_text_place', 'Título del campo')
                                    ->set_help_text('Guía para el usuario de lo que debe hacer en el campo; Ejm: Apellidos o Escribe tu nombre')
                                    ->set_width(50)
                                    ->set_required(true)
                                    ->set_conditional_logic([
                                        'relation' => 'AND',
                                        [
                                            'field' => 'mas_campos_subselect',
                                            'value' => ['1'],
                                            'compare' => 'IN',
                                        ],
                                        [
                                            'field' => 'campo_check_activar_campos',
                                            'value' => '1',
                                            'compare' => '=',
                                        ],
                                    ]),
                                //CAMPO TEXTO - NAME (Para tipo: text, select, radio, hidden, select carreras)
                                Field::make('text', 'campo_subselect_text_name', 'Identificador del campo')
                                    ->set_help_text('Ejm: cModalidad, cSubPrograma')
                                    ->set_width(50) 
                                    ->set_required(true)
                                    ->set_conditional_logic([
                                        'relation' => 'AND',
                                        [
                                            'field' => 'mas_campos_subselect',
                                            'value' => ['1'],
                                            'compare' => 'IN',
                                        ],
                                        [
                                            'field' => 'campo_check_activar_campos',
                                            'value' => '1',
                                            'compare' => '=',
                                        ],
                                    ]),
                                
                            //PARA TIPO SELECCIÓN DE CARRERAS
                                //ASOCIACION DE CARRERAS
                                Field::make('association', 'campo_subselect_carreras', 'Carreras') 
                                    ->set_help_text('Selecciona las carreras/programas que aparecerán en el select')
                                    ->set_width(100)
                                    ->set_types([
                                        [
                                            'type'      => 'post',
                                            'post_type' => 'carreras',
                                        ],
                                    ])
                                    ->set_conditional_logic([
                                        'relation' => 'AND',
                                        [
                                            'field' => 'mas_campos_subselect',
                                            'value' => ['6'],
                                            'compare' => 'IN',
                                        ],
                                        [
                                            'field' => 'campo_check_activar_campos',
                                            'value' => '1',
                                            'compare' => '=',
                                        ],
                                    ]),
                            //PARA TIPO  SELECCION SIMPLE   - SUB NIVEL SELECCIÓN 1
                                //CAMPO TEXTO - NOMBRE DE la PRIMERA OPCION DEL CAMPO SELECCION (primera opción) (Para tipo: select)
                                Field::make('text', 'campo_subselect_select_place', 'Nombre del seleccionable')
                                    ->set_help_text('Aparecerá como primera opción del select, pero será NO SELECCIONABLE, es un título')
                                    ->set_width(27)
                                    ->set_required(true)
                                    ->set_conditional_logic([
                                        'relation' => 'AND',
                                        [
                                            'field' => 'mas_campos_subselect',
                                            'value' => ['3'],
                                            'compare' => 'IN',
                                        ],
                                        [
                                            'field' => 'campo_check_activar_campos',
                                            'value' => '1',
                                            'compare' => '=',
                                        ],
                                    ]),
                                //CAMPO TEXTO - NAME (Para tipo: text, select, radio, hidden, select carreras)
                                Field::make('text', 'campo_subselect_select_name', 'Identificador del campo')
                                    ->set_help_text('Ejm: cApellidos, cCelular, cCodFormExterno, cCarrera, cModalidad, cSubPrograma')
                                    ->set_width(27) 
                                    ->set_required(true)
                                    ->set_conditional_logic([
                                        'relation' => 'AND',
                                        [
                                            'field' => 'mas_campos_subselect',
                                            'value' => ['3'],
                                            'compare' => 'IN',
                                        ],
                                        [
                                            'field' => 'campo_check_activar_campos',
                                            'value' => '1',
                                            'compare' => '=',
                                        ],
                                    ]),
                                //CAMPO TEXTO - NAME DE LAS OPCIONES DE UN SELECT (Para tipo: select)
                                Field::make('text', 'campo_subselect_select_nameseleccion', 'Identificador de las opciones')
                                    ->set_help_text('Ejm: nModalidad,nSubPrograma')
                                    ->set_width(50)
                                    ->set_conditional_logic([
                                        'relation' => 'AND',
                                        [
                                            'field' => 'mas_campos_subselect',
                                            'value' => ['3'],
                                            'compare' => 'IN',
                                        ],
                                        [
                                            'field' => 'campo_check_activar_campos',
                                            'value' => '1',
                                            'compare' => '=',
                                        ],
                                    ]),

                                //CAMPO SELECCIONABLE TAMAÑO - ELECCION DE TAMAÑO DE CAMPO (1,3)
                                Field::make('select', 'campo_subselect_tamano', 'Tamaño')
                                    ->set_width(50)
                                    ->set_required(true)
                                    ->set_conditional_logic([
                                        'relation' => 'AND',
                                        [
                                            'field' => 'mas_campos_subselect',
                                            'value' => ['3'],
                                            'compare' => 'IN',
                                        ],
                                        [
                                            'field' => 'campo_check_activar_campos',
                                            'value' => '1',
                                            'compare' => '=',
                                        ],
                                    ])
                                    ->set_options(array(
                                        '1t' => '50%',
                                        '2t' => '100%',
                                    )),
                                //ULTIMO CAMPO COMPLEX ANIDADO
                                Field::make('complex', 'campo_subselect_select', 'Campo de selección')
                                    ->set_help_text('Seleccione las opciones')
                                    ->set_width(100)
                                    ->set_layout('tabbed-vertical')
                                    ->set_conditional_logic([
                                        'relation' => 'AND',
                                        [
                                            'field' => 'mas_campos_subselect',
                                            'value' => ['3'],
                                            'compare' => 'IN',
                                        ],
                                        [
                                            'field' => 'campo_check_activar_campos',
                                            'value' => '1',
                                            'compare' => '=',
                                        ],
                                    ])
                                    ->add_fields(array(   
                                        //CAMPO TEXTO - NOMBRE DE la PRIMERA OPCION DEL CAMPO SELECCION (primera opción) (Para tipo: select)
                                        Field::make('text', 'campo_subsubselect_select_place', 'Nombre del seleccionable')
                                            ->set_help_text('Ejm: Modalidad, Horarios')
                                            ->set_width(27)
                                            ->set_required(true),
                                        //CAMPO TEXTO - NAME (Para tipo: text, select, radio, hidden, select carreras)
                                        Field::make('text', 'campo_subsubselect_select_name', 'Texto o código a guardar')
                                            ->set_help_text('Ejm: 0,1')
                                            ->set_width(27) 
                                            ->set_required(true),
                                    )),
                            //PARA TIPO  SELECCION MULTIPLE  - SUB NIVEL SELECCIÓN 1
                                //CAMPO TEXTO - NOMBRE DE la PRIMERA OPCION DEL CAMPO SELECCION (primera opción) (Para tipo: select)
                                Field::make('text', 'campo_submultiselect_select_place', 'Nombre del seleccionable')
                                    ->set_help_text('Aparecerá como primera opción del select, pero será NO SELECCIONABLE, es un título')
                                    ->set_width(27)
                                    ->set_conditional_logic([
                                        'relation' => 'AND',
                                        [
                                            'field' => 'mas_campos_subselect',
                                            'value' => ['4'],
                                            'compare' => 'IN',
                                        ],
                                        [
                                            'field' => 'campo_check_activar_campos',
                                            'value' => '1',
                                            'compare' => '=',
                                        ],
                                    ]),
                                //CAMPO TEXTO - NAME (Para tipo: text, select, radio, hidden, select carreras)
                                Field::make('text', 'campo_submultiselect_select_name', 'Identificador de las opciones')
                                    ->set_help_text('Ejm: nModalidad, nSubPrograma, nPrograma')
                                    ->set_width(27)
                                    ->set_conditional_logic([
                                        'relation' => 'AND',
                                        [
                                            'field' => 'mas_campos_subselect',
                                            'value' => ['4'],
                                            'compare' => 'IN',
                                        ],
                                        [
                                            'field' => 'campo_check_activar_campos',
                                            'value' => '1',
                                            'compare' => '=',
                                        ],
                                    ]),
                                //CAMPO TEXTO - NAME DE LAS OPCIONES DE UN SELECT (Para tipo: select)
                                Field::make('text', 'campo_submultiselect_select_nameseleccion', 'Identificador del campo')
                                    ->set_help_text('Ejm: cModalidad,cSubPrograma')
                                    ->set_width(50)
                                    ->set_conditional_logic([
                                        'relation' => 'AND',
                                        [
                                            'field' => 'mas_campos_subselect',
                                            'value' => ['4'],
                                            'compare' => 'IN',
                                        ],
                                        [
                                            'field' => 'campo_check_activar_campos',
                                            'value' => '1',
                                            'compare' => '=',
                                        ],
                                    ]),

                                //CAMPO SELECCIONABLE TAMAÑO - ELECCION DE TAMAÑO DE CAMPO (1,3)
                                Field::make('select', 'campo_submultiselect_tamano', 'Tamaño')
                                    ->set_width(50)
                                    ->set_conditional_logic([
                                        'relation' => 'AND',
                                        [
                                            'field' => 'mas_campos_subselect',
                                            'value' => ['4'],
                                            'compare' => 'IN',
                                        ],
                                        [
                                            'field' => 'campo_check_activar_campos',
                                            'value' => '1',
                                            'compare' => '=',
                                        ],
                                    ])
                                    ->set_options(array(
                                        '1t' => '50%',
                                        '2t' => '100%',
                                    )),
                                //SELECT MULTIPLE - SUBNIVEL 2
                                Field::make('complex', 'campo_submultiselect_select', 'Campo de selección')
                                    ->set_help_text('Seleccione las opciones')
                                    ->set_width(100)
                                    ->set_layout('tabbed-vertical')
                                    ->set_conditional_logic([
                                        'relation' => 'AND',
                                        [
                                            'field' => 'mas_campos_subselect',
                                            'value' => ['4'],
                                            'compare' => 'IN',
                                        ],
                                        [
                                            'field' => 'campo_check_activar_campos',
                                            'value' => '1',
                                            'compare' => '=',
                                        ],
                                    ])
                                    ->add_fields(array(   


                                        //CAMPO TEXTO - NOMBRE DE la PRIMERA OPCION DEL CAMPO SELECCION (primera opción) (Para tipo: select)
                                        Field::make('text', 'campo_subsubmultiselect_select_nombre', 'Nombre del seleccionable')
                                            ->set_help_text('El valor que se agregue aquí, viajará con el nombre del "Identificador del campo"')
                                            ->set_width(27),
                                        //CAMPO TEXTO - NAME (Para tipo: text, select, radio, hidden, select carreras)
                                        Field::make('text', 'campo_subsubmultiselect_select_name', 'Texto o código a guardar')
                                            ->set_help_text('El valor que se agregue aquí, viajará con el nombre del "Identificador de las opciones"')
                                            ->set_width(27),
                                        //CAMPO TEXTO PLACEHOLDER DE PROGRAMA SELECCIONADO
                                        Field::make('text', 'campo_subsubmultiselect_select_place', 'Primera opción del select')
                                            ->set_help_text('Aparecerá como primera opción del select, pero será NO SELECCIONABLE, es un título')
                                            ->set_width(100),
                                        //CAMPO ASOCIACIÓN - CARRERAS
                                        Field::make('association', 'campo_subsubmultiselect_carreras', __('Escoger carreras'))
                                            ->set_types([
                                                [
                                                    'type'      => 'post',
                                                    'post_type' => 'carreras', 
                                                ],
                                            ])
                                            ->set_help_text('Selecciona carreras'),
                                    )),        
                            
                                



                    ))
                    ->set_header_template('Opción <%- $_index + 1 %>'),
                
                //SELECCIONABLE DE CARRERAS
                Field::make('association', 'campo_carreras', __('Escoger carreras'))
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
            ->set_header_template('Campo: <%- campo_placeholder_label%> | Tipo: <% switch(campos){
            case "1" : %> Campo de Texto
            <% break; case "2" : %> Crear Campos Dependientes
            <% break; case "3" : %> Campo de Selección
            <% break; case "4" : %> Campo de Opciones
            <% break; case "5" : %> Campo Oculto
            <% break; case "6" : %> Campo de Selección de Carreras
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
