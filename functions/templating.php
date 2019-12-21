<?php

/**
 * Een functie om de beschikbaarheid van een product te tonen.
 */
function renderProductAvailability($quantityOnHand) {
    if (!isSet($quantityOnHand)) return '';
    if ($quantityOnHand > 0) {
        return '<span class="availability available">op voorraad</span>';
    }
    return '<span class="availability unavailable">niet voorradig</span>';
}

/**
 * Een functie om de product tags van een product te tonen.
 */
function renderProductTags($productTags) {
    $tagsHtml = '';
    if (isSet($productTags)) {
        $productTags = json_decode($productTags);
    }
    if (isSet($productTags) && is_array($productTags)) {
        $tagsHtml .= '<div class="tags-container">';
        foreach($productTags as $tag) {
            $tagsHtml .= '<span class="tag">' . $tag . '</span>';
        }
        $tagsHtml .= '</div>';
    }
    return $tagsHtml;
}

/**
 * Bouw HTML op voor productgroepen.
 * @param $productGroups
 * @return string
 */
function renderProductGroups($productGroups) {
    $renderProductGroups = '';
    foreach($productGroups as $productGroup) {
        if (!isSet($productGroup['Photo']) || !$productGroup['Photo']) {
            $productGroup['Photo'] = '/uploads/image-not-found.jpg';
        }
        $renderProductGroups .= '<a href="/search?productGroup=' . $productGroup['StockGroupID'] .  '" id="product-group-' . $productGroup['StockGroupID'] . '" class="product-group box-shadow">';
        $renderProductGroups .= '<img src="' . $productGroup['Photo'] . '" alt="productgroep afbeelding" />';
        $renderProductGroups .= '<div class="product-group-bottom"><p>' . $productGroup['StockGroupNameNL'] . '</p>&nbsp;&nbsp;<span><i class="fa fa-arrow-right"></i></span></div>';
        $renderProductGroups .= '</a>';
    }
    return $renderProductGroups;
}

function renderAddToCartButton($stockItemID) {
    if (isProductInCart($stockItemID)) { // zit al in de cart
        return '
            <span class="add-to-cart added">
                <div>
                    <button class="added-product-button"><span class="fa fa-check"></span><span>Toegevoegd</span></button>
                    <button type="submit" name="removeFromCart" value="' . $stockItemID . '" class="remove-product-button"><span class="fa fa-trash"></span><span>Verwijder</span></button>
                </div>
            </span>   
        ';
    }
    return '<span class="add-to-cart"><button type="submit" value="' . $stockItemID . '" name="addToCart"><span class="fa fa-cart-plus"></span><span>Toevoegen winkelmand</span></button></span>';
}

/**
 * Bouw HTML op voor zoekresultaten.
 * @param $searchResults
 * @return string
 */
function renderSearchResults($searchResults, $searchTerm) {
    if (!sizeof($searchResults) && isSet($searchTerm)) {
        return "<p>De ingevoerde zoekterm \"" . $searchTerm . "\" heeft geen zoekresultaten opgeleverd. Probeer een andere zoekterm om verder te zoeken.</p>";
    }
    $renderResults = '';
    foreach($searchResults as $result) {
        if (!isSet($result['Photo']) || !$result['Photo']) {
            $result['Photo'] = '/uploads/image-not-found.jpg';
        }
        $renderResults .= '<a href="/product?productId=' . $result['StockItemID'] . '" id="product-' . $result['StockItemID'] .  '" class="product box-shadow">';
        $renderResults .= '<div class="product-inner product-inner-left">';
        $renderResults .= '<img src="' . $result['Photo'] .  '" alt="product preview" />';
        $renderResults .= '</div>';
        $renderResults .= '<div class="product-inner product-inner-right">';
        $renderResults .= '<form method="POST" action="' . $_SERVER['REQUEST_URI'] . '" class="add-to-cart">' . renderAddToCartButton($result['StockItemID']) . '</form>';
        $renderResults .= '<h5>' . $result['StockItemNameNL'] . '</h5>';
        $renderResults .= '<span class="colored marketing-comment">' . $result['MarketingCommentsNL'] . '</span>';
        if (isSet($result['StockItemDescriptionNL']) && strlen($result['StockItemDescriptionNL'])) {
            $renderResults .= '<p style="margin: 20px 0px 40px 0px;">' . substr($result['StockItemDescriptionNL'], 0, 200) . ' <span class="colored">Lees meer...</span>' . '</p>';
        }
        $renderResults .= '<div class="product-inner-right-bottom">';
        $renderResults .= renderProductTags($result['TagsNL']);
        $renderResults .= '<div>';
        $renderResults .= renderProductAvailability($result['QuantityOnHand']) . '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;';
        $renderResults .= '<span class="price">' . formatPrice(addTaxToPrice($result['RecommendedRetailPrice'], $result['TaxRate'])) . '</span>';
        $renderResults .= '</div>';
        $renderResults .= '</div>';
        $renderResults .= '</div>';
        $renderResults .= '</a>';
    }
    return $renderResults;
}

function renderProducsInCart($products) {
    $html = '<div class="products-container">';
    foreach($products as $product) {
        $productPrice = addTaxToPrice($product['RecommendedRetailPrice'], $product['TaxRate']);
        $productTotalPrice = $productPrice * $_SESSION['cart'][$product['StockItemID']]['amount'];
        if (!isSet($product['Photo']) || !$product['Photo']) {
            $product['Photo'] = '/uploads/image-not-found.jpg';
        }
        $html .= '<div class="product-container">';
        $html .= '<div class="product-container-inner-block">';
        $html .= '<img src="' . $product['Photo'] . '" alt="product preview" />';
        $html .= '</div>';
        $html .= '<div class="product-container-inner-block">';
        $html .= '<h6>' . $product['StockItemNameNL'] . '</h6>';
        $html .= '<p>' . $product['MarketingCommentsNL'] . '</p>';
        $html .= '</div>';
        $html .= '<div class="product-container-inner-block actions-container">';
        $html .= '<form method="post" action="/cart">';
        $html .= '<select class="select-product-quantity" name="amount">';
        for($i = 1; $i <= $product['QuantityOnHand'] && $i <= MAX_AMOUNT_PER_PRODUCT_IN_CART; $i += 1) {
            $selected = $_SESSION['cart'][$product['StockItemID']]['amount'] == $i;
            $selectedString = $selected ? " selected=\"selected\"" : "";
            $html .= '<option' . $selectedString . ' value="' . $i . '">' . $i . '</option>';
        }
        $html .= '</select>';
        $html .= '<button class="icon-button" type="submit" name="action" value="update"><span class="fa fa-pencil"></span></button>';
        $html .= '<input type="hidden" value="' . $product['StockItemID'] . '" name="StockItemID" />';
        $html .= '<button class="icon-button" type="submit" name="action" value="delete"><span class="fa fa-trash"></span></button>';
        $html .= '</form>';
        $html .= '</div>';
        $html .= '<div class="product-container-inner-block">';
        $html .= '
            <div class="price-container">
                <div>' . formatPrice($productTotalPrice) . '</div>
                <span class="price-per-item">' . formatPrice($productPrice) . ' per stuk</span>
            </div>
        ';
        $html .= '</div>';
        $html .= '</div>';
    }
    $html .= '</div>';
    return $html;
}

function renderOrderTotal($products) {
    if (countProductsInCart() <= 0) {
        return '<p>Er zijn nog geen producten toegevoegd aan de winkelmand.</p>';
    }
    $productsTotalPrice = calculateProductsTotalPrice($products);
    $shippingCosts = calculateShippingCosts($products);
    return '
        <div class="order-total-container">
            <div class="order-total-container-row">
                <div>Totaal producten (' . countProductsInCart() . ' producten):</div>
                <div>' . formatPrice($productsTotalPrice) . '</div>
            </div>
            <div class="order-total-container-row">
                <div>Verzendkosten:</div>
                <div>' . formatPrice($shippingCosts) . '</div>
            </div>
            <div class="order-total-container-row">
                <div>Te betalen:</div>
                <div>' . formatPrice($productsTotalPrice + $shippingCosts) . '</div>
            </div>
        </div>
    ';
}

function renderOrderCheckoutButton() {
    if (countProductsInCart() <= 0) {
        return '';
    }
    return "
        <form class='order-checkout-button-form' method=\"get\" action=\"/order-checkout\">
            <button class=\"btn btn-primary\" type=\"submit\">naar bestellen</button>
        </form>
    ";
}
