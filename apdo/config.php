<?php
    // Configurar la zona horaria correcta (cámbialo según tu región)
    date_default_timezone_set('America/Lima');
    // Conexión a la base de datos
    $servername = "localhost"; // Cambia si tu servidor es diferente
    $username = "root";         // Usuario de MySQL
    $password = "";             // Contraseña (en blanco si estás en localhost)
    $dbname = "bdgap01";        // Nombre de la base de datos
    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
?>


