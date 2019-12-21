<?php

function getFormData($connection)
{
    return array(
        'voornaam' => mysqli_real_escape_string($connection, $_POST['voornaam']),
        'achternaam' => mysqli_real_escape_string($connection, $_POST['achternaam']),
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
        INSERT INTO webshop_customers (FirstName, LastName, Email, Password, Gender, DateOfBirth, PhoneNumber, City, Address, HouseNr, PostalCode)
        VALUES ('" . $values['voornaam'] . "', '" . $values['achternaam'] . "', '" . $values['email'] . "', '" . $values['wachtwoord'] . "', 'Man', '2019-12-19 21:15:05', '123', 'af', 'sdf', '5', 'lkj')
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
