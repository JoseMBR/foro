<?php
// app/controllers/editarMensajeController.php - Procesa la edición de un mensaje

session_start();
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // Identificador del mensaje
    $tema_id = $_POST['tema_id'];
    $nuevo_mensaje = trim($_POST['mensaje']);
    
    // Verificar que el usuario esté logueado
    if (!isset($_SESSION['usuario'])) {
        $_SESSION['error'] = "Debes iniciar sesión para editar un mensaje.";
        header("Location: ../../public/login.php");
        exit;
    }
    
    // Verificar que el usuario sea el autor del mensaje
    $stmt = $pdo->prepare("SELECT * FROM mensajes WHERE id = ?");
    $stmt->execute([$id]);
    $mensaje = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$mensaje || $_SESSION['usuario']['id'] != $mensaje['usuario_id']) {
        $_SESSION['error'] = "No tienes permiso para editar este mensaje.";
        header("Location: ../../public/verTema.php?id=" . $tema_id);
        exit;
    }
    
    // Actualizar el mensaje en la columna "contenido"
    $stmt = $pdo->prepare("UPDATE mensajes SET contenido = ? WHERE id = ?");
    try {
        $stmt->execute([$nuevo_mensaje, $id]);
        $_SESSION['mensaje'] = "Mensaje actualizado exitosamente.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al actualizar el mensaje: " . $e->getMessage();
    }
    
    header("Location: ../../public/verTema.php?id=" . $tema_id);
    exit;
} else {
    header("Location: ../../public/temas.php");
    exit;
}
?>
