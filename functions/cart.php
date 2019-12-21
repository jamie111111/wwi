<?php

/**
 * Een functie om een product in de shopping cart sessie te zoeken en terug te geven.
 * @param $productId
 * @return bool
 */
function findProductInCart($productId) {
    if (isCartEmpty()) {
        return false;
    }
    $product = $_SESSION['cart'][$productId];
    if (!empty($product)) {
        return $product;
    }
    return false;
}

/**
 * Een functie om te controleren of de shopping cart leeg is of niet.
 * @return bool
 */
function isCartEmpty() {
    return empty($_SESSION['cart']) || !is_array($_SESSION['cart']);
}

/**
 * Een functie om de toegevoegde product id's op te halen uit de shopping cart sessie.
 * @return array
 */
function getProductIDSFromCart() {
    if (isCartEmpty()) {
        return array();
    }
    return array_keys($_SESSION['cart']);
}

/**
 * Een functie om het totaal aantal toegevoegde producten in de shopping cart te tellen.
 * @return int
 */
function countProductsInCart() {
    if (isCartEmpty()) {
        return 0;
    }
    $count = 0;
    foreach($_SESSION['cart'] as $product) {
        $count += isSet($product['amount']) ? $product['amount'] : 0;
    }
    return $count;
}

function removeProductFromCart($productId) {
    unset($_SESSION['cart'][$productId]);
}

function updateProductAmountInCart($productId, $amount) {
    if ($amount > MAX_AMOUNT_PER_PRODUCT_IN_CART) {
        $amount = MAX_AMOUNT_PER_PRODUCT_IN_CART;
    }
    $_SESSION['cart'][$productId]['amount'] = $amount;
}

function addProductToCart($productId, $quantity) {
    if (isProductInCart($productId)) {
        $newAmount = getProductAmountInCart($productId) + $quantity;
        if ($newAmount > MAX_AMOUNT_PER_PRODUCT_IN_CART) {
            $newAmount = MAX_AMOUNT_PER_PRODUCT_IN_CART;
        }
        updateProductAmountInCart($productId, $newAmount);
    } else {
        $_SESSION['cart'][$productId] = array("amount" => $quantity);
    }
}

/**
 * Functie om te controleren of een product al in de winkelmand aanwezig is.
 */
function isProductInCart($productId) {
    return isSet($_SESSION['cart'])
        && isSet($_SESSION['cart'][$productId])
        && is_array($_SESSION['cart'][$productId])
        && isSet($_SESSION['cart'][$productId]['amount'])
        && $_SESSION['cart'][$productId]['amount'] > 0;
}

function getProductAmountInCart($productId) {
    return isProductInCart($productId) ? $_SESSION['cart'][$productId]['amount'] : 0;
}
