<?php
// public/editarTema.php - Vista para editar un tema existente
session_start();
$ruta_base = "../";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Tema no especificado.";
    header("Location: " . $ruta_base . "public/temas.php");
    exit;
}

$tema_id = $_GET['id'];

require_once '../config/db.php';
$stmt = $pdo->prepare("SELECT * FROM temas WHERE id_tema = ?");
$stmt->execute([$tema_id]);
$tema = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tema) {
    $_SESSION['error'] = "Tema no encontrado.";
    header("Location: " . $ruta_base . "public/temas.php");
    exit;
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id'] != $tema['usuario_id']) {
    $_SESSION['error'] = "No tienes permiso para editar este tema.";
    header("Location: " . $ruta_base . "public/temas.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Tema - Foro</title>
  <link rel="stylesheet" href="<?php echo $ruta_base; ?>assets/css/style.css">
</head>
<body>
  <?php include '../app/views/header.php'; ?>
  <main>
    <!-- Sección Hero para Editar Tema -->
    <section class="hero">
      <div class="hero-content">
        <h2>Edita tu tema</h2>
        <p>Actualiza el título y la descripción de tu tema.</p>
      </div>
    </section>
    
    <!-- Formulario para editar el tema -->
    <section class="editar-tema">
      <?php
      if (isset($_SESSION['error'])) {
          echo '<p class="error">' . $_SESSION['error'] . '</p>';
          unset($_SESSION['error']);
      }
      if (isset($_SESSION['mensaje'])) {
          echo '<p class="exito">' . $_SESSION['mensaje'] . '</p>';
          unset($_SESSION['mensaje']);
      }
      ?>
      <form action="<?php echo $ruta_base; ?>app/controllers/editarTemaController.php" method="POST">
        <input type="hidden" name="id_tema" value="<?php echo $tema['id_tema']; ?>">
        
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" required value="<?php echo htmlspecialchars($tema['titulo']); ?>">
        
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="5" required><?php echo htmlspecialchars($tema['descripcion']); ?></textarea>
        
        <input type="submit" value="Actualizar Tema">
      </form>
    </section>
  </main>
  <?php include '../app/views/footer.php'; ?>
</body>
</html>
