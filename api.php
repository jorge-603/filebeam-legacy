<?php

require "submit.php";
require "config/config.php";

if($maintenance){
    http_response_code(503);
    echo "Servicio no disponible temporalmente (503) \n";
}else{
    
    $method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "POST":
        if (isset($_FILES["file"])) {
            submit($_FILES["file"]);
        } else {
            http_response_code(400);
            echo "No se ha enviado ningun archivo (400) \n";
        }
        break;
    default:
        http_response_code(405);
        echo "Solo se admiten peticiones POST (405) \n";
        break;
}
}