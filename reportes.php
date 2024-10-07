<?php
include 'apdo/config.php'; // Incluir configuración general
include 'apdo/auth.php'; // Incluir verificación de autenticación
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
        <link rel="stylesheet" href="css/reportes.css">
    </head>
    <body>       
        <header>    
            <?php include 'apdo/header.php'; ?>
        </header>
        <?php include 'apdo/sidebar.php'; ?>
        <div class="container-index">
        <!--================ AQUI SE INGRESA CODIGO DE LA PAGINA ================-->  

        <form method="POST" action="">
            <!-- Selección de empleado -->
            <label for="empleado">Usuario:</label>
            <select id="empleado" name="empleado">
                <option value="" selected disabled>Seleccione</option> <!-- Opción vacía por defecto -->
                <?php
                    // Consultar la lista de empleados
                    $sql = "SELECT id_empleado, nombre FROM empleados";
                    $result = $conn->query($sql);
                    // Generar opciones del combo box
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_empleado'] . "'>" . $row['nombre'] . "</option>";
                        }
                    }
                ?>
            </select>
            <!-- Selección de rango de fechas -->
            <label for="fecha_inicio">Desde:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio">
            <label for="fecha_fin">Hasta:</label>
            <input type="date" id="fecha_fin" name="fecha_fin">
            <!-- Botón para buscar -->
            <button type="submit" name="buscar">Buscar</button>
        </form>
        <!-- Botón para exportar resultados -->
        <form method="POST" action="apdo/exportar.php" style="margin-top: 10px;">
            <input type="hidden" name="empleado" value="<?php echo isset($_POST['empleado']) ? $_POST['empleado'] : ''; ?>">
            <input type="hidden" name="fecha_inicio" value="<?php echo isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : ''; ?>">
            <input type="hidden" name="fecha_fin" value="<?php echo isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : ''; ?>">
            <button type="submit" name="exportar">Exportar</button>
        </form>
        <div class="container-reportes">
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Inicio Jornada</th>
                        <th>Fin Jornada</th>
                        <th>Inicio Refrigerio</th>
                        <th>Fin Refrigerio</th>
                        <th>Inicio Tópico</th>
                        <th>Fin Tópico</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (isset($_POST['buscar'])) {
                            // Obtener los valores del formulario
                            $id_empleado = $_POST['empleado'];
                            $fecha_inicio = $_POST['fecha_inicio'];
                            $fecha_fin = $_POST['fecha_fin'];
                            // Validar que los campos no estén vacíos
                            if (!empty($id_empleado) && !empty($fecha_inicio) && !empty($fecha_fin)) {
                                // Consulta para obtener las asistencias del empleado en el rango de fechas
                                $sql = "SELECT fecha, inicio_jornada, fin_jornada, inicio_refrigerio, fin_refrigerio, inicio_topico, fin_topico 
                                        FROM asistencia 
                                        WHERE id_empleado = ? AND fecha BETWEEN ? AND ?";
                                // Preparar y ejecutar la consulta
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("iss", $id_empleado, $fecha_inicio, $fecha_fin);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                // Mostrar resultados en la tabla
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>" . $row['fecha'] . "</td>
                                                <td>" . substr($row['inicio_jornada'], 0, 8) . "</td>
                                                <td>" . substr($row['fin_jornada'], 0, 8) . "</td>
                                                <td>" . substr($row['inicio_refrigerio'], 0, 8) . "</td>
                                                <td>" . substr($row['fin_refrigerio'], 0, 8) . "</td>
                                                <td>" . substr($row['inicio_topico'], 0, 8) . "</td>
                                                <td>" . substr($row['fin_topico'], 0, 8) . "</td>
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No se encontraron registros en el rango de fechas seleccionado.</td></tr>";
                                }
                                // Cerrar la conexión
                                $stmt->close();
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        $conn->close();
        ?>
        
        <!--================ AQUI SE INGRESA CODIGO DE LA PAGINA ================--> 
        </div>
        <footer class="footer">
            <?php include 'apdo/footer.php'; ?>
        </footer>        
        <!-- Archivos JavaScript -->
        <script src="js/header.js"></script>
    </body>
</html>