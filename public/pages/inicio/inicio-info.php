<?php
$titulo = nl2br(elCampo('in-titulo'));
$informacion = nl2br(elCampo('in-informacion'));

$duracion = elCampo('in-duracion');
$fecha = elCampo('in-fecha');
$ubicacion = nl2br(elCampo('in-ubicacion'));
$lineas = explode("<br />", $ubicacion);
$primeraLinea = $lineas[0];
$lineasRestantes = array_slice($lineas, 1);
$restantesTexto = implode("<br />", $lineasRestantes);
?>

<div class="beneficios_info-wrp">
    <div class="title-hero max-width-large">
        <h2 class="heading-style-h2 color_secundario"><?= $titulo ?></h2>
    </div>
    <div class="title_prf">
        <p class="color_terciario"><?= $informacion ?></p>
    </div>
    <div class="padding-bottom padding-xsmall">
    </div>
    <div class="beneficios_details-wrp">
        <div class="beneficios_details-item">
            <img src="<?= TEMA_P_IMG ?>/icon-clock.svg" loading="lazy" alt=""
                class="beneficios_details-icon">
            <div class="beneficios_details-info color_secundario">
                <div class="beneficios_details-title">Duración</div>
                <div class="beneficios_details-subtitle color_secundario"><?= $duracion ?></div>
            </div>
        </div>
        <div class="line">
        </div>
        <div class="beneficios_details-item">
            <img src="<?= TEMA_P_IMG ?>/icon-clock.svg" loading="lazy" alt=""
                class="beneficios_details-icon">
            <div class="beneficios_details-info color_secundario">
                <div class="beneficios_details-title">Fecha</div>
                <div class="beneficios_details-subtitle color_secundario"><?= $fecha ?></div>
            </div>
        </div>
        <div class="line">
        </div>
        <div class="beneficios_details-item">
            <img src="<?= TEMA_P_IMG ?>/icon-clock.svg" loading="lazy" alt=""
                class="beneficios_details-icon">
            <div class="beneficios_details-info color_secundario">
                <div class="beneficios_details-title">Lugar</div>
                <div class="beneficios_details-subtitle color_secundario"><?= $primeraLinea ?><br>
                    <span
                        class="text-size-tiny"><?= $restantesTexto ?></span>
                </div>
            </div>
        </div>
    </div>
</div>