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
