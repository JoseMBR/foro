<?php
// app/controllers/eliminarTemaController.php - Procesa la eliminación de un tema
session_start();
require_once '../../config/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Tema no especificado.";
    header("Location: ../../public/temas.php");
    exit;
}

$id_tema = $_GET['id'];

if (!isset($_SESSION['usuario'])) {
    $_SESSION['error'] = "Debes iniciar sesión para eliminar un tema.";
    header("Location: ../../public/login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM temas WHERE id_tema = ?");
$stmt->execute([$id_tema]);
$tema = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tema || $_SESSION['usuario']['id'] != $tema['usuario_id']) {
    $_SESSION['error'] = "No tienes permiso para eliminar este tema.";
    header("Location: ../../public/temas.php");
    exit;
}

$stmt = $pdo->prepare("DELETE FROM temas WHERE id_tema = ?");
try {
    $stmt->execute([$id_tema]);
    $_SESSION['mensaje'] = "Tema eliminado correctamente.";
} catch (PDOException $e) {
    $_SESSION['error'] = "Error al eliminar el tema: " . $e->getMessage();
}
header("Location: ../../public/temas.php");
exit;
?>
