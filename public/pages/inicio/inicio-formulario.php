<?php
$campos = carbon_get_post_meta(get_the_ID(), 'complex_form_2');
?>

<form id="formularioAutonoma" name="email-form" data-name="Email Form" method="POST"
    class="form_content formWP" data-wf-page-id="67a1021497306af2adfd2a68"
    data-wf-element-id="a1254f40-a5d5-2265-c737-38cb40f3ca3c">

    <div class="form__input-wrapper">

    <?php

        //var_dump($campos);
        foreach ($campos as $campo) {
            switch ($campo['campos']) {
                case '1': //campo texto
                    $plaholder = $campo['campo_placeholder_label'];
                    $tipo = $campo['campo_tipo'];
                    $name = $campo['campo_name_text'];
                    $size = $campo['campo_tamano'];
                    echo '<input name="'.$name.'" placeholder="'. $plaholder.'" type="'.$tipo.'" class="form__input-select-wrapper w-input" style="width: '.$size.'">';
                break;
                case '3': // campo select
                    echo 'Campo select simple';
                    echo '<br>';
                    break;











                case '4': //campo radio
                    $plaholder = $campo['campo_placeholder_label'];
                    $radios = $campo['campo_radio'];
                    $name = $campo['campo_name_option'];
                    $value_selected = $campo['campo_value_seleccionado'];
                    
                        //Nivel 1 - RADIOS
                        echo '<div class="form__input-radio-group" data-nivel="1">';
                            echo '   <div class="form__input-radio-label">'.$plaholder.'</div>';
                            echo '   <div class="form__input-radio-wrapper">';
                                foreach ($radios as $radio) {
                                    $value = $radio['radio_grupo_value'];
                                    $label = $radio['radio_grupo_label'];
                                    echo '<label class="form__input-radio-button">';
                                    echo '  <input type="radio" name="'.$name.'" value="'.$value.'" data-id="'.$value.'">';
                                    echo '  <p id="'.$value_selected.'">'.$label.'</p>';
                                    echo '</label>';
                                }
                            echo '   </div>';
                        echo '</div>';

                        //Nivel 2 - SELECCIONABLE 1
                        echo   '<div class="form__selects-wrapper" data-nivel="2">';
                            foreach ($radios as $radio) {
                                //var_dump($radio);
                                $check1 = $radio['radio_check_activar_campos'];
                                $parent = $radio['radio_grupo_value'];
                                if ($check1) {
                                    $r_tipo_campo = $radio['radio_campos'];
                                    $r_name_campo = $radio['radio_subopcion_nombre'];
                                    $r_name_option = $radio['radio_subopcion_valor'];

                                    switch ($r_tipo_campo) {
                                        case '2': //campo selección
                                        $s_place_one = $radio['radio_select_placeholder'];   //primera opcion del select
                                        $selects_one = $radio['r_one_select'];   //selectt
                                        //var_dump($selects_one);
                                        echo '<div class="form__box" data-parent="'.$parent.'">';
                                            echo '<div class="form__input-select-wrapper" style="width: 100%;" >';
                                                echo '<select name="" data-name="'.$r_name_option.'" class="form__input-select w-select">';  
                                                echo '<option value="" >'.$s_place_one.'</option>';  
                                                    foreach ($selects_one as $select_one) {
                                                        $one_option = $select_one['rcampo_select_placeholder'];
                                                        $one_option_val = $select_one['rcampo_select_value'];
                                                        echo '<option value="'.$one_option_val .'">'.$one_option.'</option>';
                                                    }
                                                echo '</select>';
                                            echo '</div>';
                                            echo '<input type="hidden" value="" name="" data-name="'.$r_name_campo .'">'; //input que llevara el nombre del option seleccionado
                                        echo '</div>';
                                        break;
                                        case '3': //campo oculto
                                            echo '<div class="form__box" data-parent="'.$parent.'">';
                                                echo '<input type="hidden" value="0" data-name="'.$r_name_campo .'" >';
                                                echo '<input type="hidden" value="0" data-name="'.$r_name_option .'">';
                                            echo '</div>';
                                        break;
                                    }
                                

                                }
                            }
                        echo   '</div>';

                        //Nivel 3 - SELECCIONABLE 2
                        echo   '<div class="form__selects-wrapper" data-nivel="3">';
                            foreach ($radios as $radio) {
                                $s_tipo_two = $radio['r_two_select']; //campo oculto
                                $s_tipo_one = $radio['r_one_select']; //campo select
                                $parent = $radio['radio_grupo_value'];
                                //var_dump($radio);
                                //pregrado - oculto
                                if($s_tipo_two){ 
                                    $s_name_option = $radio['r_one_select_name_option'];  //name de opciones
                                    $s_name_campo = $radio['r_one_select_name']; //name de campo (en un input oculto)
                                    $s_place = $radio['r_one_select_place']; //placeholder primera opcion                                    
                                    $s_select_two = $radio['r_two_select']; //Opciones para hacerle bucle
                                    $parent_dos = $radio['r_one_value']; //Opciones para parent
                                    
                                    echo '<div class="form__box" data-parent="'.$parent.'"   data-parent2="'.$parent_dos.'">';
                                        echo '<div class="form__input-select-wrapper" style="width: 100%;">';
                                            echo '<select name="" data-name="'.$s_name_option.'" class="form__input-select w-select">';
                                                echo '<option value="" >'.$s_place.'</option>';
                                                foreach ($s_select_two as $select_two) {
                                                    $two_option = $select_two['r_two_select_placeholder']; //nombre option
                                                    $two_option_val = $select_two['r_two_select_value']; //value option
                                                    echo '<option value="'.$two_option_val .'">'.$two_option.'</option>';
                                                }
                                            echo '</select>';
                                        echo '</div>';
                                        echo '<input type="hidden" name ="" value="" data-name="'.$s_name_campo.'">'; //value para enviar el nombre
                                    echo '</div>';
                                }
                                //posgrado - select - tienen campos distintos en, hay un nivel mas
                                if($s_tipo_one){
                                    $s_select_one = $radio['r_one_select']; //opciones para hacer bucle
                                    foreach ($s_select_one as $select_one) {
                                        //var_dump($select_one);
                                        $parent_dos = $select_one['rcampo_select_value'];
                                        $s_name_campo = $select_one['rcampo_submultiselect_select_nameseleccion']; //name del campo (input oculto enviar nombre)
                                        $s_name_option = $select_one['rcampo_submultiselect_select_name']; //name de las opciones
                                        $s_place = $select_one['rcampo_submultiselect_select_place']; //placeholder
                                        $s_select_one = $select_one['rcampo_submultiselect_select']; //bucle de opciones
                                        echo '<div class="form__box" data-parent="'.$parent.'" data-parent2="'.$parent_dos.'">';
                                            echo '<div class="form__input-select-wrapper" style="width: 100%;">';
                                                echo '<select name="" data-name="'.$s_name_option.'" class="form__input-select w-select">';
                                                echo '<option value="">'.$s_place.'</option>';
                                                foreach ($s_select_one as $select_one) {
                                                    $one_option = $select_one['rcampo_subsubmultiselect_select_nombre'];//nombre
                                                    $one_option_value = $select_one['rcampo_subsubmultiselect_select_name'];//value
                                                    echo '<option value="'.$one_option_value.'">'.$one_option.'</option>';
                                                }
                                                echo '</select>';
                                            echo '</div>';
                                            echo '<input type="hidden" data-name="'.$s_name_campo.'">'; //value para enviar el nombre 
                                        echo '</div>';
                                    }
                                }
                            }
                        echo   '</div>';

                        //NIVEL 4 - SELECCIONABLE 3 (2 opciones)
                        echo   '<div class="form__selects-wrapper" data-nivel="4">';
                            
                        //posgrado -> r_one_select
                        //pregrado -> r_two_select
                        //var_dump($radios);
                        foreach ($radios as $radio) {
                            $rama_posgrado = $radio['r_one_select'];
                            $rama_pregrado = $radio['r_two_select'];
                            $parent = $radio['radio_grupo_value'];
                            if($rama_posgrado){
                                foreach ($rama_posgrado as $modalidades) { //for each a las submodalidades
                                    $modalidad = $modalidades['rcampo_submultiselect_select']; //Tenemos la modalidad
                                    $tipo_campo = $modalidades['rmas_campos_subselect']; //tipo de campo
                                    //var_dump($modalidades);
                                    switch($tipo_campo){ //en posgrado hay que hacer un switch, por que el tipo de campo tiene 2 opciones
                                        case '4': //Campo de Selección multiple (USANDO ACTUALMENTE)
                                            foreach ($modalidad as $carreras) {
                                                $parent_tres = $carreras['rcampo_subsubmultiselect_select_name']; //parent 
                                                $carrera = $carreras['rcampo_subsubmultiselect_carreras']; //bucle de carreras 
                                                $s_place = $carreras['rcampo_subsubmultiselect_select_place']; //placeholder primera opcion
                                                //var_dump($carreras);
                                                echo '<div class="form__box" data-parent="'.$parent.'" data-parent3="'.$parent_tres.'">';
                                                    echo '<div class="form__input-select-wrapper" style="width: 100%;">';
                                                        echo '<select name="" data-name="nCarrera" class="form__input-select w-select">';
                                                        echo '<option>'.$s_place.'</option>';
                                                            foreach ($carrera as $carre) {
                                                                $post_id = $carre['id'];
                                                                $titulo = get_the_title($post_id);
                                                                $slug = get_post_field('post_name', $post_id);
                                                                echo '<option value="'.$slug.'">'.$titulo.'</option>';       
                                                            }
                                                        echo '</select>';
                                                    echo '</div>';
                                                echo '</div>';
                                            }

                                            break;

                                        case '6': //Campo de Selección de Carreras (RELLENAR CONTENIDO Y PROBAR)
                                            foreach ($modalidad as $carreras) {
                                                $parent_tres = $carreras['rcampo_select_value'];//parent
                                                $carrera = $carreras['rcampo_subselect_carreras'];//bucle de carreras
                                                $s_place = $carreras['rcampo_subselect_select_place'];//placeholder   
                                                echo '<div class="form__box" data-parent="'.$parent.'" data-parent3="'.$parent_tres.'">';
                                                    echo '<div class="form__input-select-wrapper" style="width: 100%;">';
                                                        echo '<select name="" data-name="nCarrera" class="form__input-select w-select">';
                                                        echo '<option>'.$s_place.'</option>';
                                                            foreach ($carrera as $carre) {
                                                                $post_id = $carre['id'];
                                                                $titulo = get_the_title($post_id);
                                                                $slug = get_post_field('post_name', $post_id);
                                                                echo '<option value="'.$slug.'">'.$titulo.'</option>';       
                                                            }
                                                        echo '</select>';
                                                    echo '</div>';
                                                echo '</div>';
                                            }
                                            break;
                                    }
                                }
                            }else if($rama_pregrado){
                                foreach ($rama_pregrado as $modalidades) { //for each a las submodalidades
                                    $modalidad = $modalidades['r_two_subselect_carreras']; //Tenemos la modalidad
                                    $tipo_campo = $modalidades['r_two_campos_subselect']; //tipo de campo
                                    switch($tipo_campo){ //en pregrado hay que hacer un switch, por que el tipo de campo tiene 2 opciones
                                        case '4': //Campo de Selección multiple (RELLENAR CONTENIDO Y PROBAR)
                                            break;

                                        case '6': //Campo de Selección de Carreras (USANDO ACTUALMENTE)
                                            echo 'Select actual de pregrado';
                                            echo '<br>';
                                            break;
                                    }
                                }   
                            }
                        }

                            

                        echo   '</div>';
                break;








                case '5': //campo oculto
                    $value = $campo['campo_value'];
                    $name = $campo['campo_name_text'];
                    echo '<input name="'.$name.'" type="hidden" value="'.$value.'">';
                break;
                case '6': //campo carreras
                    $no_option = $campo['campo_placeholder_select'];
                    $size = $campo['campo_tamano'];
                    $carreras = $campo['campo_carreras'];
                    echo '<div class="form__input-select-wrapper" style="width: '.$size.'">';
                    echo '    <select name="nCarrera" data-name="nCarrera" class="form__input-select w-select">';
                    echo '        <option value="" disabled selected>'.$no_option.'</option>';
                    foreach ($carreras as $carrera) {
                        $post_id = $carrera['id'];
                        $titulo = get_the_title($post_id);
                        $slug = get_post_field('post_name', $post_id);
                        echo '<option value="'.$slug.'">'.$titulo.'</option>';
                    }
                    echo '    </select>';
                    echo '</div>';
                    break;
                break;
            } 
        }
    ?>    

    <button type="submit" class="button is-form w-button" style="width: 100%">Enviar</button>
</div>
    <!--<div class="form_body">
        <div class="form_campos">
            <div id="boxCodCamp" class="form__input-select-wrapper hide">
            </div>
            <div class="form_campos-col">
                <input class="form__input-select-wrapper w-input" maxlength="256"
                    name="nombre-padre" data-name="nombre-padre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+"
                    placeholder="Nombre del padre de familia*" type="text" id="nombre-padre" required="">
                <input
                    class="form__input-select-wrapper w-node-a1254f40-a5d5-2265-c737-38cb40f3ca64-adfd2a68 w-input"
                    maxlength="256" name="apellido-padre" data-name="apellido-padre"
                    pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" placeholder="Apellido del padre de familia*" type="text"
                    id="apellido-padre" required="">
                <input class="form__input-select-wrapper w-input"
                    maxlength="256" name="cCelular-5" data-name="C Celular 5" pattern="9[0-9]{8}"
                    placeholder="Celular*" type="tel" id="cCelular-5" required="">
                <input
                    class="form__input-select-wrapper w-input" maxlength="256" name="nombre-hijo"
                    data-name="nombre-hijo" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" placeholder="Nombre del hijo(a)*"
                    type="text" id="nombre-hijo" required="">
                <div class="form__input-select-wrapper">
                    <select id="field" name="field" data-name="Field"
                        class="form__input-select w-select">
                        <option value="">Nombre del colegio del hijo*</option>
                        <option value="First">First choice</option>
                        <option value="Second">Second choice</option>
                        <option value="Third">Third choice</option>
                    </select>
                </div>
                <div class="form__input-select-wrapper">
                    <select id="field-2" name="field-2"
                        data-name="Field 2" class="form__input-select w-select">
                        <option value="">Distrito del colegio del hijo*</option>
                        <option value="First">First choice</option>
                        <option value="Second">Second choice</option>
                        <option value="Third">Third choice</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form_botons">
            <div class="text-size-small">Grado del hijo(a)*</div>
            <label class="radio-button w-radio">
                <div
                    class="w-form-formradioinput w-form-formradioinput--inputType-custom radio-button-icon w-radio-input">
                </div>
                <input type="radio" name="tipo" id="mpresencial" data-name="tipo" required=""
                    style="opacity:0;position:absolute;z-index:-1" value="mpresencial">
                <span
                    class="radio-button-label w-form-label" for="mpresencial">Grado del hijo(a)*</span>
            </label>
            <label class="radio-button w-radio">
                <div
                    class="w-form-formradioinput w-form-formradioinput--inputType-custom radio-button-icon w-radio-input">
                </div>
                <input type="radio" name="tipo" id="msemipresencial" data-name="tipo" required=""
                    style="opacity:0;position:absolute;z-index:-1" value="msemipresencial">
                <span
                    class="radio-button-label w-form-label" for="msemipresencial">Otro</span>
            </label>
        </div>
        <div class="form_checkbox">
            <div class="text-size-tiny">(*) Campos obligatorios</div>
            <label class="w-checkbox">
                <input
                    type="checkbox" id="checkbox-3" name="checkbox-3" data-name="Checkbox 3" required=""
                    class="w-checkbox-input">
                <span class="w-form-label" for="checkbox-3">Declaro expresamente
                    haber leído las <a href="#">Políticas de Privacidad</a>
                </span>
            </label>
        </div>
        <input type="submit" data-wait="Please wait..." class="button is-form w-button"
            value="Enviar">
    </div>-->
</form>