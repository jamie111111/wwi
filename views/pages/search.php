<?php
$productGroupId = getQueryParamSafely('productGroup', FILTER_SANITIZE_NUMBER_INT);
$query = getQueryParamSafely('query', FILTER_SANITIZE_STRING);
$searchResults = array();

/*
 * Haal de producten op uit de database.
 * */
if ($productGroupId) {
    $searchResults = getStockItemsByStockGroupID($productGroupId);
} else if ($query) {
    $searchResults = getStockItemsBySearchQuery($query);
}

$body = '
    <div class="search content-container">
        <a class="go-back" href="/homepage"><span><i class="fa fa-arrow-left"></i></span>Ga terug naar de homepagina</a>
        <h1>Zoekresultaten <span class="colored">(' . sizeof($searchResults) . ')</span></h1>
        <div class="search-results-container">
            ' . renderSearchResults($searchResults) .  '
        </div>
        <a class="go-to-top" href="#">terug naar boven<span><i class="fa fa-arrow-up"></i></span></a>
    </div>
';
$view = array(
    'title' => 'Wide World Importers - Zoeken',
    'head' => '',
    'body' => $body,
    'showHeader' => true,
    'showFooter' => true,
);
