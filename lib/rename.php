<?php

    //Inicializacion de la funcion para randomizar
    function randomize($long) {

        /**
         * EXPLICACION DE LA FUNCION:
         * Genera una cadena unica de caracteres aleatorios
         * siguiendo parametros del servidor en el momento de
         * generacion de nombres, ayudando a mantener un id unico para un archivo
         * subido a files
         **/



        //TODO: hacer un mejor algoritmo de randomizacion :grin:

        $randomstr = uniqid('', true); //Genera una serie de caracteres random unicos

        $name = substr(str_replace('.', '', $randomstr), 0, $long); //Sanitiza el nombre

        return $name; //retorna el nombre generado
    }
?>
