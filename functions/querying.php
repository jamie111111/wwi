<?php
/**
 * Deze functie is gemaakt om het querien naar de database te vereenvoudigen.
 * Er wordt een veilige manier van queries uitvoeren gehanteerd door gebruik te maken van PDO prepare en execute.
 * @param $statement
 * @param $inputParams
 * @return $stmt
 */
function query($statement, $inputParams = array()) {
    global $connection;
    $stmt = $connection->prepare($statement);
    $stmt->execute($inputParams);
    return $stmt;
}

/**
 * Deze functie haalt een lijst van alle productgroepen welke producten bevatten op uit de database.
 * @return array
 */
function getProductGroups() {
    return query('
        SELECT SG.StockGroupID, SG.StockGroupName, SG.Photo, SISG.StockGroupID
        FROM stockgroups SG
        INNER JOIN stockitemstockgroups SISG on SG.StockGroupID = SISG.StockGroupID
        GROUP BY SG.StockGroupID
    ')->fetchAll();
}

function getStockItemsByStockGroupID($stockGroupID) {
    return query('
        SELECT SI.StockItemID, SI.StockItemName, SI.Tags, SI.Photo, SI.MarketingComments, SI.RecommendedRetailPrice, SI.TaxRate
        FROM stockitems SI
        INNER JOIN stockitemholdings SIH on SI.StockItemID = SIH.StockItemID
        WHERE SI.StockItemID IN (SELECT SISG.StockItemID from stockitemstockgroups SISG WHERE SISG.StockGroupID = :StockGroupID)
        AND SIH.QuantityOnHand > 0
        GROUP BY SI.StockItemID
    ', array('StockGroupID' => $stockGroupID))->fetchAll();
}

function getStockItemsBySearchQuery($query) {
    return query('
        SELECT SI.StockItemID, SI.StockItemName, SI.Tags, SI.Photo, SI.MarketingComments, SI.RecommendedRetailPrice, SI.TaxRate
        FROM stockitems SI
        INNER JOIN stockitemholdings SIH on SI.StockItemID = SIH.StockItemID
        WHERE SI.SearchDetails LIKE :query
        AND SIH.QuantityOnHand > 0
        OR SI.Tags LIKE :query
        AND SIH.QuantityOnHand > 0
        GROUP BY SI.StockItemID
    ', array('query' => '%' . $query . '%'))->fetchAll();
}
