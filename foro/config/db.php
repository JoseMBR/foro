<?php
// config/db.php - Conexión a la base de datos
try {
    // Reemplaza 'your_user' y 'your_password' por las credenciales correctas
    $pdo = new PDO("mysql:host=localhost;dbname=forodb;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Conexión a la base de datos fallida: " . $e->getMessage());
}
?>
