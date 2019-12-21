<?php
$productGroupId = getQueryParamSafely('productGroup', FILTER_SANITIZE_NUMBER_INT);
$query = getQueryParamSafely('query', FILTER_SANITIZE_STRING);
$searchResults = array();
$pageTitle = 'Zoekresultaten';
$hero = '';

/*
 * Haal de producten op uit de database.
 * */
if ($productGroupId) {
    $searchResults = getStockItemsByStockGroupID($productGroupId);

    // Wanneer we producten ophalen aan de hand van een StockGroupID, dan halen we de bijhorende stockgroup op en tonen we deze informatie.
    $productGroup = getStockGroupByStockGroupID($productGroupId);
    if (isSet($productGroup)) {
        if (isSet($productGroup['StockGroupNameNL'])) {
            $pageTitle = $productGroup['StockGroupNameNL'];
        }

        // Voeg een hero / banner afbeelding toe wanneer er een foto aanwezig is voor deze productgroep
        if (isSet($productGroup['Photo'])) {
            $hero = '<div class="hero" style="background-image:  url(\'' . $productGroup['Photo'] . '\')"></div>';
        }
    }
} else if ($query) {
    $searchResults = getStockItemsBySearchQuery($query);
    $pageTitle .= " \"" . $query . "\"";
}

$body = '
    <div class="search content-container">
        ' . $hero . '
        <a class="go-back" href="/homepage"><span><i class="fa fa-arrow-left"></i></span>Ga terug</a>
        <h1>' . $pageTitle . ' <span class="colored">(' . sizeof($searchResults) . ')</span></h1>
        <div class="search-results-container">
            ' . renderSearchResults($searchResults, $query) .  '
        </div>
        ' .  (sizeof($searchResults) ? '<a class="go-to-top" href="#">terug naar boven<span><i class="fa fa-arrow-up"></i></span></a>' : '') . '
    </div>
';
$view = array(
    'title' => 'Wide World Importers - Zoeken',
    'head' => '',
    'body' => $body,
    'showHeader' => true,
    'showFooter' => true,
);

$_SESSION['lastQueryURI'] = $_SERVER['REQUEST_URI'];
