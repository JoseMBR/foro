<?php
// app/views/header.php
// Se asume que $ruta_base está definido en la página que lo incluye.
?>
<header>
  <div class="header-container">
    <div class="logo">
      <a href="<?php echo isset($ruta_base) ? $ruta_base : ''; ?>index.php">LOGO</a>
    </div>
    <nav class="main-nav">
      <ul>
        <li><a href="<?php echo isset($ruta_base) ? $ruta_base : ''; ?>index.php">Inicio</a></li>
        <li><a href="<?php echo isset($ruta_base) ? $ruta_base : ''; ?>public/temas.php">Temas</a></li>
        <?php if(isset($_SESSION['usuario'])): ?>
          <li><a href="<?php echo isset($ruta_base) ? $ruta_base : ''; ?>public/perfil.php">Perfil</a></li>
          <li><a href="<?php echo isset($ruta_base) ? $ruta_base : ''; ?>public/logout.php">Cerrar sesión</a></li>
          <li class="user-greeting"><span>Hola, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?></span></li>
        <?php else: ?>
          <li><a href="<?php echo isset($ruta_base) ? $ruta_base : ''; ?>public/registro.php">Registro</a></li>
          <li><a href="<?php echo isset($ruta_base) ? $ruta_base : ''; ?>public/login.php">Login</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>
