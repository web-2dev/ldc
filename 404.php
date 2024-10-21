<?php 

include "tools/init.inc.php";

displayHTML("errorHttp", [ "code" => "404", "msg" => "Page <code>" . $_SERVER["REQUEST_URI"] . "</code> non trouvée"]);