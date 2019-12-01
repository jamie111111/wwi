<?php
/*
 * Haal de product groepen op uit de database.
 * */
$productGroups = getProductGroups();

$body = '
    <div class="homepage content-container">
        <div class="text-container">
            <h2>Productgroepen <span class="colored">(' . sizeof($productGroups) . ')</span></h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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
