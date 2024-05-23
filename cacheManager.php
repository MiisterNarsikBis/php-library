<?php

/**
 * Définit une valeur en cache.
 *
 * @param string $key La clé de cache.
 * @param mixed $value La valeur à mettre en cache.
 * @param int $duration La durée de vie du cache en secondes.
 */
function setCache($key, $value, $duration = 3600)
{
    $cacheData = [
        'data' => $value,
        'expires_at' => time() + $duration
    ];
    file_put_contents("cache/{$key}.cache", serialize($cacheData));
}

/**
 * Récupère une valeur en cache.
 *
 * @param string $key La clé de cache.
 * @return mixed La valeur en cache ou false si le cache est expiré ou introuvable.
 */
function getCache($key)
{
    $filePath = "cache/{$key}.cache";
    if (!file_exists($filePath)) {
        return false;
    }

    $cacheData = unserialize(file_get_contents($filePath));
    if (time() > $cacheData['expires_at']) {
        unlink($filePath);
        return false;
    }

    return $cacheData['data'];
}

// Exemple d'utilisation
setCache('example_data', ['name' => 'John', 'age' => 30], 600);

$cachedData = getCache('example_data');
if ($cachedData !== false) {
    print_r($cachedData);
} else {
    echo 'Le cache a expiré ou n\'existe pas.';
}
