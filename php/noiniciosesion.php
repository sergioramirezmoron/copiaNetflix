<?php
// Verificar si el usuario está logueado; si no, redirigir a login.php
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: login.php");
    exit();
}