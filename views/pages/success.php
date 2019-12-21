<?php

$message = '';
if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
    $message = '<p>' . $_SESSION['message'] . '</p>';
} else {
    header("location: index.php");
}

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
