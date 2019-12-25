<?php
if (isset($_POST['register-user'])) {
    $userData = getFormData($connection);
    if ($check  = RunEmailCheck($email = $userData['email'])) {
        EmailExistErrorHandling();
    } else {
        AddCustomerToDatabase($userData);
        $user = GetUserDataFromDataBase($userData['email']);
        // AccountVerification($email, $userData['voornaam']);
        RegisterSuccessHandling($user);
    }
}

$body = '
<h1 class="base-heading base-heading--account">Nieuw bij World Wide Importers</h1>
<div class="base-wrapper base-wrapper--account">

    <form class="form-container" action="register" method="POST">

        <p class="box-1">Aanhef *</p>
        <p class="box-2">
            <input type="radio" name="gender" value="Vrouw">
            <label for="mevrouw">Mevrouw</label>
            <input type="radio" name="gender" value="Man">
            <label for="Meneer">Meneer</label>
        </p>
        <p class="box-3">
            <label for="voornaam" class="base-label base-label--account">Voornaam *<label>
                    <input required type="text" class="base-input base-input--account" name="voornaam">
        </p>
        <p class="box-4">
            <label for="tussenvoegsel" class="base-label base-label--account">Tussenvoegsel</label>
            <input name="tussenvoegsel" type="text" class="base-input base-input--account">
        </p>
        <p class="box-5">
            <label for="achternaam" class="base-label base-label--account">Achternaam *</label>
            <input required type="text" name="achternaam" class="base-input base-input--account">
        </p>
        <p class="box-6">
            <label for="postcode" class="base-label base-label--account">Postcode *</label>
            <input type="text" name="postcode" class="base-input base-input--account">
        </p>
        <p class="box-7">
            <label for="huisnrtv" class="base-label base-label--account">Huisnummer en toevoeging *</label>
            <input name="huisnr" type="text" class="base-input base-input--account">
            <span><small>Bijv. "10-c"</small></span>
        </p>
        <p class="box-14">
            <label for="woonplaats" class="base-label base-label--account">Woonplaats *</label>
            <input name="woonplaats" type="text" class="base-input base-input--account">

        </p>
        <p class="box-13">
            <label for="adres" class="base-label base-label--account">Adres *</label>
            <input type="text" name="adres" class="base-input base-input--account">
        </p>
        <p class="box-8">
            <label for="geboortedatum" class="base-label base-label--account">Geboortedatum</label>
            <input name="geboortedatum" type="date" class="base-input base-input--account">
        </p>
        <p class="box-9">
            <label for="telnr" class="base-label base-label--account">Telefoonnr *</label>
            <input type="text" name="telnr" class="base-input base-input--account">
        </p>
        <p class="box-10">
            <label for="email" class="base-label base-label--account">Emailadres *</label>
            <input required type="email" name="email" value="" class="base-input base-input--account">
        </p>
        <p class="box-11">
            <label for="wachtwoord" class="base-label base-label--account">Wachtwoord *</label>
            <input required type="password" name="wachtwoord" class="base-input base-input--account">
        </p>
       
        <button type="submit" class="base-btn-primary base-btn-primary--account box-12" name="register-user" value="Versturen">Verzenden</button>
        <div class="account-infotext">
            <h5>Privacy statement</h5>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At beatae recusandae non quas harum
                provident
                rem odit debitis expedita, inventore maiores temporibus tempore quia consequatur autem architecto
                vitae
                dolorum in aliquam? Dignissimos facere commodi laudantium molestiae cupiditate in dolor harum!</p>
        </div>
        <p class="terms">Bij het registreren van uw account gaat u akkoord met de <a>algemene voorwaarden</a></p>
    </form>
</div>
';

$view = array(
    'title' => 'Wide World Importers - Inloggen',
    'head' => '',
    'body' => $body,
    'showHeader' => true,
    'showFooter' => true,
);
