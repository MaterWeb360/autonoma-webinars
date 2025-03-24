<?php
$titulo = resaltarTexto(nl2br(elCampo('we-titulo')), 'title-tiny text-color-brown');
$info = nl2br(elCampo('we-informacion'));
$lista = elCampo('we-webinars');

$html_lista = "";
foreach ($lista as $key => $item) {
    $fechaHora = elCampo($item, 'fecha');
    $dateTime = new DateTime($fechaHora);
    $dia = $dateTime->format('d');
    $mes = getMonths($dateTime->format('m'));
    $horaAMPM = $dateTime->format('g:i A');
    $tema_img = TEMA_P_IMG;

    $ubicacion = elCampo($item, 'ubicacion');
    $titulo_e = elCampo($item, 'titulo');
    $descripcion = nl2br(elCampo($item, 'descripcion'));
    $url = elCampo($item, 'url');
    $img = fileCampo($item, 'imagen');

    $html_lista .= <<<HTML
    <div class="webinar_slider-slide w-slide">
        <div class="webinar_item">
            <div class="webinar_header">
                <img src="{$img}" loading="lazy" alt=""
                    class="webinar_cover">
            </div>
            <div class="webinar_main">
                <div class="webinar_fecha-wrp">
                    <div class="webinar_fecha">{$dia} {$mes}</div>
                </div>
                <div class="webinar_details">
                    <div class="webinar_detail-item">
                        <img src="{$tema_img}/icon-place.svg" loading="lazy" alt=""
                            class="webinar_detail-icon">
                        <div>{$ubicacion}</div>
                    </div>
                    <div class="webinar_detail-item">
                        <img src="{$tema_img}/icon-clock-v.svg" loading="lazy" alt=""
                            class="webinar_detail-icon">
                        <div>{$horaAMPM}</div>
                    </div>
                </div>
                <div class="webinar_title">
                    <h4 class="heading-style-h4">{$titulo_e}</h4>
                    <div>{$descripcion}</div>
                </div>
                <div class="webinar_btn">
                    <a href="{$url}" class="button w-inline-block" target="_blank">
                        <div>Ir a evento</div>
                        <img src="{$tema_img}/flecha-izquierda-2.svg" loading="lazy" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    HTML;
}
?>
<div class="webinar">
    <div class="padding-global full-right">
        <div class="webinar_wrapped">
            <div class="webinar_content">
                <div class="webinar_title">
                    <h2 class="heading-style-h2"><?= $titulo ?></span>
                    </h2>
                </div>
                <div class="webinar_prf">
                    <p><?= $info ?></p>
                </div>
            </div>
            <div class="webinar_slider-wrp">
                <div data-delay="4000" data-animation="slide" class="webinar_slider w-slider" data-autoplay="false"
                    data-easing="ease" data-hide-arrows="false" data-disable-swipe="false" data-autoplay-limit="0"
                    data-nav-spacing="3" data-duration="500" data-infinite="true">
                    <div class="webinar_slider-mask w-slider-mask"><?= $html_lista ?></div>
                    <div class="webinar_slider-arrow w-slider-arrow-left">
                        <div class="w-icon-slider-left">
                        </div>
                    </div>
                    <div class="webinar_slider-arrow is-right w-slider-arrow-right">
                        <div class="w-icon-slider-right">
                        </div>
                    </div>
                    <div class="webinar_slider-nav w-slider-nav w-round">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>