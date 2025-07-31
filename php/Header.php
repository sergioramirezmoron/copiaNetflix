<?php
session_start();

// Obtengo el nombre del archivo actual, sin ruta
$current_page = basename($_SERVER['PHP_SELF']);

// Defino el título según la página
$titulos = [
  'index.php' => 'Catálogo de Películas',
  'register.php' => 'Registro',
  'login.php' => 'Iniciar Sesión',
  'perfil.php' => 'Perfil de Usuario',
  // puedes añadir más páginas y títulos aquí
];

$titulo_actual = $titulos[$current_page] ?? 'Mi Aplicación'; // título por defecto

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo htmlspecialchars($titulo_actual); ?></title>
  <link rel="stylesheet" href="styles/variables.css" />
  <link rel="stylesheet" href="styles/index.css" />
  <?php if($current_page === 'register.php'): ?>
    <link rel="stylesheet" href="styles/register.css" />
  <?php endif; ?>
  <?php if($current_page === 'login.php'): ?>
    <link rel="stylesheet" href="styles/login.css" />
  <?php endif; ?>
</head>
<body>
<header class="header">
  <h1><?php echo htmlspecialchars($titulo_actual); ?></h1>

  <?php if (isset($_SESSION['usuario_nombre'])): ?>
    <nav class="menu-perfil">
      <a href="perfil.php">Mi Perfil</a>
    </nav>
  <?php endif; ?>
</header>
