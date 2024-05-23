<?php

/**
 * Envoie une requête HTTP.
 *
 * @param string $url L'URL de la requête.
 * @param string $method La méthode HTTP (GET, POST, etc.).
 * @param array $data Les données à envoyer avec la requête.
 * @param array $headers Les en-têtes HTTP supplémentaires.
 * @return array La réponse de la requête (status, headers, body).
 */
function sendHttpRequest($url, $method = 'GET', $data = [], $headers = [])
{
    $ch = curl_init();

    switch (strtoupper($method)) {
        case 'POST':
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            break;
        case 'PUT':
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            break;
        case 'DELETE':
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            break;
        default:
            if (!empty($data)) {
                $url .= '?' . http_build_query($data);
            }
            break;
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $responseHeaders = substr($response, 0, $headerSize);
    $responseBody = substr($response, $headerSize);

    curl_close($ch);

    return [
        'status' => $httpCode,
        'headers' => $responseHeaders,
        'body' => $responseBody,
    ];
}

// Exemple d'utilisation
$response = sendHttpRequest('https://api.example.com/data', 'GET', ['param' => 'value']);
if ($response['status'] === 200) {
    echo 'Réponse : ' . $response['body'];
} else {
    echo 'Erreur : ' . $response['status'];
}
