<?php

/**
 * Gère le téléchargement d'un fichier.
 *
 * @param array $file Le fichier téléchargé ($_FILES['file']).
 * @param string $destination Le répertoire de destination.
 * @param array $allowedTypes Les types de fichiers autorisés.
 * @param int $maxSize La taille maximale du fichier en octets.
 * @return string|bool Le chemin du fichier téléchargé ou false en cas d'échec.
 */
function handleFileUpload($file, $destination, $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'], $maxSize = 2097152)
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if (!in_array($file['type'], $allowedTypes)) {
        return false;
    }

    if ($file['size'] > $maxSize) {
        return false;
    }

    $filename = basename($file['name']);
    $targetPath = rtrim($destination, '/') . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $targetPath;
    } else {
        return false;
    }
}

function downloadFile($filePath)
{
    if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit();
    }
}

// Exemple d'utilisation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $uploadResult = handleFileUpload($_FILES['file'], __DIR__ . '/uploads');
    if ($uploadResult) {
        echo 'Fichier téléchargé avec succès : ' . $uploadResult;
    } else {
        echo 'Échec du téléchargement du fichier.';
    }
}

// Exemple d'utilisation
downloadFile('path/to/your/file.txt');
