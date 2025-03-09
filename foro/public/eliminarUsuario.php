<?php
// public/eliminarUsuario.php - Vista para confirmar la eliminación del usuario
session_start();
$ruta_base = "../";
if (!isset($_SESSION['usuario'])) {
    $_SESSION['error'] = "Debes iniciar sesión para acceder a esta opción.";
    header("Location: " . $ruta_base . "public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Eliminar Usuario - Foro</title>
   <link rel="stylesheet" href="<?php echo $ruta_base; ?>assets/css/style.css">
</head>
<body>
   <?php include '../app/views/header.php'; ?>
   <main>
      <section class="eliminar-usuario">
         <h2>Eliminar Cuenta</h2>
         <p>¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.</p>
         <form action="../app/controllers/eliminarUsuarioController.php" method="POST">
            <input type="submit" value="Eliminar mi cuenta">
         </form>
         <a href="<?php echo $ruta_base; ?>public/perfil.php" class="btn">Cancelar</a>
      </section>
   </main>
   <?php include '../app/views/footer.php'; ?>
</body>
</html>
