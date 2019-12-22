<?php


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
function GetEmailFromUrl($connection)
{
    if (isset($_GET['email']) && !empty($_GET['email'])) {
        $email = mysqli_escape_string($connection, $_GET['email']);
        return $email;
    } else {
        $_SESSION['message'] = "Ongeldige parameters voor de account verificatie";
        header("Location: /error");
    }
}

function QueryNotVerifiedUser($email)
{
    return query('SELECT * FROM webshop_customers WHERE email = ? AND active="0" ', array('s', $email));
}

function ActivationHandling($result)
{
    $count = sizeof($result);
    if ($count == 0) {
        $_SESSION['message'] = "Account is al geactiveerd of de link is ongeldig, partyyy!";
        header("Location:/error");
    } else {
        $_SESSION['message'] = "Je account is geactiveerd!";
        header("location: success");
    }
}

function UpdateUserStatus($email)
{
    query('UPDATE webshop_customers SET active="1" WHERE email="' . $email . '"');
    $_SESSION['active'] = 1;
}
