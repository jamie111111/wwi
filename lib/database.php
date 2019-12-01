<?php
// Maak een connectie string aan voor het verbinden met de database.
$dsn = $config['db']['driver'] . ':host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];

// Maak een connectie aan met de database configuratie.
$connection = new PDO($dsn, $config['db']['user'], $config['db']['password']);
