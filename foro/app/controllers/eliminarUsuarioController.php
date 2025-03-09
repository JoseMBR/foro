<?php
// app/controllers/eliminarUsuarioController.php - Procesa la eliminación de la cuenta de usuario
session_start();
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['usuario'])) {
        $_SESSION['error'] = "Debes iniciar sesión para eliminar tu cuenta.";
        header("Location: ../../public/login.php");
        exit;
    }
    
    $id = $_SESSION['usuario']['id'];
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    try {
        $stmt->execute([$id]);
        session_destroy();
        header("Location: ../../index.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al eliminar la cuenta: " . $e->getMessage();
        header("Location: ../../public/perfil.php");
        exit;
    }
} else {
    header("Location: ../../public/perfil.php");
    exit;
}
?>
