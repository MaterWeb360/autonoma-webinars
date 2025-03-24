<?php
$titulo = nl2br(elCampo('be-titulo'));
$informacion = nl2br(elCampo('be-informacion'));
$img = fileCampo('be-imagen');
?>
<div class="beneficios_grid">
    <img src="<?= $img ?>" loading="lazy"
        id="w-node-_8ebd8a42-e22b-fee7-c804-302e2e606c71-adfd2a68" alt="" class="beneficios_img">
    <div id="w-node-f111a60f-a427-1f95-0951-342fbe9758a6-adfd2a68" class="flex-y-small">
        <div class="beneficios_title">
            <h2 class="heading-style-h2 text-color-orange"><?= $titulo ?></h2>
        </div>
        <p><?= $informacion ?></p>
    </div>
</div>