<?php

function GetLoginData($connection)
{ {
        return array(
            'login-email' => mysqli_real_escape_string($connection, isset($_POST['login-email']) ? $_POST['login-email'] : ''),
            'login-wachtwoord' => mysqli_real_escape_string($connection, isset($_POST['login-wachtwoord']) ? $_POST['login-wachtwoord'] : ''),
        );
    }
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
