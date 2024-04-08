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
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <!-- <meta property="og:title" content="FILES (BETA)">
    <meta property="og:description" content="Comparte archivos rapidamente mediante enlaces directos">
    <meta property="og:url" content="files.jorge603.xyz">
    <meta property="og:type" content="website"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                <span class="title small">SELECCIONA UN ARCHIVO</span>
                <span class="title large">ARRASTRA Y SUELTA UN ARCHIVO AQUI</span>
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
                <span id="maxSize">Tamaño Maximo: 100MB</span>
            </div>
            <div class="link hidden">
                <span class="link-title">Archivo subido correctamente</span>
                <a></a>
                <span class="link-expire"><i data-feather="clock"></i>Expira en undefined</span>
            </div>
            <script src="./assets/js/submit.js"></script>
            <form id="fileForm" method="POST" enctype="multipart/form-data">
                <button disabled id="uploadBtn" name="uploadBtn" value="Subir" type="button" onclick="uploadFile();">
                    <i data-feather="upload"></i> Subir
                </button>
            </form>
        </main>
    </div>
    <div class="loadingOverlay hidden">
        <svg class="spinner">
            <circle>
                <animateTransform attributeName="transform" type="rotate" values="-90;810" keyTimes="0;1" dur="2s"
                    repeatCount="indefinite"></animateTransform>
                <animate attributeName="stroke-dashoffset" values="0%;0%;-157.080%" calcMode="spline"
                    keySplines="0.61, 1, 0.88, 1; 0.12, 0, 0.39, 0" keyTimes="0;0.5;1" dur="2s"
                    repeatCount="indefinite"></animate>
                <animate attributeName="stroke-dasharray" values="0% 314.159%;157.080% 157.080%;0% 314.159%"
                    calcMode="spline" keySplines="0.61, 1, 0.88, 1; 0.12, 0, 0.39, 0" keyTimes="0;0.5;1" dur="2s"
                    repeatCount="indefinite"></animate>
            </circle>
        </svg>
    </div>
    <!-- [1] -->
    <div class="overlay" id="dialog-error" aria-hidden="true">
        <!-- [2] -->
        <div class="dialog" tabindex="-1">
            <!-- [3] -->
            <div class="content" role="dialog" aria-modal="true">
                <header>
                    <h2>
                        <i data-feather="alert-triangle"></i>
                        Error
                    </h2>
                </header>
                <span class="divider"></span>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet iure, placeat veritatis ad ullam
                    aut dolores, sint fuga vitae, ducimus quae sapiente! Repellat possimus ad quo dicta eius? Officia,
                    molestiae.</p>
                <div class="buttons">
                    <button data-micromodal-close>Descartar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/lib/feather.min.js"></script>
    <script src="./assets/js/lib/custom-select.min.js"></script>
    <script src="./assets/js/lib/micromodal.min.js"></script>
    <script src="./assets/js/lib/anime.min.js"></script>
    <script>
        // Aqui se asigna la variable extBlacklist
    </script>
    <script src="./assets/js/index.js"></script>
</body>

</html>