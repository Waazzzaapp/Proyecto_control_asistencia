<?php
include 'apdo/config.php'; // Incluir configuración general
include 'apdo/auth.php'; // Incluir verificación de autenticación

$fecha_actual = date('Y-m-d'); // La fecha actual en formato Año-Mes-Día
$hora_actual = date('H:i:s'); // La hora actual en formato Horas:Minutos:Segundos

// Guardar asistencia o finalizar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['guardar_asistencia']) && isset($_POST['asistencia'])) {
        foreach ($_POST['asistencia'] as $id_empleado => $value) {
            // Registrar inicio de jornada
            $sql_inicio = "INSERT INTO asistencia (id_empleado, inicio_jornada, fecha)
                           VALUES ('$id_empleado', '$hora_actual', '$fecha_actual')
                           ON DUPLICATE KEY UPDATE inicio_jornada = '$hora_actual'";
            $conn->query($sql_inicio);
        }
    }

    if (isset($_POST['finalizar']) && isset($_POST['salida_anticipada'])) {
        foreach ($_POST['salida_anticipada'] as $id_empleado => $value) {
            // Registrar salida anticipada (fin_jornada)
            $sql_salida = "UPDATE asistencia SET fin_jornada = '$hora_actual' WHERE id_empleado = '$id_empleado' AND fecha = '$fecha_actual'";
            $conn->query($sql_salida);
        }
    }
}
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
        <link rel="stylesheet" href="css/masivo.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>       
        <header>    
            <?php include 'apdo/header.php'; ?>
        </header>
        <?php include 'apdo/sidebar.php'; ?>
        <div class="container-index">
        <!--================ AQUI SE INGRESA CODIGO DE LA PAGINA ================-->  
        
        
            <h1>Control de asistencia masiva</h1>        
            <form id="asistenciaForm" method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Asistencia</th>
                            <th>Salida Anticipada</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obtener los empleados desde la base de datos
                        $sql = "SELECT id_empleado, nombre, apellido_paterno FROM empleados WHERE cargo IN ('CHOFER-ESTIBADOR', 'AYUDANTE-ESTIBADOR')";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $id_empleado = $row['id_empleado'];

                                // Verificar si ya hay un registro de asistencia para hoy
                                $sql_asistencia = "SELECT * FROM asistencia WHERE id_empleado = '$id_empleado' AND fecha = '$fecha_actual'";
                                $result_asistencia = $conn->query($sql_asistencia);
                                $asistencia_data = $result_asistencia->fetch_assoc();

                                // Determinar si los checkboxes deben estar deshabilitados y marcados
                                $checked_asistencia = '';
                                $disabled_asistencia = '';
                                $checked_salida = '';
                                $disabled_salida = '';

                                if ($asistencia_data) {
                                    if ($asistencia_data['inicio_jornada'] != '00:00:00.000000') {
                                        $checked_asistencia = 'checked';
                                        $disabled_asistencia = 'disabled';
                                    }
                                    if ($asistencia_data['fin_jornada'] != '00:00:00.000000') {
                                        $checked_salida = 'checked';
                                        $disabled_salida = 'disabled';
                                    }
                                }

                                echo "<tr>
                                        <td>{$row['nombre']}</td>
                                        <td>{$row['apellido_paterno']}</td>
                                        <td><input type='checkbox' name='asistencia[$id_empleado]' value='1' $checked_asistencia $disabled_asistencia></td>
                                        <td><input type='checkbox' name='salida_anticipada[$id_empleado]' value='1' $checked_salida $disabled_salida></td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No hay empleados disponibles</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <div class="button-column">
                    <button type="button" id="guardarAsistenciaBtn">Guardar</button>
                    <button type="button" id="finalizarBtn">Actualizar</button>    
                </div>
            </form>
            <!-- /*<div id="resultado"></div> -->
        

        <!--================ AQUI SE INGRESA CODIGO DE LA PAGINA ================--> 
        </div>
        <footer class="footer">
            <?php include 'apdo/footer.php'; ?>
        </footer>        
        <!-- Archivos JavaScript -->
        <script src="js/header.js"></script>
        <script src="js/masivo.js"></script>
    </body>
</html>
<?php
// Cerrar conexión a la base de datos
$conn->close();
?>
