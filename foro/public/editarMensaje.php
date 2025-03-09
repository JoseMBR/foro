<?php
// public/editarMensaje.php - Vista para editar un mensaje
session_start();
$ruta_base = "../";

// Verificar que se haya pasado el parámetro id (id del mensaje)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Mensaje no especificado.";
    header("Location: " . $ruta_base . "public/temas.php");
    exit;
}

$mensaje_id = $_GET['id'];

// Conectar a la BD y obtener el mensaje
require_once '../config/db.php';
$stmt = $pdo->prepare("SELECT * FROM mensajes WHERE id = ?");
$stmt->execute([$mensaje_id]);
$mensaje = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mensaje) {
    $_SESSION['error'] = "Mensaje no encontrado.";
    header("Location: " . $ruta_base . "public/temas.php");
    exit;
}

// Verificar que el usuario esté logueado y sea el autor del mensaje
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id'] != $mensaje['usuario_id']) {
    $_SESSION['error'] = "No tienes permiso para editar este mensaje.";
    header("Location: " . $ruta_base . "public/verTema.php?id=" . $mensaje['tema_id']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Mensaje - Foro</title>
  <link rel="stylesheet" href="<?php echo $ruta_base; ?>assets/css/style.css">
</head>
<body>
  <?php include '../app/views/header.php'; ?>
  <main>
    <section class="editar-mensaje">
      <h2>Editar Mensaje</h2>
      <form action="<?php echo $ruta_base; ?>app/controllers/editarMensajeController.php" method="POST">
        <!-- Campo oculto para el id del mensaje y el id del tema -->
        <input type="hidden" name="id" value="<?php echo $mensaje['id']; ?>">
        <input type="hidden" name="tema_id" value="<?php echo $mensaje['tema_id']; ?>">
        
        <label for="mensaje">Mensaje:</label>
        <textarea name="mensaje" id="mensaje" rows="5" required><?php echo htmlspecialchars($mensaje['contenido']); ?></textarea>
        
        <input type="submit" value="Actualizar Mensaje">
      </form>
    </section>
  </main>
  <?php include '../app/views/footer.php'; ?>
</body>
</html>
