#Wide World Importers
Dit project is een school opdracht vanuit Windesheim voor de opleiding HBO-ICT. Het project is een webshop voor het bedrijf Wide World Importers. Het bevat geen back-end en is enkel gericht op de front-end van de webshop.

##Configuratie
Maak het bestand `config.php` aan in de `root` directory van het project en plak hier de config in uit het bestand `config.example.php`. Vervang vervolgens de standaard waardes met de gewenste configuratie. Let er op dat dit bestand niet in git mag komen te staan. Vandaar dat deze is toegevoegd in de `.gitignore`.

##Mappen structuur
##index.php
Dit bestand bevat het HTML stramien wat voor elke weergave wordt gebruikt, zodat dit niet steeds opnieuw uitgetypt hoeft te worden. Hoe pagina's worden aangemaakt met dit stramien wordt verder uitegelegd in het kopje **views**. Dit bestand stelt ook globale functies, een database connectie en includes beschikbaar.
###functions
Deze map bevat bestanden met helpende functies. Deze functie worden ingeladen in `functions/main.php` zodat alle functies gemakkelijk beschikbaar kunnen worden gesteld door `functions/main.php` in includen. Dit wordt al gedaan in het bestand `includes/main.php` welke weer wordt ingeladen in het bestand `index.php`. Dit zorgt ervoor dat deze functies overal ingeladen zullen zijn en gebruikbaar zijn in de globale scope.
De volgende functies zijn beschikbaar gemaakt:
1. `prettyPrint(iets om te printen, return)`: Deze functie is vooral handig om objecten leesbaar te tonen om deze te debuggen.
2. `sendMail(ontvanger, onderwerp, headers, bericht)`: Deze functie is gemaakt om het versturen van mails te vereenvoudigen.
###includes
Deze map bevat alle bestanden welke kunnen worden ingeladen doormiddel van een include.
###lib
Deze map wordt gebruikt om alle zelf ontwikkelde libraries in op te slaan. Ook is hier de mollie library te vinden voor het mogelijk maken van betalingen.
###view
In deze map worden alle templates / pagina's aangemaakt. Door een `php` bestand hierin toe te voegen, wordt automatisch de URL naar dit bestand aangemaakt.
####Stappen om een pagina aan te maken:
1. Maakt een bestand aan in de map `views/pages/`. Geef dit bestand een gewenste naam (de naam van het bestand wordt automatisch gebruikt als url om de pagina in te laden). Dus wanneer je bijvoorbeeld het bestand `views/pages/hmepage.php` aanmaakt, wordt de url `/homepage` benaderbaar en wordt hierop dit template ingeladen.
2. In dit bestand moet een `array` worden aangemaakt om de pagina op te bouwen. Hiervoor kun je spieken bij de al bestaande pagina's. In deze array moeten de volgende waardes worden ingevuld:
    1. `title` => De titel van de pagina.
    2. *(optioneel)* `head` => Eventuele head tags om het HTML template mee aan te vullen.
    3. `body` => De HTML welke moet worden ingeladen op deze pagina.
    4. `showHeader` => Deze waarde moet op `true` of `false` worden gezet om wel of geen header te tonen.
    5. `showFooter` => Deze waarde moet op `true` of `false` worden gezet om wel of geen footer te tonen.
##Overige beschikbare functies
1. `query(sql)`: Deze functie gebruikt de globale database connectie om een query op uit te voeren.