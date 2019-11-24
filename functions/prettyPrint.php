<?php
/**
 * Deze functie is bedoeld om het printen van variabelen naar de browser
 * leesbaarder te maken.
 * @param $expression - Wat je wilt printen
 * @param bool $return
 */
function prettyPrint($expression, $return = false) {
    echo '<pre>' . print_r($expression, $return) . '</pre>';
}
