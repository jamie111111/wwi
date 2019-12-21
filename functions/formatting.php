<?php
/**
 * Een functie om een prijs te formatteren naar een human readable weergave.
 * @param $price
 * @return string\
 */
function formatPrice($price) {
    $price = number_format($price, 2);
    $price = str_replace('.', ',', $price);
    if ($price <= 0) {
        return 'gratis';
    }
    return '&euro;' . $price . '<span>&nbsp;&nbsp;&nbsp;(inc. BTW)</span>';
}