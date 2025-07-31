<?php

include 'php/noiniciosesion.php';
include 'php/Header.php';
include 'php/conexion.php';

// Obtener todas las películas
$sql = "SELECT * FROM peliculas";
$result = $conn->query($sql);
?>
  <main class="galeria">
    <?php while ($pelicula = $result->fetch_assoc()): ?>
      <div class="pelicula">
        <img
          src="<?php echo htmlspecialchars($pelicula['imagen']); ?>"
          alt="Portada de <?php echo htmlspecialchars($pelicula['titulo']); ?>"
          loading="lazy"
        >
        <div class="info">
          <h2><?php echo htmlspecialchars($pelicula['titulo']); ?></h2>
          <p class="categoria"><?php echo htmlspecialchars($pelicula['categoria']); ?> · <?php echo intval($pelicula['año']); ?></p>
          <p class="descripcion"><?php echo htmlspecialchars($pelicula['descripcion']); ?></p>
        </div>
      </div>
    <?php endwhile; ?>
  </main>
</body>
</html>

<?php
$conn->close();
?>
