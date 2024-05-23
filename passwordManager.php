<?php

/**
 * Hache un mot de passe.
 *
 * @param string $password Le mot de passe à hacher.
 * @return string Le mot de passe haché.
 */
function hashPassword($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * Vérifie un mot de passe contre un hachage.
 *
 * @param string $password Le mot de passe à vérifier.
 * @param string $hash Le hachage du mot de passe.
 * @return bool true si le mot de passe correspond au hachage, false sinon.
 */
function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}

// Exemple d'utilisation
$password = 'mypassword';
$hash = hashPassword($password);

if (verifyPassword('mypassword', $hash)) {
    echo 'Mot de passe valide';
} else {
    echo 'Mot de passe invalide';
}
