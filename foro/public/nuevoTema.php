<?php
// public/nuevoTema.php - Vista para crear un nuevo tema
session_start();
$ruta_base = "../";
if (!isset($_SESSION['usuario'])) {
    $_SESSION['error'] = "Debes iniciar sesión para crear un tema.";
    header("Location: " . $ruta_base . "public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Nuevo Tema - Foro</title>
   <link rel="stylesheet" href="<?php echo $ruta_base; ?>assets/css/style.css">
</head>
<body>
   <?php include '../app/views/header.php'; ?>
   <main>
      <section class="nuevo-tema">
         <h2>Crear Nuevo Tema</h2>
         <form action="../app/controllers/crearTemaController.php" method="POST">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" required>
            
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="5" required></textarea>
            
            <input type="submit" value="Crear Tema">
         </form>
      </section>
   </main>
   <?php include '../app/views/footer.php'; ?>
</body>
</html>
