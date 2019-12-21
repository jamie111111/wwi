<?php

function getFormData($connection)
{
    return array(
        'gender' => mysqli_escape_string($connection, $_POST['gender']),
        'voornaam' => mysqli_real_escape_string($connection, $_POST['voornaam']),
        'tussenvoegsel' => mysqli_real_escape_string($connection, $_POST['tussenvoegsel']),
        'achternaam' => mysqli_real_escape_string($connection, $_POST['achternaam']),
        'postcode' => mysqli_real_escape_string($connection, $_POST['postcode']),
        'huisnr' => mysqli_real_escape_string($connection, $_POST['huisnr']),
        'adres' => mysqli_real_escape_string($connection, $_POST['adres']),
        'woonplaats' => mysqli_real_escape_string($connection, $_POST['woonplaats']),
        'geboortedatum' => mysqli_real_escape_string($connection, $_POST['geboortedatum']),
        'telnr' => mysqli_real_escape_string($connection, $_POST['telnr']),
        'email' => mysqli_real_escape_string($connection, $_POST['email']),
        'wachtwoord' => mysqli_real_escape_string($connection, $_POST['wachtwoord']),
    );
}

function GetLoginData($connection)
{ {
        return array(
            'login-email' => mysqli_real_escape_string($connection, isset($_POST['login-email']) ? $_POST['login-email'] : ''),
            'login-wachtwoord' => mysqli_real_escape_string($connection, isset($_POST['login-wachtwoord']) ? $_POST['login-wachtwoord'] : ''),
        );
    }
}
/**Een functie om te checken of een ingevoerde email al bestaat in de database
 */
function RunEmailCheck($email)
{
    //Query email uitvoeren
    $result = getEmailsFromDatabase($email);
    //Vaststellen of er records zijn
    $count = sizeof($result);
    //Email in gebruik als er meer dan 0 records worden gevonden
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}
function AddCustomerToDatabase($values = array())
{
    return query("
        INSERT INTO webshop_customers (FirstName,LastNamePreposition,LastName,Email, Password, Gender, DateOfBirth, PhoneNumber, City, Address, HouseNr, PostalCode)
        VALUES ('" . $values['voornaam'] . "','" . $values['tussenvoegsel'] . "', '" . $values['achternaam'] . "', '" . $values['email'] . "', '" . $values['wachtwoord'] . "', '" . $values['gender'] . "', '" . $values['geboortedatum'] . "', '" . $values['telnr'] . "', '" . $values['woonplaats'] . "', '" . $values['adres'] . "', '" . $values['huisnr'] . "', '" . $values['postcode'] . "')
    ");
}
function UserExistCheck($email)
{
    //Query email uitvoeren
    $result = getEmailsFromDatabase($email);
    //Vaststellen of er records zijn
    $count = sizeOf($result);
    if ($count == 0) { //gebruiker bestaat niet
        return false;
    } else {
        return true;
    }
}

/**Functies  om queries uit te voeren voor het registratie formulier. Auteur : Jamie Spekman */
function getEmailsFromDatabase($email)
{
    return query('SELECT * FROM webshop_customers WHERE email = ?', array('s', $email));
}

/**Stuurt een bevestigingsmail met link */

function AccountVerification($email, $voornaam)
{
    $naar = $email;
    $onderwerp = 'Account bevestigen (Wide World Importers)';
    $message_body = '
    Hallo ' . $voornaam . ',
    
    Hartelijk dank voor je inschrijving en welkom bij Wide World Importers!!
    
    Klik op de link om je account te activeren:

    http://localhost/login-system/verify.php?email=' . $email . ';
    ';

    mail($naar, $onderwerp, $message_body);
}
