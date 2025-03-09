<?php
// app/controllers/editarTemaController.php - Procesa la edición de un tema
session_start();
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tema = $_POST['id_tema'];
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    
    if (!isset($_SESSION['usuario'])) {
        $_SESSION['error'] = "Debes iniciar sesión para editar un tema.";
        header("Location: ../../public/login.php");
        exit;
    }
    
    // Verificar que el tema exista y que el usuario sea el autor.
    $stmt = $pdo->prepare("SELECT * FROM temas WHERE id_tema = ?");
    $stmt->execute([$id_tema]);
    $tema = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$tema || $_SESSION['usuario']['id'] != $tema['usuario_id']) {
        $_SESSION['error'] = "No tienes permiso para editar este tema.";
        header("Location: ../../public/temas.php");
        exit;
    }
    
    $stmt = $pdo->prepare("UPDATE temas SET titulo = ?, descripcion = ? WHERE id_tema = ?");
    try {
        $stmt->execute([$titulo, $descripcion, $id_tema]);
        $_SESSION['mensaje'] = "Tema actualizado exitosamente.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al actualizar el tema: " . $e->getMessage();
    }
    header("Location: ../../public/temas.php");
    exit;
} else {
    header("Location: ../../public/temas.php");
    exit;
}
?>
