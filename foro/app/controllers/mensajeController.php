<?php
// app/controllers/mensajeController.php - Lógica para agregar un nuevo mensaje a un tema

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Usar __DIR__ para asegurar la ruta correcta al archivo de conexión
require_once __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['usuario'])) {
        $_SESSION['error'] = "Debes iniciar sesión para agregar un mensaje.";
        header("Location: ../../public/login.php");
        exit;
    }
    
    $tema_id = $_POST['tema_id'];
    // Se recoge el mensaje del formulario (campo "mensaje") y se insertará en la columna "contenido"
    $contenido = trim($_POST['mensaje']);
    $usuario_id = $_SESSION['usuario']['id'];
    
    // Inserción en la tabla "mensajes" usando NOW() para la fecha de creación
    $stmt = $pdo->prepare("INSERT INTO mensajes (contenido, usuario_id, tema_id, fecha_creacion) VALUES (?, ?, ?, NOW())");
    try {
        $stmt->execute([$contenido, $usuario_id, $tema_id]);
        $_SESSION['mensaje'] = "Mensaje agregado correctamente.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al agregar el mensaje: " . $e->getMessage();
    }
    header("Location: ../../public/verTema.php?id=" . $tema_id);
    exit;
} else {
    header("Location: ../../public/temas.php");
    exit;
}
?>
