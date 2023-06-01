<?php

//session_start();

$conn = mysqli_connect (
    'localhost',
    'root',
    '',
    'parking'

);

if (!$conn){
    echo "conexion fallida";
}

/* else{
    echo "conexion establecida con exito de la base de datos";
} */

?>