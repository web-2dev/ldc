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

// ╔═══════════════════════════════════════════════════════════════════════╗
// ║                                COOKIE                                 ║
// ╚═══════════════════════════════════════════════════════════════════════╝
function patisser($user) {
    setcookie(
        name: "ceam_ldc"
        , value: $_COOKIE[session_name()]
        , expires_or_options: time() + (100 * 365 * 24 * 60 * 60)// Durée de vie du cookie : 100 ans (en secondes)
    );
    
    setcookie(
        name: "ceam_ldcc"
        , value: password_hash($user . $_SERVER["HTTP_USER_AGENT"] . $_COOKIE[session_name()], PASSWORD_DEFAULT)
        , expires_or_options: time() + (100 * 365 * 24 * 60 * 60)// Durée de vie du cookie : 100 ans (en secondes)
    );
}

/**
 * Vérification des cookies (=> goûter)
 * si l'utilisateur correspond aux valeurs du cookie, retourne l'utilisateur, sinon null
 * Retourne false s'il n'y a pas de cookie.
 * 
 */
function goûter(): ?string {
    $session = $_COOKIE["ceam_ldc"]  ?? null;
    $control = $_COOKIE['ceam_ldcc'] ?? null;
    if( $session && $control ) {
        $users = utilisateurs();
        $control = urldecode($control);
        $auth = null;
        foreach ($users as $user => $password) {
            if( password_verify($user . $session, $control) ) {
                $auth = $user;
                break;
            }
        }
        return $auth;
    }
    return false;
}

function utilisateurs(): array {
    $strUsers = getFileContent("data/user.authorize") ;
    $arrUsers = explode("\n", $strUsers);
    $users = [];
    foreach($arrUsers as $user) {
        $userPassword = explode(":", $user);
        // ! le caractère "\n" doit être supprimé
        $users[$userPassword[0]] = lastCharCode($userPassword[1]) == 13 ? substr($userPassword[1], 0, strlen($userPassword[1]) - 1) : $userPassword[1];
    }
    return $users;    
}



