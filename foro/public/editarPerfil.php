<?php
// public/editarPerfil.php - Vista para editar el perfil del usuario con introducción
session_start();
$ruta_base = "../";
if (!isset($_SESSION['usuario'])) {
    $_SESSION['error'] = "Debes iniciar sesión para editar tu perfil.";
    header("Location: " . $ruta_base . "public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Perfil - Foro</title>
  <link rel="stylesheet" href="<?php echo $ruta_base; ?>assets/css/style.css">
</head>
<body>
  <?php include '../app/views/header.php'; ?>
  <main>
    <!-- Sección Hero para Editar Perfil -->
    <section class="hero">
      <div class="hero-content">
        <h2>Edita tu perfil del foro</h2>
        <p>Actualiza tus datos personales y cambia tu contraseña si lo deseas.</p>
      </div>
    </section>
    
    <!-- Formulario de Edición de Perfil -->
    <section class="editar-perfil">
      <?php
      if(isset($_SESSION['error'])){
          echo '<p class="error">'.$_SESSION['error'].'</p>';
          unset($_SESSION['error']);
      }
      if(isset($_SESSION['mensaje'])){
          echo '<p class="exito">'.$_SESSION['mensaje'].'</p>';
          unset($_SESSION['mensaje']);
      }
      ?>
      <form action="../app/controllers/editarPerfilController.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required value="<?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?>">
        
        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" id="correo" required value="<?php echo htmlspecialchars($_SESSION['usuario']['correo']); ?>">
        
        <h3>Cambiar Contraseña</h3>
        <label for="actual_contrasena">Contraseña Actual:</label>
        <input type="password" name="actual_contrasena" id="actual_contrasena">
        
        <label for="nueva_contrasena">Nueva Contraseña:</label>
        <input type="password" name="nueva_contrasena" id="nueva_contrasena">
        
        <label for="confirmar_nueva_contrasena">Confirmar Nueva Contraseña:</label>
        <input type="password" name="confirmar_nueva_contrasena" id="confirmar_nueva_contrasena">
        
        <input type="submit" value="Actualizar Perfil">
      </form>
    </section>
  </main>
  <?php include '../app/views/footer.php'; ?>
</body>
</html>
