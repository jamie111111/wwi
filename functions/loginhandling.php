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
}

// function LoginSessionHandling()
// {
//     ReDirectUserTo('/success');
// }

function ReDirectUserTo($page)
{
    header('Location:' . $page);
}

// function HandleHeaderLoginBtn()
// {
//     if (!$_SESSION['logged_in']) {
//         $loginButtonName = 'Inloggen';
//     } else {
//         $loginButtonName = isset($_SESSION['email-user']) ? $_SESSION['email-user'] : 'Inloggen';
//     }
// }
