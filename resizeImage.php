<?php

/**
 * Redimensionne une image en conservant son ratio d'aspect.
 *
 * @param string $filePath Le chemin de l'image source.
 * @param string $outputPath Le chemin de l'image redimensionnée.
 * @param int $newWidth La largeur souhaitée.
 * @param int $newHeight La hauteur souhaitée.
 * @return bool true en cas de succès, false sinon.
 */
function resizeImage($filePath, $outputPath, $newWidth, $newHeight)
{
    list($width, $height, $type) = getimagesize($filePath);

    switch ($type) {
        case IMAGETYPE_JPEG:
            $srcImage = imagecreatefromjpeg($filePath);
            break;
        case IMAGETYPE_PNG:
            $srcImage = imagecreatefrompng($filePath);
            break;
        case IMAGETYPE_GIF:
            $srcImage = imagecreatefromgif($filePath);
            break;
        default:
            return false;
    }

    $aspectRatio = $width / $height;

    if ($newWidth / $newHeight > $aspectRatio) {
        $newWidth = $newHeight * $aspectRatio;
    } else {
        $newHeight = $newWidth / $aspectRatio;
    }

    $newImage = imagecreatetruecolor($newWidth, $newHeight);

    if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
        imagecolortransparent($newImage, imagecolorallocatealpha($newImage, 0, 0, 0, 127));
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
    }

    imagecopyresampled($newImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($newImage, $outputPath);
            break;
        case IMAGETYPE_PNG:
            imagepng($newImage, $outputPath);
            break;
        case IMAGETYPE_GIF:
            imagegif($newImage, $outputPath);
            break;
    }

    imagedestroy($srcImage);
    imagedestroy($newImage);

    return true;
}

// Exemple d'utilisation
resizeImage('source.jpg', 'resized.jpg', 200, 200);
