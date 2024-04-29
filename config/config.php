<?php

/**
 * ARCHIVO DE CONFIGURACION DEL PROYECTO
 * AQUI YACERÁN LAS VARIABLES DE CONFIGURACION DEL PROYECTO.
 * CONFORME HAYAN MAS FUNCIONES, SERÁN AGREGADAS MAS
 * VARIABLES DE CONFIGURACION.
 */

$domain = $_SERVER['SERVER_NAME']; # Dominio del servidor, esto es generado automaticamente.
$uploadFileDir = 'file' . '/'; # Directorio donde va a ser alojado el archivo
$unallowedfileExtensions = array('js', 'jar', 'scr', 'cpl', 'jsp', 'doc', 'docx'); # Extensiones no permitidas.
$maxFileSize = 100 * 1000 * 1000; # 100 * 1000 * 1000 = 100000000 Bytes = 100 MB
$maintenance = false; # Modo mantenimiento <true|false>