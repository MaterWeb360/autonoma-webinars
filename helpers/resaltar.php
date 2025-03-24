<?php

function resaltarTexto($texto, $clase)
{
    return preg_replace('/\*(.*?)\*/', '<span class="' . $clase . '">$1</span>', $texto);
}
