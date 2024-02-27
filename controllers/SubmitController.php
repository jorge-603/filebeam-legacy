<?php
//Accesar a las librerias o a partes externas de la página para la ejecución del código
include_once 'lib/rename.php';
include_once 'config/config.php';
include_once 'config/connection.php';

/** A HACER EL CODIGO PHP MAS ABERRANTE QUE VERÁS EN TU VIDA V2.0 :el_bromas: */

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = ''; //Inicializacion de la variable para la sesión

if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Subir') {
    if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
        // Obtiene detalles del archivo subido
        $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
        $fileName = $_FILES['uploadedFile']['name'];
        $fileSize = $_FILES['uploadedFile']['size'];
        $fileType = $_FILES['uploadedFile']['type'];
        $maxFileSize = 100 * 1024 * 1024; // Tamaño máximo permitido: 100 MB (100 * 1024 * 1024 bytes)
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitiza el nombre del archivo creando un nombre aleatorio
        $newFileName = randomize(6) . '.' . $fileExtension;

        if (!in_array($fileExtension, $unallowedfileExtensions)) {

            // Directorio en donde los archivos van a ser movidos
            $dest_path = $uploadFileDir . $newFileName;

            // Validar el tipo MIME del archivo
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $fileMimeType = finfo_file($finfo, $fileTmpPath);
            finfo_close($finfo);

            // Validar el tamaño del archivo
            if ($fileSize <= $maxFileSize) {

                // Calcular el hash del archivo antes de guardarlo
                $fileHashBefore = md5_file($fileTmpPath);

                if (move_uploaded_file($fileTmpPath, $dest_path)) {

                    // Calcular el hash del archivo después de guardarlo
                    $fileHashAfter = md5_file($dest_path);

                    // Comparar los hashes para verificar la integridad del archivo
                    if ($fileHashBefore === $fileHashAfter) {

                        // Obtener la extensión del archivo
                        $fileExtension = strtolower(pathinfo($dest_path, PATHINFO_EXTENSION));

                        // Sanitizar solo los archivos PHP y HTML
                        if ($fileExtension === 'php' || $fileExtension === 'html') {
                            $sanitizedContent = file_get_contents($dest_path);
                            $sanitizedContent = htmlspecialchars($sanitizedContent, ENT_QUOTES | ENT_HTML5);
                            file_put_contents($dest_path, $sanitizedContent);
                        }

                        $message = "Archivo subido correctamente";

                        // Obtener la URL de ubicación del archivo (opcional si se sigue almacenando en un directorio accesible públicamente)
                        $fileUrl = "http://$domain/file/" . $newFileName;

                        $message .= '<br><a href="' . $fileUrl . '">' . $fileUrl . '</a>'; //Mensaje del archivo subido correctamente.
                    } else {
                        // Los hashes no coinciden, el archivo puede haber sido modificado durante la carga
                        unlink($dest_path); // Elimina el archivo subido
                        $message = 'El archivo pudo haber sido modificado durante la carga, ha sido descartado';
                    }

                } else {
                    $message = 'Ha ocurrido un error en la subida de archivos, es posible que la carpeta no exista o no tenga suficientes permisos';
                }
            } else {
                $message = 'El tamaño del archivo excede el límite permitido';
            }
        } else {
            $message = 'Extension de archivo no permitida';
        }
    } else {
        $message = 'Ha ocurrido un error al subir el archivo<br>Error: ' . $_FILES['uploadedFile']['error'];
    }
}

$_SESSION['message'] = $message;

// Parametros de la URL
$queryString = $_SERVER['QUERY_STRING'];

// Añade los parametros actuales de la URL a la redireccion
$redirectURL = 'index.php';
if (!empty($queryString)) {
    $redirectURL .= '?' . $queryString;
}

header("Location: $redirectURL");