<?php 
include "tools/init.inc.php";

$strUsers = getFileContent("data/user.authorize") ;
$arrUsers = explode("\n", $strUsers);
$users = [];
foreach($arrUsers as $user) {
    $userPassword = explode(":", $user);
    // ! le caractère "\n" doit être supprimé
    $users[$userPassword[0]] = lastCharCode($userPassword[1]) == 13 ? substr($userPassword[1], 0, strlen($userPassword[1]) - 1) : $userPassword[1];
}


if(!empty($_SESSION["auth"])  && $_SERVER["HTTP_USER_AGENT"] == $_SESSION["HTTP_USER_AGENT"] &&  $_COOKIE[session_name()] == $_SESSION["session"]) {
    $user = substr($_SERVER["REQUEST_URI"], 1) ?: "list"; 
    if( $user != "list" ) {
        if( !in_array($user, array_keys($users)) ) {
            erreurHTTP(404); exit;
        } elseif( $user != $_SESSION["auth"] ) {
            erreurHTTP(403);
        }
    }

    // <DEBUG
    $user == "deco" ? redirect("/deco.php") : null;
    // DEBUG>
    

    $fileNameList = "$user.json";
    $list = [];
    if ( file_exists("data/$fileNameList") ) {

        ob_start();
            include "data/$fileNameList";
            $list = ob_get_contents();
        ob_end_clean();
        $list = (array)json_decode($list);
    }
    
    $user = $user != "list" ? $user : "";

    switch ($_SERVER["REQUEST_METHOD"]) {
        case 'GET':
            $listName = "Liste $user";
            displayHTML("tableList", compact("list", "listName"));
            exit;
            break;
        
        case 'POST':
            if( !empty($_POST["delete"]) ) {
                unset($_POST["btDel"]);
                foreach ($_POST["delete"] as $index => $item) {
                    unset($list[$item]);
                }
                unset($_POST["delete"]);
            }

            foreach ($list as $item => $checked) {
                // ! dans $_POST, les espaces des clés sont remplacés par des _
                if( in_array(str_replace(" ", "_", $item), array_keys($_POST)) ) {
                    if( isset($_POST["btDel"]) ) {
                        unset($list[$item]);
                    } else {
                        $list[$item] = true;
                    }
                    unset($_POST[$item]);
                } else {
                    $list[$item] = false;
                }    
            }
    
            if( !empty($_POST["add"]) ) {
                foreach ($_POST["add"] as $key => $item) {
                    if( in_array($item, array_keys($list)) || !$item) continue;
                    $list[$item] = false;
                }
            }
    
            $file = fopen("data/$fileNameList", "w");
            fwrite($file, json_encode($list, JSON_UNESCAPED_UNICODE));
            fclose($file);
            redirect("/$user");
            break;
        
        default:
            # code...
            break;
    }
    
} else {  // utilisateur non connecté
    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            displayHTML("formAuth");
            break;
        
        case "POST":
            $userName = $_POST["identif"]   ?? null;
            $password = $_POST["passw"]     ?? null;

            if( $userName && $password ) {
                if ( !in_array($userName, array_keys($users)) ) {
                    erreurHTTP(404);
                    exit;
                }
                if ( !password_verify($password, $users[$userName]) ) {
                    erreurHTTP(401);
                    exit;
                }
                $_SESSION["auth"]            = $userName;
                $_SESSION["HTTP_USER_AGENT"] = $_SERVER["HTTP_USER_AGENT"];
                $_SESSION["session"]         = $_COOKIE[session_name()];
                $_SESSION["ip"]              = $_SERVER["SERVER_ADDR"];
                redirect("/$userName"); 
            }
            break;
    }

}
