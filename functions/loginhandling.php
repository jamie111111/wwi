<?php

function GetLoginData($connection)
{ {
        return array(
            'login-email' => mysqli_real_escape_string($connection, isset($_POST['login-email']) ? $_POST['login-email'] : ''),
            'login-wachtwoord' => mysqli_real_escape_string($connection, isset($_POST['login-wachtwoord']) ? $_POST['login-wachtwoord'] : ''),
        );
    }
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
