<?php
    // Iniciar o reanudar la sesión
    session_start();
    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';
?>