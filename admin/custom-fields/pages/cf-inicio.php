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
        Field::make('complex', 'campos_de_formulario', __('Campos de formulario'))
            ->setup_labels(['plural_name' => 'Opciones de campo', 'singular_name' => 'Opción de campo'])
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
                Field::make('text', 'campo_placeholder_label', 'Texto sugerido en el campo')
                    ->set_help_text('Ejm: "Ingresar apellidos", "Ingresar DNI"')
                    ->set_width(27)
                    ->set_required(true)
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => ['1','4','6'],
                            'compare' => 'IN',
                        ],
                    ]),
                //CAMPO TEXTO - NOMBRE DEL CAMPO SELECCION (primera opción) (Para tipo: select)
                Field::make('text', 'campo_placeholder_select', 'Texto que aparecerá en la primera opcción del seleccionable')
                    ->set_help_text('Ejm: "Nuestros horarios, Nacionalidad, Pais"')
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
                Field::make('text', 'campo_name', 'Identificador del campo')
                    ->set_help_text('Ejm: cApellidos, cCelular')
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
                Field::make('text', '1campo_value_seleccionado', 'Identificador de las opciones')
                    ->set_help_text('Ejm: nModalidad,nSubPrograma')
                    ->set_width(50)
                    ->set_conditional_logic([
                        'relation' => 'AND',
                        [
                            'field' => 'campos',
                            'value' => ['3'],
                            'compare' => 'IN',
                        ],
                    ]),

                //CAMPO SELECCIONABLE TAMAÑO - ELECCION DE TAMAÑO DE CAMPO (1,3)
                Field::make('select', 'campo_tamano', 'Tamaño')
                    ->set_width(8)
                    ->set_required(true)
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

                //CAMPO SELECT
                Field::make('complex', 'campo_select', __('Campo de selección'))	
                    ->setup_labels(['plural_name' => 'Selecciones', 'singular_name' => 'Selección'])
                    ->set_help_text('Agregar Items al Seleccionable')
                    ->set_width(100)
                    ->set_layout('tabbed-vertical')
                    ->set_required(true)
                    ->set_conditional_logic(array(
                        'relation' => 'AND',
                        array(
                            'field' => 'campos',
                            'value' => '3',
                            'compare' => '=',
                        ),
                    ))
                    ->add_fields(array(
                        Field::make('text', 'campo_select_placeholder_label', __('Seleccionable'))
                            ->set_conditional_logic(array(
                                'relation' => 'AND',
                                array(
                                    'field' => 'parent.campos',
                                    'value' => '3',
                                    'compare' => '=',
                                ),
                            )),
                        Field::make('text', 'campo_select_value', __('Valor'))
                            ->set_conditional_logic(array(
                                'relation' => 'AND',
                                array(
                                    'field' => 'parent.campos',
                                    'value' => '3',
                                    'compare' => '=',
                                ),
                            )),
                        Field::make('checkbox', 'campo_select_activar_carreras', __('Activar carreras'))
                            ->set_option_value('1') // Asegurar que guarde '1' en lugar de 'true'
                            ->set_help_text('Marca esta opción para mostrar las carreras/programas.'),
                        Field::make('association', 'campo_select_carreras', 'Carreras') 
                            ->set_help_text('Selecciona las carreras/programas que aparecerán en el select')
                            ->set_width(100)
                            ->set_required(false)
                            ->set_types([
                                [
                                    'type'      => 'post',
                                    'post_type' => 'carreras',
                                ],
                            ])
                            ->set_conditional_logic([
                                'relation' => 'AND',
                                [
                                    'field' => 'parent.campos', 
                                    'value' => '3',
                                    'compare' => '=',
                                ],
                                [
                                    'field' => 'campo_select_activar_carreras',
                                    'value' => '1', 
                                    'compare' => '=',
                                ],
                            ]),
                    ))
                    ->set_header_template('Opción <%- $_index + 1 %>'),

                //CAMPO RADIO
                Field::make('complex', '1campo_opciones', __('Campo de opciones'))
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

                        //ABRIR AUTOMATICAMENTE CAMPO TEXTO - NOMBRE DEL CAMPO
                        Field::make('text', 'campo_opciones_nombre', 'Nombre del campo')
                            ->set_help_text('Maestrías, Segunda Especialización, Pregrado Presencial, Pregrado a Distancia')
                            ->set_width(50)
                            ->set_required(true),
                        //ABRIR AUTOMATICAMENTE CAMPO TEXTO - CÓDIGO DEL CAMPO
                        Field::make('text', 'campo_opciones_codigo', 'Código del campo')
                            ->set_help_text('Maestrías, Segunda Especialización, Pregrado Presencial, Pregrado a Distancia')
                            ->set_width(50)
                            ->set_required(true),
                        //ABRIR AUTOMATICAMENTE CAMPO TEXTO - NAME DEL NOMBRE
                        Field::make('text', 'campo_opciones_name_nombre', 'Name del nombre')
                            ->set_help_text('cModalidad, cSubPrograma, cPrograma')
                            ->set_width(50)
                            ->set_required(true),
                        //ABRIR AUTOMATICAMENTE CAMPO TEXTO - NAME DEL CODIGO
                        Field::make('text', 'campo_opciones_name_codigo', 'Name del código')
                            ->set_help_text('nPrograma, nSubPrograma, nModalidad')
                            ->set_width(50)
                            ->set_required(true),

                        Field::make('select', 'cr_select_padre', 'Selecciona el tipo de campo')
                            ->set_help_text('Mensaje del campo que aparecerá como indicación. Ejemplo: "Ingresar apellidos", "Ingresar DNI"')
                            ->set_width(100)
                            ->set_required(true)
                            ->set_options([
                                'cr1' => 'Campo general texto (input text)',
                                'cr2' => 'Campo general selección (select)',
                                'cr3' => 'Campo de opciones (radios)',
                                'cr4' => 'Campo oculto (input text hidden)',
                                'cr5' => 'Seleccionable de carreras/programas',
                            ])
                            ->set_conditional_logic([
                                'relation' => 'AND',
                                [
                                    'field' => 'parent.campos',
                                    'value' => '4',
                                    'compare' => '=',
                                ],
                            ]),
                        Field::make('complex', 'cr_radios', __('Aquí puedes crear las opciones'))
                                ->setup_labels([
                                    'plural_name' => 'Opciones',
                                    'singular_name' => 'Opción'
                                ])
                                ->set_width(100)
                                ->set_layout('tabbed-vertical')
                                ->set_required(true)
                                ->set_conditional_logic([
                                    'relation' => 'AND',
                                    [
                                        'field' => 'cr_select_padre',
                                        'value' => 'cr3',
                                        'compare' => '=',
                                    ],
                                ])
                                ->add_fields([
        
                                    //ABRIR AUTOMATICAMENTE CAMPO TEXTO - NOMBRE DEL CAMPO
                                    Field::make('text', 'cr_radio_nombre', 'Nombre del campo')
                                        ->set_help_text('Maestrías, Segunda Especialización, Pregrado Presencial, Pregrado a Distancia')
                                        ->set_width(50)
                                        ->set_required(true),
                                    //ABRIR AUTOMATICAMENTE CAMPO TEXTO - CÓDIGO DEL CAMPO
                                    Field::make('text', 'cr_radio_codigo', 'Código del campo')
                                        ->set_help_text('Maestrías, Segunda Especialización, Pregrado Presencial, Pregrado a Distancia')
                                        ->set_width(50)
                                        ->set_required(true),
                                    //ABRIR AUTOMATICAMENTE CAMPO TEXTO - NAME DEL NOMBRE
                                    Field::make('text', 'cr_radio_name_nombre', 'Name del nombre')
                                        ->set_help_text('cModalidad, cSubPrograma, cPrograma')
                                        ->set_width(50)
                                        ->set_required(true),
                                    //ABRIR AUTOMATICAMENTE CAMPO TEXTO - NAME DEL CODIGO
                                    Field::make('text', 'cr_radio_name_codigo', 'Name del código')
                                        ->set_help_text('nPrograma, nSubPrograma, nModalidad')
                                        ->set_width(50)
                                        ->set_required(true),
                                    //ABRIR AUTOMATICAMENTE COMPLEX - BUCLE 1
                                    Field::make('complex', 'cr_radio_complex', __('Campos de formulario')) 
                                        ->setup_labels(['plural_name' => 'Campos de formulario', 'singular_name' => 'Campo de formulario'])
                                        ->set_collapsed(true)
                                        ->add_fields(array(
                                            //1DA SELECCIÓN DE CAMPOS - 1ER PASO
                                            Field::make('select', 'campos_radio', __('Elegir campo')) 
                                                ->set_width(100)
                                                ->set_options([
                                                    '1' => 'Campo general texto (input text)',
                                                    '3' => 'Campo general selección (select)',
                                                    '4' => 'Campo de opciones (radios)',
                                                    '5' => 'Campo oculto (input text hidden)',
                                                    '6' => 'Seleccionable de carreras/programas',
                                                ]),
                                            //OPCIÓN SELECCIONABLE DE CARRERAS (6)
                                            Field::make('association', 'r_asso', 'Carreras') 
                                                ->set_help_text('Selecciona las carreras/programas que apareceran en el select')
                                                ->set_width(100)
                                                ->set_required(true)
                                                ->set_types([
                                                    [
                                                        'type'      => 'post',
                                                        'post_type' => 'carreras',
                                                    ],
                                                ])
                                                ->set_conditional_logic([
                                                    'relation' => 'AND',
                                                    [
                                                        'field' => 'campos_radio', 
                                                        'value' => '6',
                                                        'compare' => '=',
                                                    ],
                                                ]),
                                            //OPCIÓN TEXTO - PLACEHOLDER (1, 3, 4)
                                            Field::make('text', 'placeholder_campo_radio', 'Mensaje del campo (placeholder)') 
                                                ->set_help_text('Mensaje del campo que aparecerá como indicación. Ejemplo: "Ingresar apellidos", "Ingresar DNI"')
                                                ->set_width(27)
                                                ->set_required(true)
                                                ->set_conditional_logic([
                                                    'relation' => 'AND',
                                                    [
                                                        'field' => 'campos_radio', 
                                                        'value' => ['1', '3', '4'],
                                                        'compare' => 'IN',
                                                    ],
                                                ]),
                                            //OPCIÓN TEXTO - NAME (1,3,4,5)
                                            Field::make('text', 'nombre_campo_radio', 'Nombre del campo (name)') 
                                                ->set_help_text('Nombre de valor del campo, NO utilizar espacios en blanco. Ejemplo: "Apellidos", "DNI", "primer_nombre"')
                                                ->set_width(27)
                                                ->set_required(true)
                                                ->set_conditional_logic([
                                                    'relation' => 'AND',
                                                    [
                                                        'field' => 'campos_radio', 
                                                        'value' => ['1', '3', '4', '5'],
                                                        'compare' => 'IN',
                                                    ],
                                                ]),
                                            //OPCION TEXTO - VALUE (5)
                                            Field::make('text', 'valor_campo_radio', 'Valor del campo predeterminado (value)') 
                                                ->set_help_text('Asignar un valor predeterminado para el campo')
                                                ->set_width(30)
                                                ->set_conditional_logic([
                                                    'relation' => 'AND',
                                                    [
                                                        'field' => 'campos_radio', 
                                                        'value' => '5',
                                                        'compare' => '=',
                                                    ],
                                                ]),
                                            //OPCION TEXTO - TIPO DE CAMPO (1)
                                            Field::make('select', 'tipo_texto_campo_radio', 'Tipo de campo de texto') 
                                                ->set_width(26)
                                                ->set_required(true)
                                                ->set_conditional_logic([
                                                    'relation' => 'AND',
                                                    [
                                                        'field' => 'campos_radio', 
                                                        'value' => '1',
                                                        'compare' => '=',
                                                    ],
                                                ])
                                                ->set_options([
                                                    '1a' => 'Texto',
                                                    '2b' => 'E-mail',
                                                    '3c' => 'Numerico'
                                                ]),
                                            //SUBOPCION TEXTO - LIMITE DE DIGITOS (3)
                                            Field::make('text', 'limite_campo_radio', 'Límite de dígitos') 
                                                ->set_help_text('Cantidad de dígitos permitidos')
                                                ->set_width(10)
                                                ->set_required(true)
                                                ->set_conditional_logic([
                                                    'relation' => 'AND',
                                                    [
                                                        'field' => 'tipo_texto_campo_radio', 
                                                        'value' => '3c',
                                                        'compare' => '=',
                                                    ],
                                                ]),
                                            //OPCION RADIO - TAMANO DE CAMPO (1, 3)
                                            Field::make('select', 'tamano_campo_radio', 'Tamaño de campo') 
                                                ->set_width(10)
                                                ->set_required(true)
                                                ->set_conditional_logic([
                                                    'relation' => 'AND',
                                                    [
                                                        'field' => 'campos_radio', 
                                                        'value' => ['1','3'],
                                                        'compare' => 'IN',
                                                    ],
                                                ])
                                                ->set_options([
                                                    '1t' => '50%',
                                                    '2t' => '100%',
                                                ]),
                                                
                                                Field::make('complex', 'selecciones_campo_radio', __('Opciones de selección')) 
                                                ->setup_labels(['plural_name' => 'Opciones', 'singular_name' => 'Opción'])
                                                ->set_help_text('Ingresar la opción para mostrar en la lista de selección')
                                                ->set_width(100)
                                                ->set_layout('tabbed-vertical')
                                                ->set_required(true)
                                                ->set_conditional_logic([
                                                    'relation' => 'AND',
                                                    [
                                                        'field' => 'campos_radio', 
                                                        'value' => '3',
                                                        'compare' => '=',
                                                    ],
                                                ])
                                                ->add_fields([
                                                    Field::make('text', 'nombre_seleccion_radio', __('Opción')) 
                                                        ->set_conditional_logic([
                                                            'relation' => 'AND',
                                                            [
                                                                'field' => 'parent.campos_radio', 
                                                                'value' => '3',
                                                                'compare' => '=',
                                                            ],
                                                        ]),
                                                    Field::make('text', 'valor_seleccion_radio', __('Valor')) 
                                                        ->set_conditional_logic([
                                                            'relation' => 'AND',
                                                            [
                                                                'field' => 'parent.campos_radio', 
                                                                'value' => '3',
                                                                'compare' => '=',
                                                            ],
                                                        ]),
                                                    Field::make('checkbox', 'activar_carreras', __('Activar carreras'))
                                                        ->set_option_value('1') // Asegurar que guarde '1' en lugar de 'true'
                                                        ->set_help_text('Marca esta opción para mostrar las carreras/programas.'),
                                                    Field::make('association', 'r_asso_second', 'Carreras') 
                                                        ->set_help_text('Selecciona las carreras/programas que aparecerán en el select')
                                                        ->set_width(100)
                                                        ->set_required(false)
                                                        ->set_types([
                                                            [
                                                                'type'      => 'post',
                                                                'post_type' => 'carreras',
                                                            ],
                                                        ])
                                                        ->set_conditional_logic([
                                                            'relation' => 'AND',
                                                            [
                                                                'field' => 'parent.campos_radio', 
                                                                'value' => '3',
                                                                'compare' => '=',
                                                            ],
                                                            [
                                                                'field' => 'activar_carreras', // ← Se quitó 'parent.' porque está en el mismo nivel
                                                                'value' => '1', 
                                                                'compare' => '=',
                                                            ],
                                                        ]),
                                                    ])
                                            
                                                ->set_header_template('Opción <%- $_index + 1 %>'),
            
                                            Field::make('complex', 'opciones_campo_radio', __('Opciones para selección única')) 
                                                ->setup_labels(['plural_name' => 'Opciones', 'singular_name' => 'Opción'])
                                                ->set_help_text('Ingresar la opción para mostrar')
                                                ->set_width(100)
                                                ->set_layout('tabbed-vertical')
                                                ->set_required(true)
                                                ->set_conditional_logic([
                                                    'relation' => 'AND',
                                                    [
                                                        'field' => 'campos_radio', 
                                                        'value' => '4',
                                                        'compare' => '=',
                                                    ],
                                                ])
                                                ->add_fields([
                                                    Field::make('text', 'opcion_seleccion_radio', __('Opción')), 
                                                ])
                                                ->set_header_template('Opción <%- $_index + 1 %>'),
                                                ))
                                                ->set_header_template('Campo: <%- placeholder_campo_radio %> | Tipo: <% switch(campos_radio){
                                                    case "1" : %> Campo Texto
                                                    <% break; case "3" : %> Campo Selección
                                                    <% break; case "4" : %> Campo Opciones
                                                    <% break; case "5" : %> Campo Oculto
                                                } %>'),                        
                                ])
                                ->set_header_template('Opción <%- $_index + 1 %>'),
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
