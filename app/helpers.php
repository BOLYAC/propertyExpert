<?php

function avatartImage($path)
{
    return $path && file_exists('img/products/' . $path) ? asset('img/products/' . $path) : asset('img/non-disponible.png');
}
