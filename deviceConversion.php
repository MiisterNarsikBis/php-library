<?php

/**
 * Convertit une devise en une autre.
 *
 * @param float $amount Le montant à convertir.
 * @param string $from La devise source.
 * @param string $to La devise de destination.
 * @return float Le montant converti.
 */
function convertCurrency($amount, $from, $to)
{
    $apiKey = 'your_api_key';
    $url = "https://api.exchangerate-api.com/v4/latest/{$from}";

    $response = file_get_contents($url);
    if ($response === false) {
        return false;
    }

    $data = json_decode($response, true);
    if (!isset($data['rates'][$to])) {
        return false;
    }

    $rate = $data['rates'][$to];
    return $amount * $rate;
}

// Exemple d'utilisation
$amount = 100;
$from = 'USD';
$to = 'EUR';
$convertedAmount = convertCurrency($amount, $from, $to);

if ($convertedAmount !== false) {
    echo 'Montant converti : ' . $convertedAmount;
} else {
    echo 'Erreur de conversion';
}
