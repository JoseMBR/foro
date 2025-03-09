<?php
// app/views/temas.php - Vista para listar temas
// Se asume que la variable $temas está definida por el controlador
?>
<section class="temas">
  <?php if (isset($_SESSION['mensaje'])): ?>
    <p class="exito"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></p>
  <?php endif; ?>
  <?php if (isset($_SESSION['error'])): ?>
    <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
  <?php endif; ?>
  <ul class="lista-temas">
    <?php if (!empty($temas)): ?>
      <?php foreach ($temas as $tema): ?>
        <li>
          <a href="<?php echo isset($ruta_base) ? $ruta_base : ''; ?>public/verTema.php?id=<?php echo $tema['id_tema']; ?>">
            <?php echo htmlspecialchars($tema['titulo']); ?>
          </a>
          <span class="autor">por <?php echo htmlspecialchars($tema['autor']); ?></span>
          <span class="fecha"><?php echo $tema['fecha_creacion']; ?></span>
          <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['id'] == $tema['usuario_id']): ?>
            <a href="<?php echo isset($ruta_base) ? $ruta_base : ''; ?>public/editarTema.php?id=<?php echo $tema['id_tema']; ?>">Editar</a>
            <a href="<?php echo isset($ruta_base) ? $ruta_base : ''; ?>app/controllers/eliminarTemaController.php?id=<?php echo $tema['id_tema']; ?>">Eliminar</a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    <?php else: ?>
      <li>No hay temas disponibles.</li>
    <?php endif; ?>
  </ul>
</section>
