<?php
/**
 * Inladen van alle belangrijk een benodigde includes.
 * Hier wordt alles ingeladen wat in de global scope benaderbaar moet zijn.
 * Denk hierbij aan de database connecties, helpenede functies en overige includes.
 */
include_once('includes/main.php');

/**
 * Inladen van de header en footer. Door deze in te laden zijn de variabelen $header en $footer beschikbaar.
 * Door deze variabelen te printen zullen ze getoond worden.
 */
include_once('views/elements/header.php');
include_once('views/elements/footer.php');

/**
 * Hier wordt gekeken op basis van de request url welk template / pagina moet worden ingeladen.
 * Wanneer er geen template gevonden kan worden, zal de 404 pagina worden ingeladen.
 */
$toRender = 'homepage';
$viewToInclude = '/homepage';
if (strtok ($_SERVER['REQUEST_URI'], '?') !== '/') {
    $viewToInclude = strtok ($_SERVER['REQUEST_URI'], '?');
}
if (file_exists('views/pages' . $viewToInclude . '.php')) {
    include_once('views/pages' . $viewToInclude . '.php');
} else {
    include_once('views/pages/404.php');
}
?>

<!-- Het HTML template welke wordt gebruikt voor elke pagina. -->
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $view['title']; ?></title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php if(isSet($view['head'])) echo $view['head']; ?>

        <link href="https://fonts.googleapis.com/css?family=Montserrat:700|Roboto:300,400,500&display=swap" rel="stylesheet">
        <link rel="shortcut icon" type="image/png" href="/assets/images/favicon.png"/>
        <link rel="stylesheet" href="/styles/main.css" type="text/css" />
    </head>
    <body>
        <?php
            if ($view['showHeader']) {
                echo $header;
                echo '<div class="header-spacing"></div>';
            }
        ?>
        <div class="page-content">
            <?php echo $view['body']; ?>
        </div>
        <?php
        if ($view['showFooter']) {
            echo $footer;
        }
        ?>
    </body>
</html>
