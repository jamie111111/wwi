<?php

/**
 * Functie om mails te versturen.
 * @param string $to ontvanger
 * @param string $subject onderwerp
 * @param string $message bericht
 * @param array[] $headers headers
 * @param string $params parameters
 * @return bool
 */
function sendMail($to, $subject, $message, $headers = array(), $params = '') {
    $formattedHeaders = '';
    foreach($headers as $headerKey => $headerValue) {
        $formattedHeaders .= $headerKey  . ": " . $headerValue . "\r\n";
    }
    return mail(
        $to,
        $subject,
        $message,
        $formattedHeaders,
        $params
    );
}

// Voorbeeld:
//$headers = array(
//    "From" => "jesse.spenkelink@gmail.com",
//    "Mime-Version" => "1.0",
//    "Content-Type" => "text/html; charset=UTF-8",
//);
//var_dump(sendMail('jesse.spenkelink@gmail.com', 'test mail', '<p>Een test mail.</p>', $headers, '-fjesse.spenkelink@gmail.com'));
