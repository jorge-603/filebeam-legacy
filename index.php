<?php 

include "config/config.php";

if($maintenance){

    http_response_code(503);
    include("err/503.php"); 
    exit;

}else{

    include "main.php";
    
}