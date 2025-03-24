<?php
$titulo = resaltarTexto(nl2br(elCampo('vi-titulo')), 'text-color-orange');
$videorprew = fileCampo('vi-video-pre');

$video = elCampo('vi-video');
$videojson = [
    "url" => $video,
    "originalUrl" => $video,
    "width" => 940,
    "height" => 528,
    "thumbnailUrl" => "https://i.ytimg.com/vi/n4pp6J7hmNg/hqdefault.jpg",
    "html" => get_youtube_embed_code($video),
    "type" => "video"
];
$json_encode = json_encode($videojson, JSON_UNESCAPED_SLASHES);

?>
<a href="#" class="w-inline-block w-lightbox">
    <div class="beneficios_video-wrp">
        <img src="<?= TEMA_P_IMG ?>/img-left.svg" loading="lazy"
            id="w-node-bd1fb96b-b3f9-47aa-98dd-7c82d4864ba6-adfd2a68" alt="">
        <div data-poster-url="videos/1164966_Woman_Job_1280x720-poster-00001.jpg"
            data-video-urls="<?= $videorprew ?>"
            data-autoplay="true" data-loop="true" data-wf-ignore="true"
            id="w-node-_8faa6b1c-338a-1401-77b0-de7bd2eaeb50-adfd2a68"
            class="video-bg-wrp w-background-video w-background-video-atom">
            <video
                id="8faa6b1c-338a-1401-77b0-de7bd2eaeb50-video" autoplay="" loop=""
                style="background-image:url(&quot;videos/1164966_Woman_Job_1280x720-poster-00001.jpg&quot;)"
                muted="" playsinline="" data-wf-ignore="true" data-object-fit="cover">
                <source src="<?= $videorprew ?>" data-wf-ignore="true">
            </video>
            <div class="video-bg_overlay">
            </div>
            <div class="video-bg_play-wrp">
                <img loading="lazy" src="<?= TEMA_P_IMG ?>/text-animation.svg" alt=""
                    class="video-bg_play-text">
                <img loading="lazy" src="<?= TEMA_P_IMG ?>/icon-play-video.svg" alt=""
                    class="video-bg_play-icon">
            </div>
        </div>
        <img src="<?= TEMA_P_IMG ?>/img-right.svg" loading="lazy"
            id="w-node-b405b1ba-83fb-205e-b68c-d331edf72b54-adfd2a68" alt="">
        <img src="<?= TEMA_P_IMG ?>/start.svg"
            loading="lazy" id="w-node-f1bfc680-6333-7723-f2ee-4088dc2f5c23-adfd2a68" alt=""
            class="beneficios_video-start">
    </div>
    <script type="application/json" class="w-json">
        {
            "items": [<?= $json_encode ?>],
            "group": ""
        }
    </script>
</a>
<div class="beneficios_video-text">
    <div class="heading-style-h3 text-weight-xbold"><?= $titulo ?></div>
</div>