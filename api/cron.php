<?php 

include_once '../config/config.php';
include_once '../config/connection.php';

$timestamp = new DateTime();
$current_timestamp = $timestamp->getTimestamp();

echo "Ejecutando comprobación de vencimiento... <br>";

$files = $conn->query("SELECT * FROM tmp_files");
echo "Tiempo actual (timestamp): " . $current_timestamp . "<br>";


foreach ($files as $file){
    if($file['expire_time'] <= $current_timestamp){
        echo "Eliminando archivo temporal expirado...";
        $target_dir = $uploadFileDir . $file['file_name'];
        unlink($target_dir);
        $conn->prepare("DELETE FROM tmp_files WHERE id_file = :id_file")
        ->execute([":id_file" => $file['id_file']]);
        return;
    } else{
        echo "El archivo " . $file['file_name'] . " aún se encuentra vigente. Expira en " . $file['expire_time']-$current_timestamp . " segundos <br>";
    }
}

echo "¡Comprobación completada!";