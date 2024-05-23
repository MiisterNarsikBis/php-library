<?php

/**
 * Nettoie les entrées utilisateur pour éviter les injections SQL et les attaques XSS.
 *
 * @param mixed $data Les données à nettoyer.
 * @return mixed Les données nettoyées.
 */
function sanitizeInput($data)
{
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitizeInput($value);
        }
    } else {
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        $data = stripslashes($data);
        $data = trim($data);
    }
    return $data;
}

// Exemple d'utilisation
$userInput = "<script>alert('XSS');</script>";
$cleanInput = sanitizeInput($userInput);
echo $cleanInput; // Affiche &lt;script&gt;alert('XSS');&lt;/script&gt;
