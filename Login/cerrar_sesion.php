<?php
session_start(); // Inicia la sesión

// Limpia todas las variables de sesión
$_SESSION = array();

// Destruye la sesión
session_destroy();

// Redirige al formulario de inicio de sesión
header("Location: login.php");
exit();
?>
