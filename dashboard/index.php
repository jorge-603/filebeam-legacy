<?php 
    session_start();

    if(!isset($_SESSION["user"])){
        header("Location: login.php");
        return;
    }
?>


<?php 
require "partials/header.php"; 
require "../lib/time.php";
?>

<body>

</body>
</html>