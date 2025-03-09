<?php
// public/logout.php - Cierra la sesión del usuario y redirige a la página de inicio
session_start();
session_destroy();
header("Location: ../index.php");
exit;
?>
