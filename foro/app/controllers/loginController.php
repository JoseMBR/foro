<?php
// app/controllers/loginController.php - Lógica de Inicio de Sesión
session_start();
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    // Buscar el usuario en la BD por el campo "correo"
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar que el usuario exista y que la contraseña sea correcta (usando "contrasena")
    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        $_SESSION['usuario'] = $usuario;
        header("Location: ../../index.php");
        exit;
    } else {
        $_SESSION['error_login'] = "Credenciales incorrectas.";
        header("Location: ../../public/login.php");
        exit;
    }
} else {
    header("Location: ../../public/login.php");
    exit;
}
