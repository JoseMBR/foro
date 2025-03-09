<?php
// app/controllers/eliminarMensajeController.php - Procesa la eliminación de un mensaje
session_start();
require_once '../../config/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Mensaje no especificado.";
    header("Location: ../../public/temas.php");
    exit;
}

$id = $_GET['id'];

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario'])) {
    $_SESSION['error'] = "Debes iniciar sesión para eliminar un mensaje.";
    header("Location: ../../public/login.php");
    exit;
}

// Obtener el mensaje para verificar el autor y obtener el id del tema
$stmt = $pdo->prepare("SELECT * FROM mensajes WHERE id = ?");
$stmt->execute([$id]);
$mensaje = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mensaje || $_SESSION['usuario']['id'] != $mensaje['usuario_id']) {
    $_SESSION['error'] = "No tienes permiso para eliminar este mensaje.";
    header("Location: ../../public/verTema.php?id=" . $mensaje['tema_id']);
    exit;
}

// Eliminar el mensaje
$stmt = $pdo->prepare("DELETE FROM mensajes WHERE id = ?");
try {
    $stmt->execute([$id]);
    $_SESSION['mensaje'] = "Mensaje eliminado correctamente.";
} catch (PDOException $e) {
    $_SESSION['error'] = "Error al eliminar el mensaje: " . $e->getMessage();
}
header("Location: ../../public/verTema.php?id=" . $mensaje['tema_id']);
exit;
?>
