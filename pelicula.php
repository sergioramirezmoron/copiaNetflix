<?php
session_start();
include 'php/noiniciosesion.php'; // Asegura que el usuario esté logueado
include 'php/Header.php';
include 'php/conexion.php';

// Validar que se envíe el id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<main><p style='padding:2rem; color:#fff;'>Película no encontrada.</p></main>";
    exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM peliculas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "<main><p style='padding:2rem; color:#fff;'>Película no encontrada.</p></main>";
    exit;
}

$pelicula = $result->fetch_assoc();

?>

<main class="pelicula-detalle">
  <section class="portada" style="background-image: url('<?php echo htmlspecialchars($pelicula['imagen']); ?>');">
    <div class="overlay"></div>
    <div class="info-portada">
      <h1><?php echo htmlspecialchars($pelicula['titulo']); ?></h1>
      <p class="categoria"><?php echo htmlspecialchars($pelicula['categoria']); ?> · <?php echo intval($pelicula['año']); ?></p>
      <p class="descripcion"><?php echo htmlspecialchars($pelicula['descripcion']); ?></p>
    </div>
  </section>

  <section class="detalle">
    <h2>Detalles</h2>
    <ul>
      <li><strong>Título:</strong> <?php echo htmlspecialchars($pelicula['titulo']); ?></li>
      <li><strong>Categoría:</strong> <?php echo htmlspecialchars($pelicula['categoria']); ?></li>
      <li><strong>Año:</strong> <?php echo intval($pelicula['año']); ?></li>
    </ul>
  </section>
</main>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
