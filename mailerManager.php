<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

/**
 * Envoie un email.
 *
 * @param string $to L'adresse email du destinataire.
 * @param string $subject Le sujet de l'email.
 * @param string $body Le corps de l'email.
 * @param string $from L'adresse email de l'expéditeur.
 * @param string $fromName Le nom de l'expéditeur.
 * @return bool true si l'email a été envoyé avec succès, false sinon.
 */
function sendEmail($to, $subject, $body, $from, $fromName)
{
    $mail = new PHPMailer(true);

    try {
        // Paramètres du serveur
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'user@example.com';
        $mail->Password = 'secret';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataires
        $mail->setFrom($from, $fromName);
        $mail->addAddress($to);

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Exemple d'utilisation
if (sendEmail('recipient@example.com', 'Sujet de l\'email', '<p>Corps de l\'email</p>', 'sender@example.com', 'Nom de l\'expéditeur')) {
    echo 'Email envoyé avec succès.';
} else {
    echo 'Échec de l\'envoi de l\'email.';
}
