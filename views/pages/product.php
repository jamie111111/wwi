<?php
// Haal de productID op uit de url
$productId = $_GET['productId'];

/**
 * Functie om een product op te halen op basis van het product id.
 */
function ophalenProduct($pID) {
    $products = getStockItemById($pID);
    if (count($products) === 1) {
        return $products[0];
    } else {
        return NULL;
    }
}

$product = ophalenProduct($productId);

// Haal de product videos, afbeeldingen, andere bekeken producten en tags op.
$product['Videos'] = getStockItemVideos($productId);
$product['Images'] = getStockItemImages($productId);
$product['Difproducts'] = getStockGroupByProductsID($productId);
// $product['TagsNL'] = getStockItemTags($productId);

// Voeg de hoofdafbeelding ook toe aan het lijstje van kleine afbeeldingen.
array_unshift($product['Images'], array('StockItemImageID' => 'OriginalPhoto', 'ImageUri' => $product['Photo']));

/**
 * Controleren welke afbeelding we als hoofdafbeelding tonen.
 */
$mainImage = $product['Photo'];
if (isSet($_POST['selectedProductImage'])) {
    /**
     * Zoeken van de geselecteerde afbeelding in de opgehaalde afbeeldingen.
     * Wanneer we deze vinden, overschrijven we de $mainImage variabele met de geselecteerde afbeelding.
     */
    foreach($product['Images'] as $key => $value) {
        if ($value['StockItemImageID'] == $_POST['selectedProductImage']) {
            $mainImage = $value['ImageUri']; // Overschrijf de hoofdafbeelding met de geselecteerde afbeelding.
            break;
        }
    }
}

/**
 * Een functie om een select / dropdown te renderen.
 * Deze is bedoeld om de hoeveelheid toe te voegen aan de winkelmand toe te voegen.
 */
function renderProductQuantityDropdown() {
    $html = '<select name="quantity">';
    // MAX_AMOUNT_PER_PRODUCT_IN_CART is ergens gevuld met de waarde 10.
    for($i = 0; $i < MAX_AMOUNT_PER_PRODUCT_IN_CART; $i += 1) {
        $html .= '<option value="' . ($i + 1) . '">' . ($i + 1) . '</option>';
    }
    $html .= '</select';
    return $html;
}

/**
 * Een functie om de overige product afbeeldingen te renderen.
 */
function renderProductImages($p) {
    global $mainImage;
    if (!isSet($p['Images'][0])) { // Geen afbeelding, niks tonen
        return '';
    }
    $html = '<div class="images-container">';
    $html .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">';
    foreach($p['Images'] as $key => $image) {
        $selectedClass = '';
        if ($mainImage == $image['ImageUri']) {
            $selectedClass = 'selected';
        }
        $html .= '<button style="background-image: url(' . $image['ImageUri'] . ')" type="submit" value="' . $image['StockItemImageID'] . '" name="selectedProductImage" class="' . $selectedClass . '"></button>';
    }
    $html .= '</form>';
    $html .= '</div>';
    return $html;
}

/**
 * Een functie om 1 product video te renderen.
 */
function renderProductVideo($p) {
    if (!isSet($p['Videos'][0])) { // Geen video, niks tonen
        return '';
    }
    $videoObj = $p['Videos'][0];
    $html = '
        <div class="video-container">
            <h3>Productvideo</h3>
            <iframe src="' . $videoObj['VideoUri'] . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <div class="video-description-container">
                <h6>Video beschrijving</h6>
                <p>' . $videoObj['VideoDescriptionNL'] . '</p>
            </div>
        </div>
    ';
    return $html;
}

function renderDifferentProducts($p)
{
    if (!isSet($p['Difproducts'][0])) { // Geen andere producten, niks tonen
        return '';
    }
    $html = '<div class="dif-product-container">';
    foreach ($p['Difproducts'] as $key => $difproduct) {
        if (!isSet($difproduct['Photo']) || !$difproduct['Photo']) {
            $difproduct['Photo'] = '/uploads/image-not-found.jpg';
        }
        $html .= '
        
                <a href="/product?productId=' . $difproduct['StockItemID'] . '" class="dif-product-description-container"> 
                    <img src="' . $difproduct['Photo'] . '" alt="">  
                     <div style="padding: 0 20px">
                        <h1>' . $difproduct['StockItemNameNL'] . '</h1>
                        <p> ' . substr($difproduct['StockItemDescriptionNL'] , 0, 100)  . ' <span class="lees-meer"> Lees meer...</span></p> 
                     </div>
                </a>
         ';
    }
    $html .= '</div>';
    return $html;
}

$html = '
    <div class="product content-container">
        <a class="go-back" href="' . (isSet($_SESSION['lastQueryURI']) ? $_SESSION['lastQueryURI'] : '/homepage') . '"><span><i class="fa fa-arrow-left"></i></span>Ga terug</a>
        
        <div class="container">
            <div class="left-column">
                <img src="' . $mainImage . '" alt="">
                ' . renderProductImages($product) /* hier renderen we de product afbeeldingen */ . '
            </div>
            <div class="right-column">
 
                
                <div class="product-description">
                    <span class="price-container">' . formatPrice(addTaxToPrice($product['RecommendedRetailPrice'], $product['TaxRate'])) . ' </span>
                    ' . renderProductAvailability($product['QuantityOnHand']) . '
                    <h1>' . $product['StockItemNameNL'] . '   </h1>
                    <h2>' . $product['MarketingCommentsNL'] . '  </h2>
                    <p>' . $product['StockItemDescriptionNL'] . ' </p>
                    ' . renderPRoductTags($product['TagsNL']) . '
                </div>
                <form method="POST" action="' . $_SERVER['REQUEST_URI'] . '" class="add-to-cart">
                    <div class="select-product-quantity">
                        ' . renderProductQuantityDropdown() /* hier renderen we de dropdown om de hoeveelheid te selecteren */ . '
                    </div>
                        <div class="add-button">
                            ' . renderAddToCartButton($productId) /* hier renderen we de toevoegen aan winkelmand knop */ . '
                        </div>
                </form>
            </div>
        </div>
     </div>
     <br>
     ' . renderProductVideo($product) /* hier renderen we de product videos */ . '
     <hr>
     <h3 style="padding-left: 20px;">Anderen bekeken ook</h3>
     ' . renderDifferentProducts($product) . '
    </div>
' ;

$view = array(
    'title' => 'Wide World Importers - ' . $product['StockItemNameNL'],
    'body' => $html,
    'showFooter' => true,
    'showHeader' => true,
);


