<?php
/**
 * Een functie om BTW aan de prijs toe te voegen en af te ronden naar 2 decimalen.
 * @param $price
 * @param $taxRate
 * @return float
 */
function addTaxToPrice($price, $taxRate) {
    $tax = ($taxRate / 100) * $price;
    return round($price += $tax, 2);
}

/**
 * Functie om de producten totaalprijs te berekenen.
 * @param $products
 * @return float|int
 */
function calculateProductsTotalPrice($products) {
    $totalPrice = 0;
    foreach ($products as $product) {
        $totalPrice += (addTaxToPrice($product['RecommendedRetailPrice'], $product['TaxRate']) * $_SESSION['cart'][$product['StockItemID']]['amount']);
    }
    return $totalPrice;
}

/**
 * Functie om de verzendkosten te berekenen.
 */
function calculateShippingCosts($products) {
    if (calculateProductsTotalPrice($products) >= 100) {
        return 0;
    }
    return 6.95;
}
