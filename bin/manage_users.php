<?php 
include "../tools/init.inc.php";

if( getServer("REQUEST_METHOD") == "POST" ) {
    $idu = getCookie("idu");
    $authFilename = ROOT_DIR . "data/$idu/auth.php";

    $authorizedUsers = getDataFileValue($authFilename);
    extract($_POST);
    // vérif
    $authorizedUsers[$nickname] = password_hash($password, PASSWORD_DEFAULT);
    updateDataPassFile( $authFilename, $authorizedUsers );
    redirect();
} else {
    setMessage("danger", "405 : Méthode proscrite !");
}