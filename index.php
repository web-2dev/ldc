<?php 
include "tools/init.inc.php";
/********** Récupération des utilisateurs  **********/
$authorized = include "data/auth.php";
$usernames = array_keys($authorized);

switch ( getServer("REQUEST_METHOD") ) {
    case 'GET':
        if( $cookie = getCookie("ldcaut") ) {
            $list = getDataFileValue("data/list.php", []);
            displayHTML("tableList", compact("list"));
        } else {
            displayHTML("formAuth");
        }
        break;
    
    case "POST":
        extract($_POST);
        if( $ident ?? false && $passw ?? false ) {
            
            if( $encodedUsername = getUsername($ident) ) {
                if( password_verify($passw, $authorized[$encodedUsername]) ) {
                    $now = date_format(new DateTime(), "Y-m-d H:i:s");
                    $conn = [
                        "date" => $now,
                        "ident" => $encodedUsername,
                        "HTTP_USER_AGENT" => getServer("HTTP_USER_AGENT"),
                        "HTTP_ACCEPT" => getServer("HTTP_ACCEPT"),
                        "HTTP_ACCEPT_LANGUAGE" => getServer("HTTP_ACCEPT_LANGUAGE"),
                        "HTTP_ACCEPT_ENCODING" => getServer("HTTP_ACCEPT_ENCODING"),
                        "REMOTE_ADDR" => getServer("REMOTE_ADDR"),
                    ];

                    $cookieValue = password_hash($encodedUsername . $now, PASSWORD_DEFAULT);
                    setcookie("ldcaut", $cookieValue, expires_or_options: time() + 100 * 365 * 24 * 60 * 60 );
                    $histo = getDataFileValue("data/log.php");
                    $histo[] = $conn;
                    updateArrayDataFile("data/log.php", $histo);

                    setMessage("success", "connexion acceptée");
                }
                else {
                    setMessage("erreur", "Connexion refusée");
                }
            } else {
                setMessage("danger", "Accès refusé ! Passez votre chemin <br><img src='https://image.tmdb.org/t/p/original/zozlSbPA887drZysEaSRAgO5aUB.jpg'>");
            }
        } else {
            setMessage("erreur", "Y'a 2 champs ?! Ai-je vraiment besoin de préciser que les 2 sont obligatoires ?");
        }
        httpRedirect("/");
        break;
}

