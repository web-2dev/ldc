<?php 
session_name('L2C_SESS');
session_start();
include "functions.inc.php";
include "functions_cookie.inc.php";

// ! ce fichier ne peut être inclus qu'à partir de la racine pour avoir la bonne valeur pour ROOT_DIR
const ROOT_DIR = __DIR__ . "/../";
// define("ROOT_DIR", getcwd()."/");

