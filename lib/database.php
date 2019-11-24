<?php
// Maak een connectie string aan voor het verbinden met de database.
$dsn = $config['db']['driver'] . ':host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];

// Maak een connectie aan met de database configuratie.
$connection = new PDO($dsn, $config['db']['user'], $config['db']['password']);

// Haal de database versie op.
$version = query('SELECT VERSION()')
    ->fetch();

// Database functies

/**
 * Deze functie is gemaakt om het uitvoeren van queries korter te maken
 * zodat je niet altijd de connectie mee hoeft te geven. Door altijd deze
 * functie te gebruiken, zijn we verzekerd dat altijd dezelfde connectie
 * wordt gebruikt.
 * @param $q - De uit te voeren query
 * @return false|PDOStatement - Het resultaat als een PDOStatement
 */
function query($q) {
    global $connection;
    return $connection->query($q);
}
