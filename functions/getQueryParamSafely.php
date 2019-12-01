<?php

/**
 * Een functie om user input op te schonen en veilig te maken.
 * @param $queryParam
 * @param $filter - optioneel
 * @return string
 */
function getQueryParamSafely($queryParam, $filter = FILTER_SANITIZE_STRING) {
    return trim(strip_tags(filter_input(INPUT_GET, $queryParam, FILTER_SANITIZE_STRING)));
}
