<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html translate="no">
<meta name="google" content="notranslate">

<head>
    <title>FileBeam</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.svg">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <!-- <meta property="og:title" content="FILES (BETA)">
    <meta property="og:description" content="Comparte archivos rapidamente mediante enlaces directos">
    <meta property="og:url" content="files.jorge603.xyz">
    <meta property="og:type" content="website"> -->
</head>

<body>
    <?php
    $queryString = isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
    ?>
    <div class="background">
        <div class="blob"></div>
    </div>
    <div class="mainContainer">
        <header>
            <div class="logo">
                <img class="appIcon" src="favicon.svg">
                <span class="appName">FileBeam</span>
                <span class="appVer">v0.2.0-dev</span>
            </div>
            <div class="links">
                <a href="#">API</a>
                <a href="#">FAQ</a>
                <i data-feather="settings"></i>
            </div>
        </header>
        <main>
            <div id="dropArea">
                <i data-feather="upload-cloud"></i>
                <span>ARRASTRA Y SUELTA UN ARCHIVO AQUI</span>
                <span class="divider">o</span>
                <span class="sub">haz click para seleccionar</span>
                <input type="file" id="fileInput" name="uploadedFile" />
            </div>
            <div class="expire">
                <select name="expire" id="expireDropdown">
                    <option value="expire-0">No Expirar</option>
                    <option value="expire-2">Expirar en 2 horas</option>
                    <option value="expire-6">Expirar en 6 horas</option>
                    <option value="expire-12">Expirar en 12 horas</option>
                    <option value="expire-24">Expirar en un dia</option>
                </select>
                <span>Tamaño Maximo: 100MB</span>
            </div>
            <button disabled id="uploadBtn" type="submit" name="uploadBtn" value="Subir" disabled>
                <i data-feather="upload"></i> Subir
            </button>
        </main>
    </div>
    <script src="/assets/js/feather.min.js"></script>
    <script src="/assets/js/custom-select.min.js"></script>
    <script src="/assets/js/anime.min.js"></script>
    <script src="/assets/js/index.js"></script>
</body>

</html>