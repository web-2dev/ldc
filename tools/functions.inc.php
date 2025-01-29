<?php 
function getUserLogs($user) {
    $user = getUsername($user) ?? $user;
    $logs = getDataFileValue(__DIR__ . "/../data/log.php");
    $userlogs = array_filter($logs, function($log) use ($user){
        return $log["ident"] == $user;
    });
    return $userlogs;
}

function getUserLogConnectionDate($user) {
    $userLogs = getUserLogs($user);
    return array_column($userLogs, "date");
}

function getUserLastConnectionDate($user) {
    $dates = getUserLogConnectionDate($user);
    return $dates ? $dates[ count($dates) - 1 ] : null;
}



// ╔═══════════════════════════════════════════════════════════════════════╗
// ║                            AFFICHAGE HTML                             ║
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
// ║                                FICHIERS                               ║
// ╚═══════════════════════════════════════════════════════════════════════╝

/**
 * Modifier un fichier data (PHP)
 * Un DataFile est un fichier PHP qui retourne un array soit numérique soit associatif.
 */
function updateArrayDataFile($fileName, $arrayData) {
    // ? récupérer les données ici pour ajouter les nouvelles
    $text = "<?php\n\nreturn [\n";
    foreach($arrayData as $index => $array) {
        $text .= "\t[\n";
        foreach($array as $key => $value) {
            // $key = str_replace("$", "\$", $key); vde($key);
            // $value = str_replace("$", "\$", $value);
            $text .= "\t\t'$key' => '$value',\n";
        }
        $text .= "\n\t],\n";
    }
    $text .= "];";
    $file = fopen($fileName, "w+");
    fwrite($file, $text);
    fclose($file);
}

function updateDataFile($fileName, $array) {
    $jdnFile = fopen($fileName, "w+");
    fwrite($jdnFile, "<?php\n\nreturn [\n");
    foreach($array as $key => $value) {
        if( is_int($key) ) 
            fwrite($jdnFile, "\t\"$value\",\n");
        else 
            fwrite($jdnFile, "\t\"$key\" => \"$value\",\n");
    }
    fwrite($jdnFile, "];");
    fclose($jdnFile);
}


/**
 * à utiliser pour les datefile PHP contenant un "return"
 */
function getDataFileValue($filePath, $default = null) : mixed {
    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
        throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
    });
    
    try {
        $data = include $filePath;
    } catch (ErrorException $e) {
        echo "Exception capturée : " . $e->getMessage();
        return $default;
    }
    
    // Restaurez le gestionnaire d'erreurs
    restore_error_handler();
    
    return $data;
}

function getFileContent($filePath): string {
    ob_start();
    include $filePath;
    $text = ob_get_contents();
    ob_end_clean();
    return $text;
}

function getArrayJsonFileValue($filePath) : mixed {
    $return = null;
    if ( !file_exists($filePath) ) {
        ob_start();
            include $fileNameList;
            $return = ob_get_contents();
        ob_end_clean();
        $return = (array)json_decode($return);
    }
}


// ╔═══════════════════════════════════════════════════════════════════════╗
// ║                                  CSS                                  ║
// ╚═══════════════════════════════════════════════════════════════════════╝
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
// ║                                 HTTP                                  ║
// ╚═══════════════════════════════════════════════════════════════════════╝

function httpRedirect($url) {
    header("Location: $url");
    exit;
}

function redirect($url = "/") {
    header("Location: $url"); exit;
}


// ╔═══════════════════════════════════════════════════════════════════════╗
// ║                                 DEBUG                                 ║
// ╚═══════════════════════════════════════════════════════════════════════╝

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

    foreach (func_get_args() as $variable) {
        print_r($variable);
        echo "<hr>";
    }
    echo "<br></pre>";
}

function pre() {
    exit (call_user_func_array('pr', func_get_args()));
}


// ╔═══════════════════════════════════════════════════════════════════════╗
// ║                                STRING                                 ║
// ╚═══════════════════════════════════════════════════════════════════════╝

function lastChar($str): string {
    // return $str[ strlen($str) - 1 ];
    return substr($str, -1);
}

function lastCharCode($str): int {
    return ord(lastChar($str));
}

/**
 * v1.1 : utilisation de htmlspecialchars parce que 
 *  • ne modifie QUE les caractères suivants : &'"<>
 *  • htmlEntities modifie les caractères accentués !
 */
function checkString($word): bool {
    // option ENT_COMPAT : convertit " mais pas ' (htmlEntities)
    $check = htmlSpecialChars($word);
    return strlen($check) == strlen($word);
}


// ╔═══════════════════════════════════════════════════════════════════════╗
// ║                            SUPPER GLOBALES                            ║
// ╚═══════════════════════════════════════════════════════════════════════╝

function getGlobal($super, $key, $default = null) {
    return $super[$key] ?? null;
}

function getSession(string $key): mixed {
    return getGlobal($_SESSION, $key);
}
function getServer(string $key): mixed {
    return getGlobal($_SERVER, $key);
}

function setSession(string $key, mixed $value) {
    $_SESSION[$key] = $value;
}

function getMessages(): ?array {
    $sessionMessages = $_SESSION["messages"] ?? [];
    $_SESSION["messages"] = [];
    return $sessionMessages;
}

function setMessage($key, $message) {
    switch ($key) {
        case "danger": case "error": case "erreur": case "fail": case "échec": case "red": case "rouge":
            $key = "danger";
            $message .= "<br><img src='/assets/images/getout.jpg'>";
            break;
            
        case "success": case "succes": case "succès": case "réussite": case "green": case "vert":
            $key = "success";
            break;
        
        case "warning": case "avertissement": case "attention": case "careful": case "aware": case "orange":
            $key = "warning";
            break;
        
        case "info": case "information": case "texte": case "text": case "bleu": case "blue":
            $key = "info";
            break;
        
        case "secondary": case "gris": case "gray": case "grey": 
            $key = "secondary";
            break;
        
        default:
            $key = "primary";
            break;
    }
    $_SESSION["messages"][$key][] = $message;
}

function getCookie($cookie) {
    return getGlobal($_COOKIE, $cookie);
}


// ╔═══════════════════════════════════════════════════════════════════════╗
// ║                               VARIABLES                               ║
// ╚═══════════════════════════════════════════════════════════════════════╝

function exists(mixed $var): bool {
    return !empty($var);
}

// ╔═══════════════════════════════════════════════════════════════════════╗
// ║                               SECURITY                                ║
// ╚═══════════════════════════════════════════════════════════════════════╝

/**
 * Les indices de l'associative array du fichier auth.php sont équivalents à la version hashée des noms d'utilisateurs
 * autorisés.
 * getUsername() vérifie que l'identifiant passé en argument correspond à l'un des ces indices. 
 * C'est l'indice encodé qui est renvoyé !
 * 
 * @param string $ident idenfiant à rechercher dans la liste des autorisés
 * @return string|null null si l'identifiant n'est pas trouvé
 */
function getUsername(string $ident): ?string {
    $authorizedUsers = getDataFileValue(__DIR__ . "/../data/auth.php");
    $usernames = array_keys($authorizedUsers);
    foreach ($usernames as $encodedUsername) {
        if( password_verify($ident, $encodedUsername) ) {
            return $encodedUsername;
        }
    }
    return null;
}