<?php
include 'php/config.php';

$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer codificación para que los acentos y caracteres especiales funcionen bien
$conn->set_charset("utf8");
?>
