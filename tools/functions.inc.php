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


// ╔═══════════════════════════════════════════════════════════════════════╗
// ║                                 DEGUB                                 ║


function vd() {
    $couleurs = randomCssColor();
    echo "<pre style='background-color:$couleurs[0]; color:$couleurs[1];'>";
    // echo 'POSITION : ' . count(debug_backtrace()) >= 2? debug_backtrace()[1]['function']  : '';
    echo '<br>';

    call_user_func_array('var_dump', func_get_args());
    echo "<br></pre>";
}

function vde() {
    exit (call_user_func_array('vd', func_get_args()));
}

function pr() {
    $couleurs = randomCssColor();
    echo "<pre style='background-color:$couleurs[0]; color:$couleurs[1];'>";
    // echo 'POSITION : ' . count(debug_backtrace()) >= 2? debug_backtrace()[1]['function']  : '';
    echo '<br>';

    call_user_func_array('print_r', func_get_args()) ;
    echo "<br></pre>";
}

function pre() {
    exit (call_user_func_array('pr', func_get_args()));
}

// ║                                 DEGUB                                 ║
// ╚═══════════════════════════════════════════════════════════════════════╝


// ╔═══════════════════════════════════════════════════════════════════════╗
// ║                                 HTML                                  ║
// ╚═══════════════════════════════════════════════════════════════════════╝

function displayHTML(string $viewFilename, array $viewParameter = []) {
    extract($viewParameter);
    include "views/header.html.php";
    include "views/$viewFilename.html.php";
    include "views/footer.html.php";
    return;
}

function returnHTML(string $viewFilename, array $viewParameter = []): string {
    extract($viewParameter);
    ob_start();
    include "views/header.html.php";
    include "views/$viewFilename.html.php";
    include "views/footer.html.php";
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}

function imgIcon(string $bsIcon): string {
    return "<img src='assets/icons/$bsIcon.svg' alt='icone $bsIcon'>";
}

// ╔═══════════════════════════════════════════════════════════════════════╗
// ║                               FICHIER                                 ║
// ╚═══════════════════════════════════════════════════════════════════════╝

function getFileContent($filePath): string {
    ob_start();
    include $filePath;
    $text = ob_get_contents();
    ob_end_clean();
    return $text;

}

// ╔═══════════════════════════════════════════════════════════════════════╗
// ║                             STRING - CHAR                             ║
// ╚═══════════════════════════════════════════════════════════════════════╝

function lastChar($str): string {
    // return $str[ strlen($str) - 1 ];
    return substr($str, -1);
}

function lastCharCode($str): int {
    return ord(lastChar($str));
}

// ╔═══════════════════════════════════════════════════════════════════════╗
// ║                                 HTTP                                  ║
// ╚═══════════════════════════════════════════════════════════════════════╝

function redirect($url = "/") {
    header("Location: $url"); exit;
}

function erreurHTTP($code) : void {
    http_response_code($code); redirect("/$code.php"); exit;
}

