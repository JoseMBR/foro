<?php
// app/controllers/registroController.php - Lógica de Registro de Usuario con comprobación de usuario repetido y validación de campos vacíos
session_start();
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar que los campos no estén vacíos
    if(empty(trim($_POST['nombre'])) || empty(trim($_POST['correo'])) || empty(trim($_POST['contrasena']))) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header("Location: ../../public/registro.php");
        exit;
    }
    
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];
    
    // Comprobar si ya existe un usuario con el mismo correo
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    if($stmt->rowCount() > 0) {
        $_SESSION['error'] = "El correo ya está registrado.";
        header("Location: ../../public/registro.php");
        exit;
    }
    
    // Encriptar la contraseña (se usa password_hash en lugar de MD5 por seguridad)
    $contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);
    
    // Asignar rol por defecto y registrar la fecha con NOW()
    $rol = "usuario";
    
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, contrasena, rol, fecha_registro) VALUES (?, ?, ?, ?, NOW())");
    try {
        $stmt->execute([$nombre, $correo, $contrasena_encriptada, $rol]);
        // Enviar mail de bienvenida
        $asunto = "Bienvenido al Foro";
        $mensaje = "Gracias por registrarte, $nombre. ¡Bienvenido!";
        $cabeceras = "From: no-reply@forodb.com";
        mail($correo, $asunto, $mensaje, $cabeceras);
        
        $_SESSION['mensaje'] = "Registro exitoso. Por favor, <a href='login.php'>inicia sesión</a>.";
        header("Location: ../../public/registro.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error en el registro: " . $e->getMessage();
        header("Location: ../../public/registro.php");
        exit;
    }
} else {
    header("Location: ../../public/registro.php");
    exit;
}
?>
