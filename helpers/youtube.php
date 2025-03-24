<?php
function get_youtube_embed_code($url)
{
    $patterns = array(
        '/[?&]v=([a-zA-Z0-9_-]+)/', // Formato largo "https://www.youtube.com/watch?v=VIDEO_ID"
        '/youtu.be\/([a-zA-Z0-9_-]+)/', // Formato corto "https://youtu.be/VIDEO_ID"
        '/[?&]v=([a-zA-Z0-9_-]+)[&]?ab_channel=([a-zA-Z0-9_-]+)/' // Formato largo con "ab_channel"
    );

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
            $video_id = $matches[1];
            if (!empty($video_id)) {
                $embed_url = 'https://www.youtube.com/embed/' . $video_id;
                $youtube = '<iframe width="560" height="315" src="' . $embed_url . '" frameborder="0" allowfullscreen></iframe>';
                return $youtube;
            }
        }
    }

    return 'URL de YouTube no válida o no se pudo encontrar el ID del video.';
}