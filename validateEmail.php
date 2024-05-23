<?php

/**
 * Valide une adresse email.
 *
 * @param string $email L'adresse email à valider.
 * @return bool true si l'adresse email est valide, false sinon.
 */
function validateEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $domain = substr(strrchr($email, "@"), 1);
        return checkdnsrr($domain, "MX");
    }
    return false;
}

// Exemple d'utilisation
$email = 'test@example.com';
if (validateEmail($email)) {
    echo 'Email valide';
} else {
    echo 'Email invalide';
}
