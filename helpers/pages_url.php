<?php

function url_page($page_select_slug)
{
    $select = get_page_by_path($page_select_slug);
    if (isset($select)) {
        return get_permalink($select->ID);
    } else {
        return home_url();
    }
}
