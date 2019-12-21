<?php
/*
 * Haal de product groepen op uit de database.
 * */
$productGroups = getProductGroups();

$body = '
    <div class="homepage content-container">
        <div class="text-container">
            <h1>Productgroepen <span class="colored">(' . sizeof($productGroups) . ')</span></h1>
        </div>
        <div class="product-groups-container">
            ' . renderProductGroups($productGroups) . '
        </div>
    </div>
';
$view = array(
    'title' => 'Wide World Importers - Homepage',
    'head' => '',
    'body' => $body,
    'showHeader' => true,
    'showFooter' => true,
);
