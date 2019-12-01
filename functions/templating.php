<?php
/**
 * Bouw HTML op voor productgroepen.
 * @param $productGroups
 * @return string
 */
function renderProductGroups($productGroups) {
    $renderProductGroups = '';
    foreach($productGroups as $productGroup) {
        if (!isSet($productGroup['Photo']) || !$productGroup['Photo']) {
            $productGroup['Photo'] = 'https://www.comparedth.com/img/default_product.jpg';
        }
        $renderProductGroups .= '<a href="/search?productGroup=' . $productGroup['StockGroupID'] .  '" id="product-group-' . $productGroup['StockGroupID'] . '" class="product-group box-shadow">';
        $renderProductGroups .= '<img src="' . $productGroup['Photo'] . '" alt="productgroep afbeelding" />';
        $renderProductGroups .= '<div class="product-group-bottom"><p>' . $productGroup['StockGroupName'] . '</p><span><i class="fa fa-arrow-right"></i></span></div>';
        $renderProductGroups .= '</a>';
    }
    return $renderProductGroups;
}

/**
 * Bouw HTML op voor zoekresultaten.
 * @param $searchResults
 * @return string
 */
function renderSearchResults($searchResults) {
    $placeholderText = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
    $renderResults = '';
    foreach($searchResults as $result) {
        if (!isSet($result['Photo']) || !$result['Photo']) {
            $result['Photo'] = 'https://www.comparedth.com/img/default_product.jpg';
        }
        if (isSet($result['Tags'])) {
            $result['Tags'] = json_decode($result['Tags']);
        }
        $renderResults .= '<a href="/product?productId=' . $result['StockItemID'] . '" id="product-' . $result['StockItemID'] .  '" class="product box-shadow">';
        $renderResults .= '<div class="product-inner product-inner-left">';
        $renderResults .= '<img src="' . $result['Photo'] .  '" alt="product preview" />';
        $renderResults .= '</div>';
        $renderResults .= '<div class="product-inner product-inner-right">';
        $renderResults .= '<h5>' . $result['StockItemName'] . '</h5>';
        $renderResults .= '<p>' . $placeholderText . '</p>';
        $renderResults .= '<span class="colored">' . $result['MarketingComments'] . '</span>';
        $renderResults .= '<div class="product-inner-right-bottom">';
        $renderResults .= '<div class="tags-container">';
        if (isSet($result['Tags']) && is_array($result['Tags'])) {
            foreach($result['Tags'] as $tag) {
                $renderResults .= '<span class="tag">' . $tag . '</span>';
            }
        }
        $renderResults .= '</div>';
        $renderResults .= '<div>';
        $renderResults .= '<span class="availability">Op voorraad</span>&nbsp;|&nbsp;';
        $renderResults .= '<span class="price">' . formatPrice(addTaxToPrice($result['RecommendedRetailPrice'], $result['TaxRate'])) . '</span>';
        $renderResults .= '</div>';
        $renderResults .= '</div>';
        $renderResults .= '</div>';
        $renderResults .= '</a>';
    }
    return $renderResults;
}
