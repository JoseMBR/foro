<?php
// public/verTema.php - Vista para ver un tema y sus mensajes, con botones de editar y eliminar para mensajes del usuario
session_start();
$ruta_base = "../";
require_once '../config/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: " . $ruta_base . "public/temas.php");
    exit;
}
$tema_id = $_GET['id'];

// Consulta del tema
$stmt = $pdo->prepare("SELECT t.*, u.nombre AS autor FROM temas t JOIN usuarios u ON t.usuario_id = u.id WHERE t.id_tema = ?");
$stmt->execute([$tema_id]);
$tema = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tema) {
    $_SESSION['error'] = "Tema no encontrado.";
    header("Location: " . $ruta_base . "public/temas.php");
    exit;
}

// Consulta de mensajes
$stmt = $pdo->prepare("SELECT m.*, u.nombre AS autor FROM mensajes m JOIN usuarios u ON m.usuario_id = u.id WHERE m.tema_id = ? ORDER BY m.id ASC");
$stmt->execute([$tema_id]);
$mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php echo htmlspecialchars($tema['titulo']); ?> - Foro</title>
   <link rel="stylesheet" href="<?php echo $ruta_base; ?>assets/css/style.css">
</head>
<body>
   <?php include '../app/views/header.php'; ?>
   <main>
      <section class="ver-tema">
         <h2><?php echo htmlspecialchars($tema['titulo']); ?></h2>
         <p><?php echo nl2br(htmlspecialchars($tema['descripcion'])); ?></p>
         <p class="autor">Creado por <?php echo htmlspecialchars($tema['autor']); ?> el <?php echo $tema['fecha_creacion']; ?></p>
         
         <h3>Mensajes</h3>
         <?php if (!empty($mensajes)): ?>
         <ul class="lista-mensajes">
            <?php foreach ($mensajes as $mensaje): ?>
            <li>
               <p><?php echo nl2br(htmlspecialchars($mensaje['contenido'])); ?></p>
               <span class="autor">por <?php echo htmlspecialchars($mensaje['autor']); ?></span>
               <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['id'] == $mensaje['usuario_id']): ?>
                 <!-- Botones pequeños para editar y eliminar mensaje -->
                 <a href="<?php echo $ruta_base; ?>public/editarMensaje.php?id=<?php echo $mensaje['id']; ?>" class="btn-small">Editar</a>
                 <a href="<?php echo $ruta_base; ?>app/controllers/eliminarMensajeController.php?id=<?php echo $mensaje['id']; ?>" class="btn-small">Eliminar</a>
               <?php endif; ?>
            </li>
            <?php endforeach; ?>
         </ul>
         <?php else: ?>
         <p>No hay mensajes en este tema.</p>
         <?php endif; ?>
         
         <?php if (isset($_SESSION['usuario'])): ?>
         <h3>Agregar Mensaje</h3>
         <form action="<?php echo $ruta_base; ?>app/controllers/mensajeController.php" method="POST">
            <input type="hidden" name="tema_id" value="<?php echo $tema_id; ?>">
            <label for="mensaje">Mensaje:</label>
            <textarea name="mensaje" id="mensaje" rows="5" required></textarea>
            <input type="submit" value="Enviar Mensaje">
         </form>
         <?php else: ?>
         <p>Debes <a href="<?php echo $ruta_base; ?>public/login.php">iniciar sesión</a> para agregar mensajes.</p>
         <?php endif; ?>
      </section>
   </main>
   <?php include '../app/views/footer.php'; ?>
</body>
</html>
