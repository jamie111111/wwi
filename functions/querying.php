<?php
/**
 * Deze functie is gemaakt om het querien naar de database te vereenvoudigen.
 * Er wordt een veilige manier van queries uitvoeren gehanteerd door gebruik te maken van PDO prepare en execute.
 * @param $statement - De SQL query
 * @param $bindParameters - De input waardes welke in de query verwerkt moeten worden
 * @return $stmt
 */
function query($statement, $bindParameters = array()) {
    global $connection;
    $stmt = mysqli_prepare($connection, $statement);
    if (sizeof($bindParameters)) {
        $params = array_merge(array($stmt), $bindParameters);
        mysqli_stmt_bind_param(...$params);
//        call_user_func_array('mysqli_stmt_bind_param', $params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $results = array();
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($results, $row);
        }
    }
    return $results;
}

/**
 * Deze functie haalt een lijst van alle productgroepen welke producten bevatten op uit de database.
 * @return array
 */
function getProductGroups() {
    return query('
        SELECT SG.StockGroupID, SG.StockGroupNameNL, SISG.StockGroupID, SG.Photo
        FROM stockgroups SG
        INNER JOIN stockitemstockgroups SISG on SG.StockGroupID = SISG.StockGroupID
        INNER JOIN stockitems SI on SI.StockItemID = SISG.StockItemID
        WHERE SG.StockGroupNameNL IS NOT NULL
        AND SI.StockItemNameNL IS NOT NULL
        GROUP BY SG.StockGroupID
    ');
}

/**
 * Een functie om producten uit de database op te halen, gefilterd op een specificieke productgroep.
 * @param $stockGroupID
 * @return array
 */
function getStockItemsByStockGroupID($stockGroupID) {
    return query('
        SELECT SI.StockItemID, SI.StockItemNameNL, SI.StockItemDescriptionNL, SI.TagsNL, SI.Photo, SI.MarketingCommentsNL, SI.RecommendedRetailPrice, SI.TaxRate, SIH.QuantityOnHand
        FROM stockitems SI
        INNER JOIN stockitemholdings SIH on SI.StockItemID = SIH.StockItemID
        WHERE SI.StockItemID IN (SELECT SISG.StockItemID from stockitemstockgroups SISG WHERE SISG.StockGroupID = ?)
        AND SIH.QuantityOnHand > 0
        AND SI.StockItemNameNL IS NOT NULL
        GROUP BY SI.StockItemID
    ', array('i', $stockGroupID));
}

/**
 * Een functie om een specifieke productgroep op te halen uit de database.
 * @param $stockGroupID
 * @return array||null
 */
function getStockGroupByStockGroupID($stockGroupID) {
    $result = query('
        SELECT SG.StockGroupID, SG.StockGroupNameNL, SG.Photo
        FROM stockgroups SG
        WHERE SG.StockGroupNameNL IS NOT NULL
        AND StockGroupID = ?
    ', array('i', $stockGroupID));
    return is_array($result) ? $result[0] : null;
}

/**
 * Een functie om producten op te halen uit de database gefilterd op een zoekterm.
 * @param $query
 * @return array
 */
function getStockItemsBySearchQuery($query) {
    return query('
        SELECT SI.StockItemID, SI.StockItemNameNL, SI.StockItemDescriptionNL, SI.TagsNL, SI.Photo, SI.MarketingCommentsNL, SI.RecommendedRetailPrice, SI.TaxRate, SIH.QuantityOnHand
        FROM stockitems SI
        INNER JOIN stockitemholdings SIH on SI.StockItemID = SIH.StockItemID
        WHERE SI.SearchDetails LIKE ?
        AND SIH.QuantityOnHand > 0
        AND SI.StockItemNameNL IS NOT NULL
        OR SI.TagsNL LIKE ?
        AND SIH.QuantityOnHand > 0
        AND SI.StockItemNameNL IS NOT NULL
        GROUP BY SI.StockItemID
    ', array('ss', '%' . $query . '%', '%' . $query . '%'));
}

/**
 * Een functie om producten uit de database op te halen met een filter van een lijst van product id's.
 * @param array $ids
 * @return array
 */
function getStockItemsByIds($ids = array()) {
    $idsString = implode(',', $ids);
    return query('
        SELECT SI.StockItemID, SI.StockItemNameNL, SI.StockItemDescriptionNL, SI.TagsNL, SI.Photo, SI.MarketingCommentsNL, SI.RecommendedRetailPrice, SI.TaxRate, SIH.QuantityOnHand
        FROM stockitems SI
        INNER JOIN stockitemholdings SIH on SI.StockItemID = SIH.StockItemID
        WHERE SI.StockItemID IN (' . $idsString . ')
        AND SIH.QuantityOnHand > 0
    ');
}

/**
 * Een functie om een product uit de database op te halen op basis van het StockItemID
 * @param int $id
 * @return array
 */
function getStockItemById($id) {
    return query('
        SELECT SI.StockItemID, SI.StockItemNameNL, SI.StockItemDescriptionNL, SI.TagsNL, SI.Photo, SI.MarketingCommentsNL, SI.RecommendedRetailPrice, SI.TaxRate, SIH.QuantityOnHand
        FROM stockitems SI
        INNER JOIN stockitemholdings SIH on SI.StockItemID = SIH.StockItemID
        WHERE SI.StockItemID = ?
        AND SIH.QuantityOnHand > 0
    ', array('i', $id));
}

/**
 * 
 */
function getStockItemVideos($productId) {
    return query('
        SELECT *
        FROM stockitems_videos
        WHERE StockItemID = ?
    ', array('i', $productId));
}

function getStockItemImages($productId) {
    return query('
        SELECT *
        FROM stockitems_images
        WHERE StockItemID = ?
    ', array('i', $productId));
}

function getStockGroupByProductsID($productId) {
    return query('
        SELECT *
        FROM stockitems SI
        INNER JOIN stockitemholdings SIH ON SIH.StockItemID = SI.StockItemID
        WHERE SI.StockItemID IN (
            SELECT StockItemID
            FROM stockitemstockgroups
            WHERE StockGroupID IN (
                SELECT StockGroupID FROM stockitemstockgroups WHERE StockItemID = ?
            )
        )
        AND SI.StockItemID <> ?
        AND SIH.QuantityOnHand > 0
        AND SI.StockItemNameNL IS NOT NULL
        GROUP BY SI.StockItemID
        LIMIT 3
    ', array('ii', $productId, $productId));
}
