<?php

/**
 * Compresse des fichiers dans une archive zip.
 *
 * @param array $files Les fichiers à compresser.
 * @param string $destination Le fichier zip de destination.
 * @return bool true en cas de succès, false sinon.
 */
function createZipArchive($files, $destination)
{
    $zip = new ZipArchive();
    if ($zip->open($destination, ZipArchive::CREATE) !== true) {
        return false;
    }

    foreach ($files as $file) {
        if (file_exists($file)) {
            $zip->addFile($file, basename($file));
        }
    }

    return $zip->close();
}

/**
 * Décompresse une archive zip.
 *
 * @param string $filePath Le fichier zip à décompresser.
 * @param string $destination Le répertoire de destination.
 * @return bool true en cas de succès, false sinon.
 */
function extractZipArchive($filePath, $destination)
{
    $zip = new ZipArchive();
    if ($zip->open($filePath) !== true) {
        return false;
    }

    $zip->extractTo($destination);
    return $zip->close();
}

// Exemple d'utilisation
$files = ['file1.txt', 'file2.txt'];
$zipFile = __DIR__ . '/archive.zip';

if (createZipArchive($files, $zipFile)) {
    echo 'Fichiers compressés avec succès';
}

if (extractZipArchive($zipFile, __DIR__ . '/extracted')) {
    echo 'Fichiers décompressés avec succès';
}
