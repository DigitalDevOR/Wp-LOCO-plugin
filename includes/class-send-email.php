<?php

namespace Widget_Loco\Includes;

if (!defined('ABSPATH')) {
    exit;
}

class Send_Email
{
    public static function sendEmail($to, $subject, $headers = [], $attachments = [])
    {
        $message = "Ti ringraziamo per esserti candiato al concorso LOCO!<br><br> verrai contattato su questa email per comunicarti se sarai selezionato.<br><br> Grazie!";
        // Imposta l'header Content-Type per inviare email in formato HTML
        $headers[] = 'Content-Type: text/html; charset=UTF-8';

        // Invia l'email utilizzando la funzione wp_mail di WordPress
        return wp_mail($to, $subject, $message, $headers, $attachments);
    }
}
