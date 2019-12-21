<?php
if (!empty($_POST['action']) && !empty($_POST['StockItemID'])) {
    switch($_POST['action']) {
        case 'delete':
            removeProductFromCart($_POST['StockItemID']);
            break;
        case 'update':
            updateProductAmountInCart($_POST['StockItemID'], $_POST['amount']);
            break;
        default:
            break;
    }
}

//function setupDummyCartSession() {
//    $_SESSION['cart'] = array(
//        "1" => array(
//          "amount" => 3,
//        ),
//        "12" => array(
//            "amount" => 1,
//        ),
//        "61" => array(
//            "amount" => 1,
//        ),
//    );
//};
//setupDummyCartSession();
$productIds = getProductIDSFromCart();

$products = sizeof($productIds) > 0 ? getStockItemsByIds($productIds) : array();

$view = array(
    'title' => 'Wide World Importers - Winkelmand',
    'head' => '',
    'body' => '
        <div class="shopping-cart content-container">
            <a class="go-back" href="' . (isSet($_SESSION['lastVisitedURI']) ? $_SESSION['lastVisitedURI'] : '/homepage') . '"><span><i class="fa fa-arrow-left"></i></span>Ga terug</a><br><br>
            <div class="header-title-container">
                <h1>Winkelmand <span class="colored">(' . countProductsInCart() . ')</span></h1>
                ' . renderOrderCheckoutButton() . '
            </div>
            ' . renderProducsInCart($products) . '
            ' . renderOrderTotal($products) . '
            <br>
            ' . renderOrderCheckoutButton() . '
            <br>
        </div>
    ',
    'showHeader' => true,
    'showFooter' => true,
);
