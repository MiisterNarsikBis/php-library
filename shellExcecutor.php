<?php

/**
 * Exécute une commande shell.
 *
 * @param string $command La commande à exécuter.
 * @param array &$output La sortie de la commande.
 * @param int &$returnVar Le code de retour de la commande.
 * @return bool true en cas de succès, false sinon.
 */
function executeShellCommand($command, &$output, &$returnVar)
{
    $escapedCommand = escapeshellcmd($command);
    exec($escapedCommand, $output, $returnVar);
    return $returnVar === 0;
}

// Exemple d'utilisation
$output = [];
$returnVar = 0;
if (executeShellCommand('ls -al', $output, $returnVar)) {
    echo 'Commande exécutée avec succès : ' . implode("\n", $output);
} else {
    echo 'Échec de l\'exécution de la commande';
}
