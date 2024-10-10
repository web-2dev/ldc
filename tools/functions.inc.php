<?php 

function randomCssColor() {
    $red = rand(0, 255);
    $green = rand(0, 255);
    $blue = rand(0, 255);
    $bkcoul = "rgb($red, $green, $blue)";
    $red = 255 - $red;
    $coul =
        (299 * $red + 587 * $green + 114 * $blue) / 1000 < 125
            ? '#fff'
            : '#000';
    return [$bkcoul, $coul];
}

function vd() {
    $couleurs = randomCssColor();
    echo "<pre style='background-color:$couleurs[0]; color:$couleurs[1];'>";
    // echo 'POSITION : ' . count(debug_backtrace()) >= 2? debug_backtrace()[1]['function']  : '';
    echo '<br>';

    exit( call_user_func_array('var_dump', func_get_args()) );
}


function displayHTML($viewFilename, $viewParameter) {
    extract($viewParameter);
    include "views/header.html.php";
    include "views/$viewFilename.html.php";
    include "views/footer.html.php";
    return;
}

function imgIcon(string $bsIcon): string {
    return "<img src='assets/icons/$bsIcon.svg' alt='icone $bsIcon'>";
}