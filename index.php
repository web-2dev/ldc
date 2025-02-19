<?php 
include "tools/init.inc.php";
$idU = null;
if( getServer("REQUEST_METHOD") == "GET" ) {
    if( !getCookie("idu") && !getCookie("ldcaut") ) {
        $newIdU = setCookieIdU();
        mkdir(ROOT_DIR . "data/$newIdU");
        copy(ROOT_DIR . "data/init/auth.php", ROOT_DIR . "data/$newIdU/auth.php");
        copy(ROOT_DIR . "data/init/list.php", ROOT_DIR . "data/$newIdU/list.php");
        copy(ROOT_DIR . "data/init/log.php",  ROOT_DIR . "data/$newIdU/log.php");

    }

    $idU = getCookie("idu");
    displayHTML("add_user", ["authorizedUsers" => getDataFileValue("data/$idU/auth.php")]);
}