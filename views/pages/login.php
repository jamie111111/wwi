<?php

// if (isset($_POST['login-submit'])) {
//     $loginData = GetLoginData($connection);

//     if ($check = RunEmailCheck($email = $loginData['login-email'])) {
//         var_dump($check);
//         LoginErrorHandling();
//     } else {
//         LoginSuccesHandlingSession();
//         ReDirectUserTo('/success');
//     }
// }

if (isset($_POST['login-submit'])) {
    $loginData = GetLoginData($connection);
    if ($emailExists = RunEmailCheck($loginData['login-email'])) {
        LoginSuccesHandling();
        ReDirectUserTo('/success');
    } else {
        LoginErrorHandling();
    }
}
//  else {
//     $loginData = '';
//     // // $_SESSION['message'] = 'Om in te loggen moet u uw email en wachtwoord invoeren.';
//     ReDirectUserTo('/error');
// }
// if ($_SESSION['logged_in']) {
//     header('Location: /success');
// }


// if ($check = RunEmailCheck($email = $loginData['login-email'])) {
//     LoginErrorHandling();
// } else {
//     LoginSuccesHandlingSession();
//     ReDirectUserTo('/success');
// }



$body = '
        <div class="base-container base-container--login">
        <h1 class="base-heading"></h1>
        <div class="base-wrapper">
            <div class="login">
                <h4 class="base-heading base-heading--login">Inloggen</h4>
                <form action="/login" method="POST">
                    <p>
                        <label for="email" class="base-label base-label--login">Email</label>
                        <input name=login-email type="email" class="base-input base-input--login">
                    </p>
                    <p><label for="Wachtwoord" class="base-label base-label--login">Wachtwoord</label>
                        <input name=login-wachtwoord type="password" class="base-input base-input--login">
                    </p>
                    <p>
                        <button name="login-submit" class="base-btn-primary base-btn-primary--login" type="submit">Inloggen</button>
                    </p>
                </form>
                <div class="login__no-account">
                    <span>Nog geen account?</span><a href="/register">Meld je nu aan.</a>
                </div>
            </div>
        </div>
        </div>
';
$view = array(
    'title' => 'Wide World Importers - Inloggen',
    'head' => '',
    'body' => $body,
    'showHeader' => true,
    'showFooter' => true,
);
