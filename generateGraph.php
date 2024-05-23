<?php

/**
 * Génère un graphique à barres.
 *
 * @param array $data Les données à afficher.
 * @param string $title Le titre du graphique.
 * @param string $filePath Le chemin du fichier image à générer.
 * @return bool true en cas de succès, false sinon.
 */
function generateBarChart($data, $title, $filePath)
{
    $width = 500;
    $height = 300;
    $padding = 50;
    $barWidth = 40;
    $barSpacing = 20;
    $fontSize = 5;

    $image = imagecreatetruecolor($width, $height);
    $backgroundColor = imagecolorallocate($image, 255, 255, 255);
    $barColor = imagecolorallocate($image, 0, 122, 204);
    $textColor = imagecolorallocate($image, 0, 0, 0);

    imagefill($image, 0, 0, $backgroundColor);

    $maxValue = max($data);
    $scale = ($height - 2 * $padding) / $maxValue;

    $x = $padding;
    foreach ($data as $label => $value) {
        $barHeight = $value * $scale;
        imagefilledrectangle($image, $x, $height - $padding, $x + $barWidth, $height - $padding - $barHeight, $barColor);
        imagestring($image, $fontSize, $x + ($barWidth / 2) - 10, $height - $padding + 5, $label, $textColor);
        $x += $barWidth + $barSpacing;
    }

    imagestring($image, $fontSize + 2, $width / 2 - strlen($title) * 3, 20, $title, $textColor);

    $result = imagepng($image, $filePath);
    imagedestroy($image);

    return $result;
}

// Exemple d'utilisation
$data = ['A' => 10, 'B' => 20, 'C' => 30, 'D' => 40];
$title = 'Exemple de graphique à barres';
$filePath = __DIR__ . '/barchart.png';

if (generateBarChart($data, $title, $filePath)) {
    echo 'Graphique généré avec succès';
}
