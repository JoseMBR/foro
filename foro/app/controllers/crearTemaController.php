<?php
// app/controllers/crearTemaController.php - Procesa la creación de un nuevo tema
session_start();
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['usuario'])) {
        $_SESSION['error'] = "Debes iniciar sesión para crear un tema.";
        header("Location: ../../public/login.php");
        exit;
    }
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $usuario_id = $_SESSION['usuario']['id'];
    
    $stmt = $pdo->prepare("INSERT INTO temas (titulo, descripcion, usuario_id, fecha_creacion) VALUES (?, ?, ?, NOW())");
    try {
        $stmt->execute([$titulo, $descripcion, $usuario_id]);
        $_SESSION['mensaje'] = "Tema creado exitosamente.";
        header("Location: ../../public/temas.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al crear el tema: " . $e->getMessage();
        header("Location: ../../public/nuevoTema.php");
        exit;
    }
} else {
    header("Location: ../../public/nuevoTema.php");
    exit;
}
?>
