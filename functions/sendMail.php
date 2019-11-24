<?php

/**
 * Functie om mails te versturen.
 * @param string $to ontvanger
 * @param string $subject onderwerp
 * @param array[] $headers headers
 * @param string $message bericht
 * @return bool
 */
function sendMail($to, $subject, $headers, $message) {
    $formattedHeaders = '';
    foreach($headers as $headerKey => $headerValue) {
        $formattedHeaders .= $headerKey  . ": " . $headerValue . "\r\n";
    }
    return mail(
        $to,
        $subject,
        $formattedHeaders,
        $message
    );
}

// Voorbeeld:
//$headers = array(
//    "From" => "jesse.spenkelink@gmail.com",
//    "Mime-Version" => "1.0",
//    "Content-Type" => "text/html; charset=UTF-8",
//);
//sendMail('jesse.spenkelink@gmail.com', 'test mail', $headers, '<p>Een test mail.</p>');
