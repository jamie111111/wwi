<?php
$images = array(
    'https://picsum.photos/id/853/200/300',
    'https://picsum.photos/id/731/200/300',
    'https://picsum.photos/id/379/200/300',
    'https://picsum.photos/id/609/200/300',
    'https://picsum.photos/id/803/200/300',
    'https://picsum.photos/id/32/200/300',
    'https://picsum.photos/id/72/200/300',
    'https://picsum.photos/id/421/200/300',
    'https://picsum.photos/id/85/200/300',
    'https://picsum.photos/id/474/200/300',
    'https://picsum.photos/id/500/200/300',
    'https://picsum.photos/id/69/200/300',
    'https://picsum.photos/id/863/200/300',
    'https://picsum.photos/id/66/200/300',
    'https://picsum.photos/id/536/200/300',
);

/**
 * Deze functie geeft uit een lijstje van afbeeldingen een willekeurige afbeelding terug.
 * Dit is handig om te gebruiken als tijdelijke inhoud voor een te stylen pagina.
 * @return string
 */
function randomImage() {
    global $images;
    return $images[array_rand($images)];
}
