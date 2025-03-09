<?php
// public/temas.php - Página para listar los temas con sección "Nuestro Foro" y botón para crear nuevo tema
session_start();
$ruta_base = "../";
require_once '../app/controllers/temaController.php';
$controller = new TemaController();

// Obtener el número de página (por defecto 1) y definir cuántos temas se muestran por página.
$pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$por_pagina = 10;
$temas = $controller->listar($pagina, $por_pagina);
$total = $controller->contar();
$total_paginas = ceil($total / $por_pagina);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Temas - Nuestro Foro</title>
  <link rel="stylesheet" href="<?php echo $ruta_base; ?>assets/css/style.css">
</head>
<body>
  <?php include '../app/views/header.php'; ?>
  <main>
    <!-- Sección "Nuestro Foro" con descripción y botón para crear nuevo tema -->
    <section class="nuestro-foro">
      <h2>Nuestro Foro</h2>
      <p>Explora, debate y comparte tus ideas con nuestra comunidad. </br>Aquí encontrarás los temas más recientes y podrás iniciar nuevos debates.</p>
      <br><a href="<?php echo $ruta_base; ?>public/nuevoTema.php" class="btn-gradient">Crear Nuevo Tema</a>
    </section>
    
    <!-- Buscador interno en la página de Temas (opcional, si deseas mantenerlo) -->
    <section class="buscador-temas">
      <form action="<?php echo $ruta_base; ?>public/buscar.php" method="GET">
        <input type="text" name="q" placeholder="Buscar en el foro..." required>
        <button type="submit">Buscar</button>
      </form>
    </section>
    
    <!-- Listado de temas -->
    <?php include '../app/views/temas.php'; ?>
    
    <!-- Paginación -->
    <div class="pagination">
      <?php if($pagina > 1): ?>
         <a href="?page=<?php echo $pagina - 1; ?>">&laquo; Anterior</a>
      <?php endif; ?>
      <?php for($i = 1; $i <= $total_paginas; $i++): ?>
         <?php if($i == $pagina): ?>
            <span><?php echo $i; ?></span>
         <?php else: ?>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
         <?php endif; ?>
      <?php endfor; ?>
      <?php if($pagina < $total_paginas): ?>
         <a href="?page=<?php echo $pagina + 1; ?>">Siguiente &raquo;</a>
      <?php endif; ?>
    </div>
  </main>
  <?php include '../app/views/footer.php'; ?>
</body>
</html>
