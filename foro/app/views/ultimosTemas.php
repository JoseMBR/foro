<?php
// app/views/ultimosTemas.php - Vista para mostrar los últimos 5 temas en tarjetas
?>
<section class="ultimos-temas">
  <h2>Últimos Temas</h2>
  <?php if (!empty($ultimosTemas)): ?>
    <div class="temas-cards">
      <?php foreach ($ultimosTemas as $tema): ?>
        <div class="tema-card">
          <h3>
            <a href="<?php echo isset($ruta_base) ? $ruta_base : ''; ?>public/verTema.php?id=<?php echo $tema['id_tema']; ?>">
              <?php echo htmlspecialchars($tema['titulo']); ?>
            </a>
          </h3>
          <p><?php echo nl2br(htmlspecialchars(substr($tema['descripcion'], 0, 100))) . '...'; ?></p>
          <span class="fecha">Creado el <?php echo $tema['fecha_creacion']; ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p>No hay temas disponibles.</p>
  <?php endif; ?>
  <a href="public/temas.php" class="btn-gradient">Ver todos los temas</a>
</section>
