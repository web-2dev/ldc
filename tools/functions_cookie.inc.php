<?php

// COOKIES
function getCookie($cookie): mixed {
    return $_COOKIE[$cookie] ?? null;
}

function setCookieIdU() {
    $idu = uniqid("");
    setcookie("idu", $idu,  time() + 60 * 60 * 24 * 365 * 2);
    return $idu;
}

