<?php
// public/perfil.php - Vista del Perfil del Usuario con introducción
session_start();
$ruta_base = "../";
if (!isset($_SESSION['usuario'])) {
    $_SESSION['error'] = "Debes iniciar sesión para ver tu perfil.";
    header("Location: " . $ruta_base . "public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil - Foro</title>
  <link rel="stylesheet" href="<?php echo $ruta_base; ?>assets/css/style.css">
</head>
<body>
  <?php include '../app/views/header.php'; ?>
  <main>
    <!-- Sección Hero para el Perfil -->
    <section class="hero">
      <div class="hero-content">
        <h2>Este es tu perfil del foro</h2>
        <p>Aquí puedes ver tus datos personales y revisar tu actividad en la comunidad.</p>
      </div>
    </section>
    
    <!-- Card de Perfil -->
    <section class="perfil">
      <div class="perfil-card">
        <h2>Mi Perfil</h2>
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo '<p class="exito">' . $_SESSION['mensaje'] . '</p>';
            unset($_SESSION['mensaje']);
        }
        if (isset($_SESSION['error'])) {
            echo '<p class="error">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        ?>
        <div class="perfil-datos">
          <p><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?></p>
          <p><strong>Correo:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['correo']); ?></p>
          <p><strong>Rol:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['rol']); ?></p>
          <p><strong>Fecha de Registro:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['fecha_registro']); ?></p>
        </div>
        <div class="perfil-acciones">
          <a href="<?php echo $ruta_base; ?>public/editarPerfil.php" class="btn-gradient">Editar Perfil</a>
        </div>
      </div>
    </section>
  </main>
  <?php include '../app/views/footer.php'; ?>
</body>
</html>
