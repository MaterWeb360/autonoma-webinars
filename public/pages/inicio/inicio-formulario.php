<?php
$complex_form_data = carbon_get_post_meta(get_the_ID(), 'complex_form_2');
?>

<form id="formularioAutonoma" name="email-form" data-name="Email Form" method="POST"
    class="form_content formWP" data-wf-page-id="67a1021497306af2adfd2a68"
    data-wf-element-id="a1254f40-a5d5-2265-c737-38cb40f3ca3c">

    <div class="form__input-wrapper">

    <?php
        var_dump($complex_form_data);
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