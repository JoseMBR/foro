<?php
// app/controllers/editarPerfilController.php - Procesa la actualización del perfil del usuario con cambio de contraseña
session_start();
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['usuario'])) {
        $_SESSION['error'] = "Debes iniciar sesión para editar tu perfil.";
        header("Location: ../../public/login.php");
        exit;
    }
    
    $id = $_SESSION['usuario']['id'];
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    
    // Campos para cambio de contraseña
    $actual_contrasena = trim($_POST['actual_contrasena']);
    $nueva_contrasena = trim($_POST['nueva_contrasena']);
    $confirmar_nueva_contrasena = trim($_POST['confirmar_nueva_contrasena']);
    
    // Si se desea cambiar la contraseña, todos los campos deben estar llenos
    if (!empty($actual_contrasena) || !empty($nueva_contrasena) || !empty($confirmar_nueva_contrasena)) {
        if (empty($actual_contrasena) || empty($nueva_contrasena) || empty($confirmar_nueva_contrasena)) {
            $_SESSION['error'] = "Para cambiar la contraseña, completa todos los campos.";
            header("Location: ../../public/editarPerfil.php");
            exit;
        }
        
        // Verificar que la contraseña actual sea correcta
        $stmt = $pdo->prepare("SELECT contrasena FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$usuario || !password_verify($actual_contrasena, $usuario['contrasena'])) {
            $_SESSION['error'] = "La contraseña actual no es correcta.";
            header("Location: ../../public/editarPerfil.php");
            exit;
        }
        
        // Verificar que la nueva contraseña y la confirmación coincidan
        if ($nueva_contrasena !== $confirmar_nueva_contrasena) {
            $_SESSION['error'] = "La nueva contraseña y su confirmación no coinciden.";
            header("Location: ../../public/editarPerfil.php");
            exit;
        }
        
        $nueva_contrasena_encriptada = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET nombre = ?, correo = ?, contrasena = ? WHERE id = ?";
        $params = [$nombre, $correo, $nueva_contrasena_encriptada, $id];
        // Mensaje que incluye confirmación de cambio de contraseña
        $mensaje = "Perfil actualizado y contraseña cambiada correctamente.";
    } else {
        // Solo se actualizan nombre y correo
        $sql = "UPDATE usuarios SET nombre = ?, correo = ? WHERE id = ?";
        $params = [$nombre, $correo, $id];
        $mensaje = "Perfil actualizado correctamente.";
    }
    
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute($params);
        // Actualizar los datos en la sesión
        $_SESSION['usuario']['nombre'] = $nombre;
        $_SESSION['usuario']['correo'] = $correo;
        if (isset($nueva_contrasena_encriptada)) {
            $_SESSION['usuario']['contrasena'] = $nueva_contrasena_encriptada;
        }
        $_SESSION['mensaje'] = $mensaje;
        header("Location: ../../public/perfil.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al actualizar el perfil: " . $e->getMessage();
        header("Location: ../../public/editarPerfil.php");
        exit;
    }
} else {
    header("Location: ../../public/editarPerfil.php");
    exit;
}
?>
