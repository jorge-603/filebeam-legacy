<?php

require "submit.php";
require "../config/config.php";

if($maintenance){
    http_response_code(503);
    echo "Servicio no disponible temporalmente (503) \n";
}else{
    
    $method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "POST":
        if (isset($_FILES["file"])) {
            if(isset($_POST['time'])){
                # Archivo se sube con limite de tiempo
                $time = htmlspecialchars($_POST['time'], ENT_QUOTES, 'UTF-8');
                if(is_numeric($time)){
                    submit($_FILES["file"], $time);
                } else {
                    echo "El valor de tiempo es inválido (no es numerico), usted envió " . $time;
                }
            } else { # Si no se envia el parametro "time"
                submit($_FILES["file"], 0); # Archivo subido indefinidamente
            }
        } else {
            http_response_code(400);
            echo "No se ha enviado ningun archivo (400) \n";
        }
        break;
    case "GET":
        
        include 'logs.php';

        // http_response_code(405);
        // $maxrand = 100;
        // $res = rand(0, $maxrand);
        // if($res != 1){
        //     echo "Solo se admiten peticiones POST";
        // }
        // else {
        //     include_once "noelia.php";
        // }
}
}