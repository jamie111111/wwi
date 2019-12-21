<?php
$view = array(
    'title' => 'Wide World Importers - Klantenservice',
    'head' => '',
    'body' => '
        <div class="content-container">
        <div class="vraag">
        <h2>Stel uw vraag</h2>
        </div>
       <form action="/verstuurd.php" method="get">
    <div class="vraag">
        <label for="first_name">Voornaam: &nbsp; </label>
        <input type="text" id="name" first_name="user_name" />
        <label for="last_name">&nbsp; Achternaam: &nbsp; </label>
        <input type="text" id="name" last_name="user_name" />
    </div>
    <div class="vraag">
        <label for="mail">E-mail: &nbsp; </label>
        <input type="email" id="mail" name="user_mail" />
    </div>
    <div class="vraag">
        <label for="msg">Vraag: &nbsp; </label>
        <textarea id="msg" name="user_message" rows="10" cols="50"></textarea>
    </div>
</form>
        </div>
        
    ',
    'showHeader' => true,
    'showFooter' => true,
);
?>