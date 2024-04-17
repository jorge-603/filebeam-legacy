<?php
include "../config/config.php";

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
        include "../404.php";
    }
}else{
    http_response_code(503);
    include "../503.php";
}
