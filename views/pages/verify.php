<?php

//Haal email uit url op
$email = GetEmailFromUrl($connection);
//Zoek gebruikers waarvan het account niet actief is active= '1 of 0'
$result = QueryNotVerifiedUser($email);

ActivationHandling($result);

UpdateUserStatus($email);




// $body = '
// zcxCCx
// ';

// $view = array(
//     'title' => 'Wide World Importers - Accont bevestigen',
//     'head' => '',
//     'body' => $body,
//     'showHeader' => true,
//     'showFooter' => true,
// );
