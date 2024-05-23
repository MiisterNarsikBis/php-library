<?php

/**
 * Encode des données en JSON.
 *
 * @param mixed $data Les données à encoder.
 * @return string|false La chaîne JSON ou false en cas d'erreur.
 */
function safeJsonEncode($data)
{
    $json = json_encode($data);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return false;
    }
    return $json;
}

/**
 * Décode une chaîne JSON.
 *
 * @param string $json La chaîne JSON à décoder.
 * @param bool $assoc Si true, retourne un tableau associatif, sinon un objet.
 * @return mixed Les données décodées ou false en cas d'erreur.
 */
function safeJsonDecode($json, $assoc = false)
{
    $data = json_decode($json, $assoc);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return false;
    }
    return $data;
}

// Exemple d'utilisation
$array = ['name' => 'John', 'age' => 30];
$json = safeJsonEncode($array);

if ($json !== false) {
    echo 'JSON : ' . $json;
    $decoded = safeJsonDecode($json, true);
    print_r($decoded);
} else {
    echo 'Erreur lors de l\'encodage JSON';
}
