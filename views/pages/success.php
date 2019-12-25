<?php

$message = '';
if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
    $message = '<p>' . $_SESSION['message'] . '</p>';
};
// // var_dump($_SESSION['logged_in']);
// var_dump($_SESSION['logged_in']);

$body = '
<div class="form content-container">
<h1>Gelukt</h1>
' . $message . '
</div>
';

$view = array(
    'title' => 'Wide World Importers - success',
    'head' => '',
    'body' => $body,
    'showHeader' => true,
    'showFooter' => true,
);
