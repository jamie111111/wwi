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

function getEmailsFromDatabase($email)
{
    return query('SELECT * FROM webshop_customers WHERE email = ?', array('s', $email));
}

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

function EmailExistErrorHandling()
{
    $_SESSION['message'] = 'Dit email is al in gebruik test works lika a charm really it does double check!!!';
    header('Location: /error');
}

function AddCustomerToDatabase($values = array())
{
    return query("
        INSERT INTO webshop_customers (FirstName,LastNamePreposition,LastName,Email, Password, Gender, DateOfBirth, PhoneNumber, City, Address, HouseNr, PostalCode)
        VALUES ('" . $values['voornaam'] . "','" . $values['tussenvoegsel'] . "', '" . $values['achternaam'] . "', '" . $values['email'] . "', '" . $values['wachtwoord'] . "', '" . $values['gender'] . "', '" . $values['geboortedatum'] . "', '" . $values['telnr'] . "', '" . $values['woonplaats'] . "', '" . $values['adres'] . "', '" . $values['huisnr'] . "', '" . $values['postcode'] . "')
    ");
}

function AccountVerification($email, $voornaam)
{
    $naar = $email;
    $onderwerp = 'Account bevestigen (Wide World Importers)';
    $message_body = '
    Hallo ' . $voornaam . ',
    
    Hartelijk dank voor je inschrijving en welkom bij Wide World Importers!!
    
    Klik op de link om je account te activeren:

    http://localhost/verify?email=' . $email . ';
    ';

    mail($naar, $onderwerp, $message_body);
}

function RegisterSuccessHandling($name)
{
    $_SESSION['active'] = 0; //Is 0 tot gebruiker zijn account activeert
    $_SESSION['logged_in'] = true; // Gebruiker is ook gelijk ingelogd
    $_SESSION['user-name'] = $name;
    $_SESSION['message'] = "
    U bent succesvol geregistreerd en ingelogd, u kunt verder met winkelen of bestellen. Hier mooeten knoppen komen en styling";
    header('Location: /success');
}
