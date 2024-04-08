<?php 

require "config/config.php";
require "lib/rename.php";
function submit($file){
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

        if (!in_array($fileExtension, $GLOBALS['unallowedfileExtensions'])){

            # Valida el tipo MIME del archivo
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $fileMimeType = finfo_file($finfo, $fileTmpPath);
            finfo_close($finfo);

            # Valida el tamaño del archivo
            if($fileSize <= $GLOBALS['maxFileSize']){

                if(move_uploaded_file($fileTmpPath, $uploadFileDir . $newFileName)){

                    # Obtiene la extension del archivo
                    $fileExtension = strtolower((pathinfo($uploadFileDir . $newFileName, PATHINFO_EXTENSION)));

                    # Sanitiza solo los archivos potencialmente peligrosos (php, html y similares)
                    if ($fileExtension == 'php' || $fileExtension === 'html' || $fileExtension === 'xhtml' || $fileExtension === 'xml' || $fileExtension === 'md'){
                        $sanitiziedContent = file_get_contents($uploadFileDir . $newFileName);
                        $sanitiziedContent = htmlspecialchars($sanitiziedContent, ENT_QUOTES | ENT_HTML5);
                        file_put_contents($uploadFileDir . $newFileName, $sanitiziedContent);
                    }

                    $domain = $GLOBALS['domain'];
                    $fileUrl = "https://$domain/file/" . $newFileName;

                    echo $fileUrl;

                } else {
                    # Si el archivo no se subió / envió a la carpeta destino del servidor
                    http_response_code(500);
                    echo "Ha ocurrido un error al subir el archivo";
                }

            } else {
                # Si excede el tamaño del archivo
                http_response_code(413);
                echo "El archivo excede el tamaño del archivo";
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
