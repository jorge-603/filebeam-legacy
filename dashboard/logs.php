<?php 

include_once "../config/connection.php";
include_once "../lib/time.php";

session_start();

if(!isset($_SESSION["user"])){
    header("Location: login.php");
    return;
}

?>

<?php include "partials/header.php"; ?>

<body>
    
</body>
</html>

<?php 

// echo "================================================================================= <br>";
// echo "FILEBEAM - LOGS DE ARCHIVOS SUBIDOS<br>";
// echo "FECHA ACTUAL: " . getDateTime() . "<br>";
// echo "TIMESTAMP ACTUAL: " . getTimestamp() . "<br>";
// echo "SERVIDOR: " . $_SERVER['SERVER_SOFTWARE'] . " en " . $_SERVER['SERVER_NAME'] . ", puerto " . $_SERVER['SERVER_PORT'] . "<br>";
// echo "================================================================================= <br>";
// echo "ID LOG | TIMESTAMP | HORA/FECHA | USER AGENT | DIRECCION IP | ARCHIVO | SHA-256 <br>";
// echo "================================================================================= <br>";

// $logs = $conn->query("SELECT * FROM logs");

// foreach($logs as $log){
//     echo $log['id_log'] . " | " . $log['timestamp'] . " | " . $log['date_time'] . " | " . $log['user_agent'] . " | " . $log['ip_addr'] . " | " . $log['file_name'] .  " | " . $log['hash'] ."<br>";
// }
// echo "================================================================================= <br>";

?>

