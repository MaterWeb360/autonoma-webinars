<?php
$titulo = resaltarTexto(nl2br(elCampo('ex-titulo')), 'title-tiny');
$nombre = elCampo('ex-nombre');
$puesto = elCampo('ex-puesto');
$info = nl2br(elCampo('ex-informacion'));
$img = fileCampo('ex-img');
?>

<div class="expositor_wrapper">
    <div class="expositor_title">
        <h2 class="heading-style-h2 text-color-orange"><?= $titulo ?></h2>
    </div>
    <div class="expositor_grid">
        <div class="expositor_cotent">
            <div class="expositor_info-wrp">
                <img src="<?= TEMA_P_IMG ?>/icon-microfono.svg" loading="lazy" alt=""
                    class="icon-1x1-medium">
                <div class="expositor_info-name">
                    <div class="heading-style-h4"><?= $nombre ?></div>
                    <div class="text-color-orange"><?= $puesto ?></div>
                </div>
            </div>
            <div class="expositor_prf">
                <p><?= $info ?></p>
            </div>
        </div>
        <div class="expositor_img-wrp">
            <img src="<?= $img ?>" loading="lazy" alt=""
                class="expositor_img">
        </div>
    </div>
    <img src="<?= TEMA_P_IMG ?>/asterisc.svg" loading="lazy" alt="" class="expositor_asterisc">
</div>