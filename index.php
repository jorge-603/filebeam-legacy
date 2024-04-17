<?php 

include "config/config.php";

if($maintenance){

    http_response_code(503);
    include("503.html"); 
    exit;

}else{

    include "main.php";
    
}
