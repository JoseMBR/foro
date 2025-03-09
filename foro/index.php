<?php
session_start();
$ruta_base = ""; // En la raíz, la ruta base es ""
require_once 'config/db.php';
require_once 'app/controllers/temaController.php';

$controller = new TemaController();
$ultimosTemas = $controller->listar(1, 5); // Obtiene los últimos 5 temas
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Foro - Inicio</title>
  <link rel="stylesheet" href="<?php echo $ruta_base; ?>assets/css/style.css">
</head>
<body>
  <?php include 'app/views/header.php'; ?>
  <main>
    <!-- Sección Hero -->
    <section class="hero">
      <div class="hero-content">
        <h2>Bienvenido a Nuestro Foro</h2>
        <p>Comparte, debate y descubre temas interesantes. Únete a nuestra comunidad y expresa tus opiniones.</p>
        <a href="public/temas.php" class="btn">Explorar Temas</a>
      </div>
    </section>
    
    <!-- Recuadro con los últimos 5 temas en formato de tarjetas -->
    <?php include 'app/views/ultimosTemas.php'; ?>
  </main>
  <?php include 'app/views/footer.php'; ?>
</body>
</html>
