<?php 

require_once "../config/config.php";
require_once "../lib/rename.php";

function submit($file, $time){

    require_once "../config/connection.php";
    require_once "../lib/time.php";
    require_once "../api/log.php";

    if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK){
        # Obtiene datos del archivo subido
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        # Directorio en donde se van a mover los archivos
        $uploadFileDir = $GLOBALS['uploadFileDir'];

        # Sanitizacion del nombre del archivo generando un nombre aleatorio
        $newFileName = randomize(6) . '.' . $fileExtension;

        # Comprueba si el archivo ya existe en el servidor
        while(file_exists($uploadFileDir . $newFileName)) {
            $newFileName = randomize(6) . '.' . $fileExtension; // Genera un nuevo nombre único
        }

        # Comprueba si el archivo es o no permanente
        # $time = 0 -> es permanente
        # $time > 0 -> NO es permanente
        if ($time > 0 || !isset($time)){
            $maxFileSize = 1000 * 1000 * 1000; # 1 GB
        } else {
            $maxFileSize = $GLOBALS['maxFileSize']; # 100 MB
        }

        if (!in_array($fileExtension, $GLOBALS['unallowedfileExtensions'])){

            # Valida el tipo MIME del archivo
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $fileMimeType = finfo_file($finfo, $fileTmpPath);
            finfo_close($finfo);

            # Valida el tamaño del archivo
            if($fileSize <= $maxFileSize){

                if(move_uploaded_file($fileTmpPath, $uploadFileDir . $newFileName)){

                    # Obtiene la extension del archivo
                    $fileExtension = strtolower((pathinfo($uploadFileDir . $newFileName, PATHINFO_EXTENSION)));

                    # Sanitiza solo los archivos potencialmente peligrosos (php, html y similares)
                    if ($fileExtension == 'php' || $fileExtension === 'html' || $fileExtension === 'xhtml' || $fileExtension === 'xml' || $fileExtension === 'md'){
                        $sanitiziedContent = file_get_contents($uploadFileDir . $newFileName);
                        $sanitiziedContent = htmlspecialchars($sanitiziedContent, ENT_QUOTES | ENT_HTML5);
                        file_put_contents($uploadFileDir . $newFileName, $sanitiziedContent);
                    }

                    
                    $sent_time = getTimestamp();
                    $file_dir = $uploadFileDir . $newFileName;
                    $hash = hash_file('sha256', $file_dir);
                    

                    switch($time){
                        case 0:
                            # Esto es en caso de que el archivo sea permanente. Si no está registrado en la base de datos, no se eliminará
                            addLog($newFileName, $hash);
                        break;
                        case 1:
                            $expire_time = $sent_time+3600; # 1 hora
                            $stmt = $conn->prepare("INSERT INTO tmp_files (file_name, sent_time, expire_time) VALUES (:file_name, :sent_time, :expire_time)");
                            $stmt->bindParam(":file_name", $newFileName);
                            $stmt->bindParam("sent_time", $sent_time);
                            $stmt->bindParam(":expire_time", $expire_time);
                            $stmt->execute();
                            addLog($newFileName, $hash);
                            break;
                        case 2:
                            $expire_time = $sent_time+7200; # 2 horas
                            $stmt = $conn->prepare("INSERT INTO tmp_files (file_name, sent_time, expire_time) VALUES (:file_name, :sent_time, :expire_time)");
                            $stmt->bindParam(":file_name", $newFileName);
                            $stmt->bindParam("sent_time", $sent_time);
                            $stmt->bindParam(":expire_time", $expire_time);
                            $stmt->execute();
                            addLog($newFileName, $hash);
                            break;
                        case 6:
                            $expire_time = $sent_time+21600; # 6 horas
                            $stmt = $conn->prepare("INSERT INTO tmp_files (file_name, sent_time, expire_time) VALUES (:file_name, :sent_time, :expire_time)");
                            $stmt->bindParam(":file_name", $newFileName);
                            $stmt->bindParam("sent_time", $sent_time);
                            $stmt->bindParam(":expire_time", $expire_time);
                            $stmt->execute();
                            addLog($newFileName, $hash);
                            break;
                        case 12:
                            $expire_time = $sent_time+43200; # 12 horas
                            $stmt = $conn->prepare("INSERT INTO tmp_files (file_name, sent_time, expire_time) VALUES (:file_name, :sent_time, :expire_time)");
                            $stmt->bindParam(":file_name", $newFileName);
                            $stmt->bindParam("sent_time", $sent_time);
                            $stmt->bindParam(":expire_time", $expire_time);
                            $stmt->execute();
                            addLog($newFileName, $hash);
                        case 24:
                            $expire_time = $sent_time+86400; # 24 horas
                            $stmt = $conn->prepare("INSERT INTO tmp_files (file_name, sent_time, expire_time) VALUES (:file_name, :sent_time, :expire_time)");
                            $stmt->bindParam(":file_name", $newFileName);
                            $stmt->bindParam("sent_time", $sent_time);
                            $stmt->bindParam(":expire_time", $expire_time);
                            $stmt->execute();
                            addLog($newFileName, $hash);
                            break;
                        case 48:
                            $expire_time = $sent_time+172800; # 48 horas
                            $stmt = $conn->prepare("INSERT INTO tmp_files (file_name, sent_time, expire_time) VALUES (:file_name, :sent_time, :expire_time)");
                            $stmt->bindParam(":file_name", $newFileName);
                            $stmt->bindParam("sent_time", $sent_time);
                            $stmt->bindParam(":expire_time", $expire_time);
                            $stmt->execute();
                            addLog($newFileName, $hash);
                            break;
                        case 72:
                            $expire_time = $sent_time+259200; # 72 horas
                            $stmt = $conn->prepare("INSERT INTO tmp_files (file_name, sent_time, expire_time) VALUES (:file_name, :sent_time, :expire_time)");
                            $stmt->bindParam(":file_name", $newFileName);
                            $stmt->bindParam("sent_time", $sent_time);
                            $stmt->bindParam(":expire_time", $expire_time);
                            $stmt->execute();
                            addLog($newFileName, $hash);
                            break;
                        default:
                            echo "Valor de tiempo incorrecta, solo se admiten 0 (permanente), 1, 2, 6, 12, 24, 48 y 72 horas. Archivo eliminado";
                            unlink($uploadFileDir . $newFileName);
                            die;
                    }

                    $uri = $GLOBALS['uri']; # Dominio del servidor
                    $port = $_SERVER['SERVER_PORT']; # Puerto del servidor

                    # Determina (de acuerdo al puerto) si la pagina usa HTTP o HTTPS
                    if($port == 443){
                        $fileUrl = "https://$uri/file/" . $newFileName;
                    }
                    else{
                        $fileUrl = "http://$uri/file/" . $newFileName;
                    }

                    echo $fileUrl;

                } else {
                    # Si el archivo no se subió / envió a la carpeta destino del servidor
                    http_response_code(500);
                    echo "Ha ocurrido un error al subir el archivo";
                }

            } else {
                # Si excede el tamaño del archivo
                http_response_code(413);
                echo "El archivo excede el máximo permitido: 100MB para archivos permanentes y 1GB para archivos temporales.";
            }

        } else {
            # Si la extension del archivo no es admitida
            http_response_code(400);
            echo "La extension del archivo no es admitida";
        }
    } else {
        # Ha ocurrido un error al subir el archivo
        http_response_code(400);
        echo "No se ha enviado ningun archivo";
    }
}
