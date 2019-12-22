<?php
/*
 * Verzameling van alle functies.
 *
 * Dit bestand wordt ingeladen in de index.php waardoor alle functies welke hier worden toegevoegd in de globale scope
 * beschikbaar zullen worden gesteld. Dit houdt in dat ze overal in de webshop aan te roepen zijn.
 * */
include_once('./functions/connection.php');
include_once('./functions/prettyPrint.php');
include_once('./functions/sendMail.php');
include_once('./functions/randomImage.php');
include_once('./functions/querying.php');
include_once('./functions/templating.php');
include_once('./functions/getQueryParamSafely.php');
include_once('./functions/calculations.php');
include_once('./functions/formatting.php');
include_once('./functions/cart.php');
include_once('./functions/registrationhandling.php');
include_once('./functions/loginhandling.php');
include_once('./functions/registration-activationhandling.php');
