<?php

/**
 * Convertit une date et une heure d'un fuseau horaire à un autre.
 *
 * @param string $datetime La date et l'heure à convertir.
 * @param string $fromTimezone Le fuseau horaire source.
 * @param string $toTimezone Le fuseau horaire de destination.
 * @param string $format Le format de la date et de l'heure de retour.
 * @return string La date et l'heure converties.
 */
function convertTimezone($datetime, $fromTimezone, $toTimezone, $format = 'Y-m-d H:i:s')
{
    $date = new DateTime($datetime, new DateTimeZone($fromTimezone));
    $date->setTimezone(new DateTimeZone($toTimezone));
    return $date->format($format);
}

// Exemple d'utilisation
$originalTime = '2024-05-23 12:00:00';
$convertedTime = convertTimezone($originalTime, 'America/New_York', 'Europe/Paris');
echo 'Heure convertie : ' . $convertedTime; // Affiche Heure convertie : 2024-05-23 18:00:00
