<?php 
$dir = globalCampo('g-direccion');
$tel = globalCampo('g-telefono');
$email = globalCampo('g-email');
?>

<div class="footer">
    <div class="footer_content">
        <div class="padding-global">
            <div class="container-medium">
                <div class="padding-section-small">
                    <div class="footer_wrapper">
                        <div class="footer_item">
                            <img src="<?= TEMA_P_IMG ?>/icon-place.svg" loading="lazy" alt=""
                                class="footer_item-icon">
                            <div class="footer_item-info">
                                <div>
                                    <strong>Dirección</strong>
                                </div>
                                <div><?= $dir ?></div>
                            </div>
                        </div>
                        <div class="footer_item">
                            <img src="<?= TEMA_P_IMG ?>/icon-place.svg" loading="lazy" alt=""
                                class="footer_item-icon">
                            <div class="footer_item-info">
                                <div>
                                    <strong>Teléfono:</strong>
                                </div>
                                <div><?= $tel ?></div>
                            </div>
                        </div>
                        <div class="footer_item">
                            <img src="<?= TEMA_P_IMG ?>/icon-place.svg" loading="lazy" alt=""
                                class="footer_item-icon">
                            <div class="footer_item-info">
                                <div>
                                    <strong>Escríbenos:</strong>
                                </div>
                                <div><?= $email ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer_copyright">
    <div class="padding-global">
        <div>Autónoma Todos los derechos reservados</div>
    </div>
</div>
<a href="#form-hero" class="btn fixed w-button">INSCRÍBETE</a>