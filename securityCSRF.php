<?php

session_start();

/**
 * Génère un jeton CSRF et le stocke dans la session.
 *
 * @return string Le jeton CSRF.
 */
function generateCsrfToken()
{
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    return $token;
}

/**
 * Vérifie la validité du jeton CSRF.
 *
 * @param string $token Le jeton CSRF à vérifier.
 * @return bool true si le jeton est valide, false sinon.
 */
function validateCsrfToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Exemple d'utilisation dans un formulaire
$csrfToken = generateCsrfToken();
echo '<input type="hidden" name="csrf_token" value="' . $csrfToken . '">';
