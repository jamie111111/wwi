<?php
include_once('./includes/defines.php');
session_start();

/**
 * Inladen van alle belangrijk een benodigde includes.
 * Hier wordt alles ingeladen wat in de global scope benaderbaar moet zijn.
 * Denk hierbij aan de database connecties, helpenede functies en overige includes.
 */
include_once('./includes/main.php');

/**
 * Controleer of de post value quickAddToCart aanwezig is.
 * Wanneer dit het geval is, voeg dan het product toe aan de cart.
 */
if (isSet($_POST['addToCart'])) {
    $quantity = 1;
    if (isSet($_POST['quantity'])) {
        $quantity = $_POST['quantity'];
    }
    addProductToCart($_POST['addToCart'], $quantity);
}

/**
 * Controleer of de post value removeFromCart aanwezig is en het bijhorende product zich in de cart bevindt.
 * Zo ja, verwijder dan het product uit de cart.
 */
if (isSet($_POST['removeFromCart']) && isProductInCart($_POST['removeFromCart'])) {
    removeProductFromCart($_POST['removeFromCart']);
}

/**
 * Open een database connectie als die nog niet bestaat.
 */
if (!isSet($connection)) {
    $connection = OpenDBConnection();
}

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
    include_once('./views/pages' . $viewToInclude . '.php');
} else {
    include_once('./views/pages/404.php');
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="shortcut icon" type="image/png" href="/assets/images/favicon.png"/>
        <link rel="stylesheet" href="/styles/main.css" type="text/css" />
    </head>
    <body>
        <?php
            if ($view['showHeader']) {
                echo "<div style='height: 120px; width: 100%; display: block;'></div>";
            }
        ?>
        <div class="page-content <?php echo ($view['showHeader'] ? 'showingHeader' : ''); ?> <?php echo($view['showFooter'] ? 'showingFooter' : ''); ?>">
            <?php echo $view['body']; ?>
        </div>
        <?php
            if ($view['showHeader']) {
                include_once('./views/elements/header.php');
                echo $header;
            }
        ?>
        <?php
        if ($view['showFooter']) {
            include_once('./views/elements/footer.php');
            echo $footer;
        }
        ?>
    </body>
</html>

<?php
    /**
     * Wanneer een database connectie nog open staat, sluiten we deze.
     */
    if (isSet($connection)) {
        CloseDBConnection($connection);
    }

    $_SESSION['lastVisitedURI'] = $_SERVER['REQUEST_URI'];
?>
