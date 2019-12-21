<?php

/**
 * Deze functie maakt een database connectie aan en geeft deze terug.
 * Met deze connectie kunnen queries uitgevoerd worden.
 * @return false|mysqli
 */
function OpenDBConnection() {
    global $config;
    try {
        $connection = mysqli_connect($config['db']['host'], $config['db']['user'], $config['db']['password'], $config['db']['name']);
    } catch (Exception $oopsie) {
        print_r($oopsie);
        die();
    }
    return $connection;
}

/**
 * Deze functie sluit een database connectie. Het is belangrijk om na het gebruik van een database connectie deze weer
 * netjes af te sluiten, zodat PHP en MYSQL sneller hun resources weer vrij kunnen geven aan andere processen.
 * @param $connection
 * @return bool
 */
function CloseDBConnection($connection) {
    return mysqli_close($connection);
}
