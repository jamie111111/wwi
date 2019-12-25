<?php

function GetLoginData($connection)
{ {
        return array(
            'login-email' => mysqli_real_escape_string($connection, isset($_POST['login-email']) ? $_POST['login-email'] : ''),
            'login-wachtwoord' => mysqli_real_escape_string($connection, isset($_POST['login-wachtwoord']) ? $_POST['login-wachtwoord'] : ''),
        );
    }
}

function LoginErrorHandling()
{
    $_SESSION['message'] = 'Onjuist/onbekend email of wachtwoord of niks ingevuld test';
    ReDirectUserTo('/error');
}

function LoginSuccesHandling()
{
    $_SESSION['message'] = "U bent ingelogd, klik verder winkelen
    ";
    $_SESSION['logged_in'] = true;
    ReDirectUserTo('/homepage');
}

function SetHeaderLogBtn()
{
    if (isset($_SESSION['logged_in'])) {
        return 'Uitloggen';
    } else if (!isset($_SESSION['logged_in'])) {
        return 'Inloggen';
    }
}

function ReDirectUserTo($page)
{
    header('Location:' . $page);
}

function GetUserDataFromDataBase($email)
{
    return query('SELECT * FROM webshop_customers WHERE email = ?', array('s', $email));
}

function SetUserWelcomeInHeader()
{
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
        $voornaam = $_SESSION['user-data'][0]['FirstName'];
        return 'Welkom ' . $voornaam;
    }
}
