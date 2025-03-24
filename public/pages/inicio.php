<?php
get_header();
?>

<?php if (elCampo('in-show') == true) { ?>
    <style>
        .hero {
            margin-bottom: 28rem;
            padding-bottom: 0;
        }
    </style>
<?php } ?>

<?php
get_template_part('public/pages/inicio/inicio', 'hero', []);
?>

<div class="beneficios">
    <div class="padding-global">
        <div class="container-medium">
            <div class="beneficios_wrapper">
                <?php
                if (elCampo('in-show') == false) {
                    get_template_part('public/pages/inicio/inicio', 'info', []);
                }
                ?>
                <div class="padding-bottom padding-xxlarge">
                </div>
                <?php
                if (elCampo('be-show') == false) {
                    get_template_part('public/pages/inicio/inicio', 'beneficio', []);
                }
                ?>
                <div class="padding-bottom padding-xxlarge">
                </div>
                <?php
                if (elCampo('vi-show') == false) {
                    get_template_part('public/pages/inicio/inicio', 'video', []);
                }
                ?>
            </div>
            <div class="padding-bottom padding-xxlarge">
            </div>
            <?php
            if (elCampo('ex-show') == false) {
                get_template_part('public/pages/inicio/inicio', 'expositor', []);
            }
            ?>
            <div class="padding-bottom padding-xxlarge">
            </div>
        </div>
    </div>
</div>

<?php
if (elCampo('we-show') == false) {
    get_template_part('public/pages/inicio/inicio', 'webinar', []);
}

if (elCampo('ca-show') == false) {
    get_template_part('public/pages/inicio/inicio', 'carreras', []);
}

get_footer();
