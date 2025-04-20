<?php
session_start();

// DESTRUIR VARIABLES DE SESION /////
session_unset();

// DESTRUIR SESION ////
session_destroy();

// REGRAMOS AL INICIO
header("Location: index.html");
exit;
?>
