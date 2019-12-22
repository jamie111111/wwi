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

function AddCustomerToDatabase($values = array())
{

    return query("
        INSERT INTO webshop_customers (FirstName,LastNamePreposition,LastName,Email, Password, Gender, DateOfBirth, PhoneNumber, City, Address, HouseNr, PostalCode)
        VALUES ('" . $values['voornaam'] . "','" . $values['tussenvoegsel'] . "', '" . $values['achternaam'] . "', '" . $values['email'] . "', '" . $values['wachtwoord'] . "', '" . $values['gender'] . "', '" . $values['geboortedatum'] . "', '" . $values['telnr'] . "', '" . $values['woonplaats'] . "', '" . $values['adres'] . "', '" . $values['huisnr'] . "', '" . $values['postcode'] . "')
    ");

    $_SESSION['active'] = 0; //Is 0 tot gebruiker zijn account activeert
    $_SESSION['logged_in'] = true; // Gebruiker is ook gelijk ingelogd
    $_SESSION['message'] = "
    U bent succesvol geregistreerd en ingelogd, u kunt verder met winkelen of bestellen door op een van de keuze te klikken";
    header('Location: /success');
}
