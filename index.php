<?php 
include "tools/init.inc.php";
/********** Récupération des utilisateurs  **********/
$authorized = include "data/auth.php";

$authorizedEncodedUsernames = array_keys($authorized);

switch ( getServer("REQUEST_METHOD") ) {
    case 'GET':
        $allowed = false;
        if( $cookie = getCookie("ldcaut") ) {
            foreach ($authorizedEncodedUsernames as $encodedUsername) {
                if( password_verify($encodedUsername . getUserLastConnectionDate($encodedUsername), $cookie) ) {
                    $allowed = $encodedUsername;
                    break;
                }
            }

            if( $allowed ) {
                recordLogConnection($allowed);
            // }

            // if( $connected ) {
                $list = getDataFileValue("data/list.php", []);
                displayHTML("tableList", compact("list"));
                exit;
            } else {
                setMessage("error", "C'est bizarre ! Vous n'êtes pas qui vous prétendez être !!!");
                setcookie("ldcaut", null, 1);
            }
        }
        displayHTML("formAuth");
        exit;
        break;
    
    case "POST":
        extract($_POST);
        if( $ident ?? false && $passw ?? false ) {
            
            if( $encodedUsername = getUsername($ident) ) {
                if( password_verify($passw, $authorized[$encodedUsername]) ) {
                    recordLogConnection($encodedUsername);
                    // $now = date_format(new DateTime(), "Y-m-d H:i:s");
                    // $conn = [
                    //     "date" => $now,
                    //     "ident" => $encodedUsername,
                    //     "HTTP_USER_AGENT" => getServer("HTTP_USER_AGENT"),
                    //     "HTTP_ACCEPT" => getServer("HTTP_ACCEPT"),
                    //     "HTTP_ACCEPT_LANGUAGE" => getServer("HTTP_ACCEPT_LANGUAGE"),
                    //     "HTTP_ACCEPT_ENCODING" => getServer("HTTP_ACCEPT_ENCODING"),
                    //     "REMOTE_ADDR" => getServer("REMOTE_ADDR"),
                    // ];

                    // $cookieValue = password_hash($encodedUsername . $now, PASSWORD_DEFAULT);
                    // setcookie("ldcaut", $cookieValue, time() + 60 * 60 * 24 * 365 * 2 );
                    // $histo = getDataFileValue("data/log.php");
                    // $histo[] = $conn;
                    // updateArrayDataFile("data/log.php", $histo);

                    setMessage("success", "connexion acceptée");
                }
                else {
                    setMessage("erreur", "Connexion refusée");
                }
            } else {
                setMessage("danger", "Accès refusé ! Passez votre chemin");
            }
        } else {
            setMessage("erreur", "Y'a 2 champs ?! Ai-je vraiment besoin de préciser que les 2 sont obligatoires ?");
        }
        httpRedirect("/");
        exit;
        break;
}