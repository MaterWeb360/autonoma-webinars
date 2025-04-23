<?php
$logo = globalCampo('g-logotipo-blanco');
$fondo = fileCampo('he-img');
$fondo_mb = fileCampo('he-img-mobile');

$tag = elCampo('he-etiqueta');
$titulo = resaltarTexto(nl2br(elCampo('he-titulo')), 'color_primario');
$subtitulo = elCampo('he-subtitulo');


?>

<div class="hero">
    <div class="nav">
        <div class="padding-global">
            <div class="container-large">
                <div class="padding-section-xsmall">
                    <img src="<?= $logo ?>" loading="lazy" alt=""
                        class="logo-img">
                </div>
            </div>
        </div>
    </div>
    <div class="padding-global">
        <div class="container-large">
            <div id="form-hero" class="hero_wrapper">
                <img src="<?= $fondo ?>" loading="lazy"
                    alt="" class="hero_bg-img">
                <img src="<?= $fondo_mb ?>" loading="lazy" alt=""
                    class="hero_bg-img is-mobile">
                <div class="hero_content-wrp text-color-white color_terciario">
                    <div class="hero_tag text-color-black">
                        <img src="<?= TEMA_P_IMG ?>/icon-play.svg" loading="lazy" alt=""
                            class="icon-1x1-medium">
                        <div class="hero_tag-title"><?= $tag ?></div>
                    </div>
                    <div class="hero_quote ">
                        <img src="<?= TEMA_P_IMG ?>/quote-img.svg" loading="lazy" alt="" class="quote-img">
                        <h1 class="heading-2"><?= $titulo ?></h1>
                    </div>
                    <div class="hero_details">
                        <img src="<?= TEMA_P_IMG ?>/icon-pencil.png" loading="lazy" alt=""
                            class="icon-1x1-medium">
                        <div><?= $subtitulo ?></div>
                    </div>
                </div>
                <div class="hero_form">
                    <div class="form w-form ">
                        <div class="form_header fondo_secundario">
                            <div>¡INSCRÍBETE AHORA!</div>
                        </div>
                        <?php get_template_part('public/pages/inicio/inicio', 'formulario', []); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>