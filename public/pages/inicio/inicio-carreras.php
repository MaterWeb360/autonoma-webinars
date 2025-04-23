<?php

$titulo = resaltarTexto(nl2br(elCampo('ca-titulo')), 'title-tiny text-color-brown');
$lista = elCampo('ca-lista');

$html_lista = "";
foreach ($lista as $key => $item) {
    $titulo_e = elCampo($item, 'titulo');
    $url = elCampo($item, 'url');
    $img = fileCampo($item, 'imagen');
    $tm_img = TEMA_P_IMG;

    $html_lista .= <<<HTML
    <div id="w-node-f4426212-0817-c6a4-607a-5c6721db9f0c-adfd2a68" class="carreras_item">
        <div id="w-node-f2393d0b-ef7f-1699-509d-a5cd58b864a8-adfd2a68" class="carreras_bg">
            <img
                src="{$img}" loading="lazy" alt=""
                class="carreras_cover">
            <div class="carreras_bg-overlay">
            </div>
        </div>
        <div class="carreras_info">
            <h4 class="heading-style-h4">{$titulo_e}</h4>
            <a href="{$url}" class="button w-inline-block" target="_blank">
                <div>+ información</div>
            </a>
        </div>
    </div>
    HTML;
}
?>
<div class="carreras">
    <div class="padding-global">
        <div class="container-medium">
            <div class="padding-section-large">
                <div class="carreras_wrapper">
                    <div class="carreras_title">
                        <h2 class="heading-style-h2 text-color-orange"><?= $titulo ?></h2>
                    </div>
                    <div class="carreras_grid"><?= $html_lista ?></div>
                </div>
            </div>
        </div>
    </div>
</div>