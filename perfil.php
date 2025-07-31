<?php
session_start();
include 'php/conexion.php';

// Redirigir si no está logueado
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario_nombre'];
$error = "";
$exito = "";

// Obtener datos actuales del usuario
$stmt = $conn->prepare("SELECT id, nombre, email FROM usuarios WHERE nombre = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->bind_result($id_usuario, $nombre_actual, $email_actual);
$stmt->fetch();
$stmt->close();

// Manejar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    $nombre = trim($_POST['nombre']);
    if (empty($nombre)) {
        $error = "El nombre no puede estar vacío.";
    } else {
        // Actualizar solo el nombre
        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ? WHERE id = ?");
        $stmt->bind_param("si", $nombre, $id_usuario);
        if ($stmt->execute()) {
            $exito = "Datos actualizados correctamente.";
            $_SESSION['usuario_nombre'] = $nombre;
            $nombre_actual = $nombre;
            $usuario = $nombre;
        } else {
            $error = "Error al actualizar datos, intenta de nuevo.";
        }
        $stmt->close();
    }
}

// Cerrar sesión
if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

include 'php/Header.php';
?>

<main class="perfil-container">

  <nav class="perfil-menu">
    <ul>
      <li class="activo">Información Personal</li>
      <li>Planes y Suscripciones</li>
      <li>Historial de Visionado</li>
      <li>Configuración de Pago</li>
      <li>Control Parental</li>
      <li>Idiomas y Subtítulos</li>
      <li>Configuración de Cuenta</li>
      <li>Dispositivos Conectados</li>
      <li>Preferencias de Reproducción</li>
      <li>Soporte y Ayuda</li>
    </ul>
  </nav>

  <section class="perfil-info">
    <?php if ($error): ?>
      <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($exito): ?>
      <p class="exito"><?php echo htmlspecialchars($exito); ?></p>
    <?php endif; ?>

    <form action="perfil.php" method="post" novalidate>
      <label for="nombre">Nombre:</label>
      <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($nombre_actual); ?>">

      <label for="email">Correo electrónico (no editable):</label>
      <input type="email" id="email" name="email" readonly value="<?php echo htmlspecialchars($email_actual); ?>">

      <button type="submit" name="guardar">Guardar Cambios</button>
    </form>

    <form method="post" class="cerrar-sesion-form">
      <button type="submit" name="cerrar_sesion" class="btn-cerrar-sesion">Cerrar Sesión</button>
    </form>
  </section>
</main>

</body>
</html>

<?php $conn->close(); ?>

<?php
include 'php/Footer.php';
?>
