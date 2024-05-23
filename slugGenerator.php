<?php

/**
 * Transforme une chaîne de texte en slug.
 *
 * @param string $text Le texte à transformer.
 * @return string Le slug.
 */
function createSlug($text)
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);

    return empty($text) ? 'n-a' : $text;
}

// Exemple d'utilisation
$title = "Hello World! This is an example.";
$slug = createSlug($title);
echo 'Slug : ' . $slug;
