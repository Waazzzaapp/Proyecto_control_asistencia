<?php
include 'apdo/config.php'; // Incluir configuración general
include 'apdo/auth.php'; // Incluir verificación de autenticación

// Simular el ID del empleado para pruebas
$id_empleado = $_SESSION['employee_id'];

// Consultar la información del empleado desde la base de datos
$sql = "SELECT * FROM empleados WHERE id_empleado = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_empleado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Obtener los datos del empleado
    $empleado = $result->fetch_assoc();
} else {
    // Si no se encuentra el empleado, mostrar un error
    exit();
}

// Actualizar la información del empleado si se recibe una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar'])) {
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    // Actualizar los datos del empleado en la base de datos
    $sql_update = "UPDATE empleados SET telefono = ?, email = ? WHERE id_empleado = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssi", $telefono, $email, $id_empleado);

    // ejecutar y cerrar la declaración
    $stmt_update->execute();
    $stmt_update->close();

    // Refrescar la página para mostrar los datos actualizados
    header("Refresh:0");
    exit();
}

// Cerrar la declaración de la consulta inicial
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="images/M-User_logo.png" type="image/x-icon">
        <title>Asistencia - M-User</title>
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/sidebar.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/mi_info.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>     
    </head>
    <body>       
        <header>    
            <?php include 'apdo/header.php'; ?>
        </header>
        <?php include 'apdo/sidebar.php'; ?>
        <div class="container-index">

        <!--================ AQUI SE INGRESA CODIGO DE LA PAGINA ================-->  
        
        <div class="info-section">
            <h2>Información Personal</h2>

            <!-- Parte superior con 3 columnas: ID Empleado, Cargo y Estado -->
            <div class="top-info">
                <!-- ID Empleado -->
                <div class="form-group">
                    <label for="idEmpleado" class="form-label">ID Empleado:</label>
                    <input type="text" id="idEmpleado" class="form-control" value="<?php echo htmlspecialchars($empleado['id_empleado']); ?>" readonly maxlength="5">
                </div>

                <!-- Cargo -->
                <div class="form-group">
                    <label for="cargo" class="form-label">Cargo:</label>
                    <input type="text" id="cargo" class="form-control" value="<?php echo htmlspecialchars($empleado['cargo']); ?>" readonly maxlength="20">
                </div>

                <!-- Estado -->
                <div class="form-group">
                    <label for="estado" class="form-label">Estado:</label>
                    <input type="text" id="estado" class="form-control" value="<?php echo htmlspecialchars($empleado['estado']); ?>" readonly maxlength="10">
                </div>
            </div>

            <!-- Parte inferior con 2 columnas -->
            <div class="info-columns">
                <div>
                    <!-- Documento -->
                    <div class="form-group">
                        <label for="documento" class="form-label">Documento:</label>
                        <input type="text" id="documento" class="form-control" value="<?php echo htmlspecialchars($empleado['documento']); ?>" readonly maxlength="15">
                    </div>
                    <!-- Apellido Materno -->
                    <div class="form-group">
                        <label for="apellidoMaterno" class="form-label">Apellido Materno:</label>
                        <input type="text" id="apellidoMaterno" class="form-control" value="<?php echo htmlspecialchars($empleado['apellido_materno']); ?>" readonly maxlength="20">
                    </div>
                    <!-- Teléfono -->
                    <div class="form-group">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="text" id="telefono" class="form-control" value="<?php echo htmlspecialchars($empleado['telefono']); ?>" readonly maxlength="15">
                    </div>
                </div>

                <div>
                    <!-- Apellido Paterno -->
                    <div class="form-group">
                        <label for="apellidoPaterno" class="form-label">Apellido Paterno:</label>
                        <input type="text" id="apellidoPaterno" class="form-control" value="<?php echo htmlspecialchars($empleado['apellido_paterno']); ?>" readonly maxlength="20">
                    </div>
                    <!-- Nombre -->
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" id="nombre" class="form-control" value="<?php echo htmlspecialchars($empleado['nombre']); ?>" readonly maxlength="20">
                    </div>
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email:</label>
                        <input type="text" id="email" class="form-control" value="<?php echo htmlspecialchars($empleado['email']); ?>" readonly maxlength="50">
                    </div>
                </div>
            </div>

            <!-- Botones Actualizar y Guardar -->
            <div class="button-group">
                <button id="btnActualizar" class="button btn-primary">Actualizar</button>
                <button id="btnGuardar" class="button btn-success" disabled>Guardar</button>
            </div>
        </div>

        <!-- Modal de Confirmación -->
        <div id="confirmModal" class="modal">
            <div class="modal-content">
                <h5>Confirmación</h5>
                <p>¿Estás seguro de que deseas guardar los cambios?</p>
                <div class="modal-footer">
                    <button id="btnCancelar" class="button btn-secondary">Cancelar</button>
                    <button id="btnAceptarGuardar" class="button btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
            
        <!--================ AQUI SE INGRESA CODIGO DE LA PAGINA ================--> 
        
        </div>
        <footer class="footer">
            <?php include 'apdo/footer.php'; ?>
        </footer>        
        <!-- Archivos JavaScript -->
        <script src="js/header.js"></script>
        <script src="js/mi_info.js"></script>
    </body>
</html>