<?php
// public/buscar.php - Página para mostrar los resultados de búsqueda de temas
session_start();
$ruta_base = "../";
require_once '../config/db.php';

// Verificar que se haya enviado un término de búsqueda
$q = "";
if(isset($_GET['q']) && !empty(trim($_GET['q']))){
   $q = trim($_GET['q']);
   // Buscar en título y descripción usando LIKE
   $stmt = $pdo->prepare("SELECT * FROM temas WHERE titulo LIKE ? OR descripcion LIKE ? ORDER BY fecha_creacion DESC");
   $searchTerm = "%" . $q . "%";
   $stmt->execute([$searchTerm, $searchTerm]);
   $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
   $resultados = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Buscar Temas - Foro</title>
   <link rel="stylesheet" href="<?php echo $ruta_base; ?>assets/css/style.css">
</head>
<body>
  <?php include '../app/views/header.php'; ?>
  <main>
    <section class="buscar-temas">
      <h2>Resultados de Búsqueda</h2>
      <?php if(!empty($q)): ?>
         <p>Resultados para: <strong><?php echo htmlspecialchars($q); ?></strong></p>
         <?php if(!empty($resultados)): ?>
            <ul class="lista-temas">
            <?php foreach($resultados as $tema): ?>
               <li>
                  <a href="<?php echo $ruta_base; ?>public/verTema.php?id=<?php echo $tema['id_tema']; ?>">
                     <?php echo htmlspecialchars($tema['titulo']); ?>
                  </a>
                  <span>(<?php echo $tema['fecha_creacion']; ?>)</span>
               </li>
            <?php endforeach; ?>
            </ul>
         <?php else: ?>
            <p>No se encontraron temas.</p>
         <?php endif; ?>
      <?php else: ?>
         <p>No se proporcionó término de búsqueda.</p>
      <?php endif; ?>
    </section>
  </main>
  <?php include '../app/views/footer.php'; ?>
</body>
</html>
