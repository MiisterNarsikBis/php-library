<?php

/**
 * Charge les variables d'environnement depuis un fichier .env.local et les définit comme constantes PHP.
 *
 * @param string $file Le chemin vers le fichier .env.local.
 * @throws Exception Si le fichier n'existe pas.
 */
function loadEnv($file = __DIR__ . '/.env.local')
{
    if (!file_exists($file)) {
        throw new Exception("Le fichier $file n'existe pas.");
    }

    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignore les lignes qui commencent par # (commentaires)
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);

        // Enlève les guillemets autour de la valeur, s'il y en a
        $value = trim($value, '"');

        if (!defined($name)) {
            define($name, $value);
        }
    }
}

// Exemple d'utilisation
try {
    loadEnv();
    // Test: affiche une variable d'environnement définie
    echo DB_HOST; // Supposant que DB_HOST est une variable dans .env.local
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

// Exemple de .env.local 
/*
DB_HOST=localhost
DB_NAME=my_database
DB_USER=root
DB_PASS=secret 
*/
