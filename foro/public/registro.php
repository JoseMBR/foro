<?php
session_start();
$ruta_base = "../";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - Foro</title>
  <link rel="stylesheet" href="<?php echo $ruta_base; ?>assets/css/style.css">
</head>
<body>
  <?php include '../app/views/header.php'; ?>
  <main>
    <!-- Sección Hero para Registro -->
    <section class="hero">
      <div class="hero-content">
        <h2>Regístrate en Nuestro Foro</h2>
        <p>Únete a nuestra comunidad y comparte tus ideas, debates y experiencias.</p>
      </div>
    </section>
    <!-- Formulario de Registro -->
    <section class="registro">
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
      <form action="../app/controllers/registroController.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        
        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" id="correo" required>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>
        
        <input type="submit" value="Registrarse">
      </form>
    </section>
  </main>
  <?php include '../app/views/footer.php'; ?>
</body>
</html>
