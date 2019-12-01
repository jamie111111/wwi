<?php
/**
 * Een functie om een prijs te formatteren naar een human readable weergave.
 * @param $price
 * @return string\
 */
function formatPrice($price) {
    $formatted = str_replace('.', ',', $price);
    if (!strpos($formatted, ',')) {
        $formatted .= ',-';
    }
    return '&euro;' . $formatted;
}