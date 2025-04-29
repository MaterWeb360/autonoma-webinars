<?php
get_header();

$page = get_page_by_path('gracias');
//var_dump($page);
?>

<div class="hero" style="padding-bottom: 5rem;background-image: none; background: #fc8805">
    <div class="padding-global">
        <div class="container-large">
            <div id="form-hero" class="hero_wrapper">
                <div class="hero_content-wrp text-color-white">
                    <div class="hero_tag text-color-black">
                        <div class="hero_tag-title" style="font-size: 2rem"><?= $page->post_title ?></div>
                    </div>
                    <div class="hero_quote">
                        <img src="<?= TEMA_P_IMG ?>/quote-img.svg" loading="lazy" alt="" class="quote-img">
                        <h1 class="heading-2"><?= $page->post_content ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>