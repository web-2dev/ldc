<?php 
session_name('LDC_SESS');
session_set_cookie_params([
    'lifetime' => time() + (100 * 365 * 24 * 60 * 60),  // Durée de vie du cookie : 100 ans (en secondes)
    // 'path'     => '/',    // Disponible dans tout le site
    // 'domain'   => 'example.com',  // Domaine
    // 'secure'   => true,   // Seulement sur HTTPS
    // 'httponly' => true,   // Inaccessible via JavaScript
]);
session_start();
include "functions.inc.php";