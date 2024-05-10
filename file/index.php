<?php
include "../config/config.php";
ini_set('display_errors',1); error_reporting(E_ALL);

$url = $_SERVER['REQUEST_URI'];
$file = basename($url);

if(!$maintenance){
    if(file_exists($file)){

        $mime = mime_content_type($file);
    
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($file));
    
        readfile($file);
        exit;
    }else{
        http_response_code(404);
        include "../err/404.php";
    }
}else{
    http_response_code(503);
    include "../err/503.php";
}