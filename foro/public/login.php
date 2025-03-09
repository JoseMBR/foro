<?php
session_start();
$ruta_base = "../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Foro</title>
  <link rel="stylesheet" href="<?php echo $ruta_base; ?>assets/css/style.css">
</head>
<body>
  <?php include '../app/views/header.php'; ?>
  <main>
    <!-- Sección Hero para Login -->
    <section class="hero">
      <div class="hero-content">
        <h2>Inicia Sesión en Nuestro Foro</h2>
        <p>Accede a tu cuenta y únete a las conversaciones de nuestra comunidad.</p>
      </div>
    </section>
    <!-- Formulario de Login -->
    <section class="login">
      <?php
      if(isset($_SESSION['error_login'])){
          echo '<p class="error">'.$_SESSION['error_login'].'</p>';
          unset($_SESSION['error_login']);
      }
      ?>
      <form action="../app/controllers/loginController.php" method="POST">
        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" id="correo" required>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>
        
        <input type="submit" value="Iniciar Sesión">
      </form>
    </section>
  </main>
  <?php include '../app/views/footer.php'; ?>
</body>
</html>
