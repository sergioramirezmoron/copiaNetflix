<?php
include 'php/conexion.php';
include 'php/Header.php';

$error = "";
$exito = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if (empty($usuario) || empty($email) || empty($password) || empty($password2)) {
        $error = "Por favor, complete todos los campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Correo electrónico no válido.";
    } elseif ($password !== $password2) {
        $error = "Las contraseñas no coinciden.";
    } elseif (strlen($password) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE nombre = ? OR email = ?");
        $stmt->bind_param("ss", $usuario, $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "El usuario o correo ya están registrados.";
        } else {
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $usuario, $email, $pass_hash);
            if ($insert->execute()) {
                $exito = "Usuario registrado correctamente. Puedes iniciar sesión.";
            } else {
                $error = "Error al registrar usuario. Intenta de nuevo.";
            }
            $insert->close();
        }
        $stmt->close();
    }
}
?>
<main class="registro-container">
    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($exito): ?>
        <p class="exito"><?php echo htmlspecialchars($exito); ?></p>
    <?php endif; ?>

    <form action="register.php" method="post" novalidate>
        <label for="usuario">Nombre de usuario:</label>
        <input type="text" name="usuario" id="usuario" required value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>">

        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <label for="password2">Repetir contraseña:</label>
        <input type="password" name="password2" id="password2" required>

        <button type="submit">Registrar</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
</main>

</body>
</html>
