<?php
include 'apdo/config.php'; // Incluir configuración general
session_start(); // Iniciar la sesión si no está gestionada por otro archivo

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['dni']; // Cambio de 'dni' a 'username'
    $contraseña = $_POST['clave']; // Cambio de 'clave' a 'password'

    // Preparar la consulta para buscar el usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar si la contraseña es correcta (sin cifrado por ahora)
        if ($contraseña === $row['password']) {
            // Iniciar sesión
            $_SESSION['user_id'] = $row['id_usuario']; // Guardar el ID del usuario en la sesión
            $_SESSION['rol'] = $row['rol']; // Guardar el rol en la sesión
            $_SESSION['employee_id'] = $row['id_empleado']; // Guardar el ID del empleado en la sesión
            header("Location: index.php"); // Redirigir a la página de asistencia
            exit;
        } else {
            $error = "La contraseña no es correcta.";
        }
    } else {
        $error = "El usuario no existe.";
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/M-User_logo.png" type="image/x-icon">
    <title>Asistencia - M-User</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/footer.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
</head>

<body>
    <div class="container-login">
        <!-- Formulario de Login -->
        <div class="form-container">
            <div class="logo-header">
                <img src="images/logo2.png" alt="Logo GAP" class="logo">
            </div>
            <form action="login.php" method="POST">
                <div class="input-container">
                    <i class="fas fa-user"></i> <!-- Icono de persona -->
                    <input type="text" id="dni" name="dni" placeholder="usuario" required>
                </div>
                <div class="input-container">
                    <i class="fas fa-lock"></i> <!-- Icono de candado -->
                    <input type="password" id="clave" name="clave" placeholder="contraseña" required>
                </div>         
                <button type="submit">Ingresar</button>                
            </form>

            <!-- Enlace para "Olvidaste tu contraseña?" -->
            <p style="text-align: left; font-size: 12px;">
                <a href="#" onclick="mostrarPopUp()" style="color: blue;">Olvidaste tu contraseña?</a>
            </p>

            <?php
            // Mostrar el mensaje de error si existe
            if (isset($error)) {
                echo "<p style='color:red;'>$error</p>";
            }
            ?>
        </div>
    </div>

    <!-- Pop-up modal para contraseña olvidada -->
    <div id="popup" class="modal">
        <div class="modal-content">
            <p>Comunicarse con el administrador de sistema</p>
            <button onclick="cerrarPopUp()">Cerrar</button>
        </div>
    </div>

    <!-- Incluir el archivo JavaScript externo -->
    <script src="js/login.js"></script>

    <!-- Incluir el pie de página -->
    <footer class="footer">
            <?php include 'apdo/footer.php'; ?>
    </footer>
</body>
</html>
