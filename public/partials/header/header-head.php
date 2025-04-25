<?php
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> data-wf-page="<?= $args['wf-page']; ?>" data-wf-site="<?= $args['wf-site']; ?>">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo('name'); ?></title>

  <script type="text/javascript">
    ! function(o, c) {
      var n = c.documentElement,
        t = " w-mod-";
      n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
    }(window, document);
  </script>

  <?php if ($args['favicon']) { ?>
    <link href="<?= $args['favicon'] ?>" rel="shortcut icon" type="image/x-icon" />
    <link href="<?= $args['favicon'] ?>" rel="apple-touch-icon" />
  <?php } ?>

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-title" content="<?= bloginfo('name') ?>">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
  <script
    type="text/javascript">
    WebFont.load({
      google: {
        families: ["Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic"]
      }
    });
  </script>
  

  <?php
  wp_head();
  $script_header = globalCampo('g_script_header');
  echo $script_header;
  ?>

  <?php
    $colorpri = elCampo('co-color-primary');
    $colorsec = elCampo('co-color-secundary');
    $colorter = elCampo('co-color-terciario');
  ?>
<style>
 .hero_wordpress {
  background: 
    url("<?= get_template_directory_uri(); ?>/public/assets/imgs/bg-right-top.svg"), 
    url("<?= get_template_directory_uri(); ?>/public/assets/imgs/bg-left-bottom.svg"), 
    <?= $colorpri; ?> !important;
  background-position: 100% 0, 0 76%, 0 0 !important;
  background-repeat: no-repeat !important;
  background-size: auto, auto 14rem !important;
}

.error-message{
  font-size: 0.70rem;
  color: red;
}
    .form__input-radio-label{
      margin-bottom:0.5rem;
    }
    .form__input-wrapper{
      display:flex;
      /*flex-direction:column;*/
      justify-content: space-between;
      flex-wrap:wrap;
      gap:0.5rem;
    }
    .selectWP{
      margin-bottom:0;background: transparent;border: none;
    }
    .form__input-radio-wrapper{
      display:flex;
      flex-wrap:wrap;
      gap:0.5rem;
    }
    .form__input-radio-button{
      display:flex;
      justify-content: space-between;
      gap: 0.5rem;
      font-size: 0.875rem;
      line-height: 1.25rem;
    }
    .form__input-radio-button::hover {
      cursor: pointer;
    }
    .error-input{
      border: 1px solid red;
    }
    .sucess-input{
      border: 1px solid green;
    }
    .oculto{
      display:none !important;
    }
    /*Inicio clases para cambiar de color */
    .color_primario{
      color: <?= $colorpri ?> !important;
    }
    .fondo_primario{
      background-color: <?= $colorpri ?> !important;
    }

    .color_secundario{
      color: <?= $colorsec ?> !important;
    }
    .fondo_secundario{
      background-color: <?= $colorsec ?> !important;
    }

    .color_terciario{
      color: <?= $colorter ?> !important;
    }
    .fondo_terciario{
      background-color: <?= $colorter ?> !important;
    }
    /* Fin clases para cambiar de color */
  </style>
 
</head>