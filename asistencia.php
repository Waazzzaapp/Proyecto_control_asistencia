<?php
include 'apdo/config.php'; // Incluir configuración general
include 'apdo/auth.php'; // Incluir verificación de autenticación



// Definir un ID de empleado estático para pruebas
$id_empleado = $_SESSION['employee_id']; // Cambiar según el ID que desees probar


// Obtener la fecha y la hora actual
$fecha_actual = date('Y-m-d'); // La fecha actual en formato Año-Mes-Día
$hora_actual = date('H:i'); // La hora actual en formato Horas:Minutos

// Consultar la base de datos para ver si ya hay un registro de asistencia para el día actual
$sql = "SELECT * FROM asistencia WHERE id_empleado = ? AND fecha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id_empleado, $fecha_actual);
$stmt->execute();
$result = $stmt->get_result();

$asistencia = $result->fetch_assoc(); // Obtener los datos de asistencia si existen

// Función para mostrar un valor de la base de datos
// Si el valor es nulo o igual a '00:00:00.000000', devolverá una cadena vacía
// Si no, devolverá el valor formateado (HH:mm:ss)
function mostrarValor($valor) {
    if (is_null($valor) || $valor == '00:00:00.000000') {
        return ''; // Si el valor es nulo o igual a '00:00:00.000000', devolver una cadena vacía
    }
    return substr($valor, 0, 8); // Devolver solo los primeros 8 caracteres (HH:mm:ss)
}

// Obtener los valores de la base de datos para cada actividad y mostrarlos formateados
$inicio_jornada = mostrarValor($asistencia['inicio_jornada'] ?? null);
$fin_jornada = mostrarValor($asistencia['fin_jornada'] ?? null);
$inicio_topico = mostrarValor($asistencia['inicio_topico'] ?? null);
$fin_topico = mostrarValor($asistencia['fin_topico'] ?? null);
$inicio_refrigerio = mostrarValor($asistencia['inicio_refrigerio'] ?? null);
$fin_refrigerio = mostrarValor($asistencia['fin_refrigerio'] ?? null);

// Cerrar la consulta de la base de datos
$stmt->close();

// Determinar el estado de cada botón basado en si los campos tienen o no valores
// Si el campo de inicio de una actividad está vacío, el botón "Iniciar" está habilitado
// Si el campo tiene valor, el botón "Iniciar" estará bloqueado
$boton_jornada_iniciar_bloqueado = empty($inicio_jornada) ? '' : 'disabled bloqueado';
$boton_jornada_fin_bloqueado = empty($fin_jornada) ? '' : 'disabled bloqueado';
$boton_topico_iniciar_bloqueado = empty($inicio_topico) ? '' : 'disabled bloqueado';
$boton_topico_fin_bloqueado = empty($fin_topico) ? '' : 'disabled bloqueado';
$boton_refrigerio_iniciar_bloqueado = empty($inicio_refrigerio) ? '' : 'disabled bloqueado';
$boton_refrigerio_fin_bloqueado = empty($fin_refrigerio) ? '' : 'disabled bloqueado';

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
        <link rel="stylesheet" href="css/asistencia.css">
    </head>
    <body>       
        <header>    
            <?php include 'apdo/header.php'; ?>
        </header>
        <?php include 'apdo/sidebar.php'; ?>
        <div class="container-index">

        <!--================ AQUI SE INGRESA CODIGO DE LA PAGINA ================-->  
        <div class="container">
            <!-- Contenedor del contenido principal de asistencia -->
            <h1>Control de asistencia</h1>
            <!-- Tabla para registro de asistencia -->
            <table id="tabla-asistencia">
                <thead>
                    <tr>
                        <th>Actividad</th>
                        <th>Hora de Inicio</th>
                        <th>Hora de Finalización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fila para la actividad "Jornada" -->
                    <tr>
                        <td>Jornada</td>
                        <td id="jornada-hora-inicio"><?php echo $inicio_jornada; ?></td>
                        <td id="jornada-hora-fin"><?php echo $fin_jornada; ?></td>
                        <td>
                            <!-- Botón "Iniciar Jornada" con clases y estado dinámico -->
                            <button id="jornada-inicio" class="btn-toggle iniciar <?php echo $boton_jornada_iniciar_bloqueado; ?>" <?php echo $boton_jornada_iniciar_bloqueado; ?> onclick="marcarAsistencia('inicio_jornada')">Iniciar</button>
                            <!-- Botón "Finalizar Jornada" con clases y estado dinámico -->
                            <button id="jornada-fin" class="btn-toggle finalizar <?php echo $boton_jornada_fin_bloqueado; ?>" <?php echo $boton_jornada_fin_bloqueado; ?> onclick="marcarAsistencia('fin_jornada')">Finalizar</button>
                        </td>
                    </tr>
                    <!-- Fila para la actividad "Tópico" -->
                    <tr>
                        <td>Tópico</td>
                        <td id="topico-hora-inicio"><?php echo $inicio_topico; ?></td>
                        <td id="topico-hora-fin"><?php echo $fin_topico; ?></td>
                        <td>
                            <!-- Botones "Iniciar" y "Finalizar" para la actividad "Tópico" -->
                            <button id="topico-inicio" class="btn-toggle iniciar <?php echo $boton_topico_iniciar_bloqueado; ?>" <?php echo $boton_topico_iniciar_bloqueado; ?> onclick="marcarAsistencia('inicio_topico')">Iniciar</button>
                            <button id="topico-fin" class="btn-toggle finalizar <?php echo $boton_topico_fin_bloqueado; ?>" <?php echo $boton_topico_fin_bloqueado; ?> onclick="marcarAsistencia('fin_topico')">Finalizar</button>
                        </td>
                    </tr>
                    <!-- Fila para la actividad "Refrigerio" -->
                    <tr>
                        <td>Refrigerio</td>
                        <td id="refrigerio-hora-inicio"><?php echo $inicio_refrigerio; ?></td>
                        <td id="refrigerio-hora-fin"><?php echo $fin_refrigerio; ?></td>
                        <td>
                            <!-- Botones "Iniciar" y "Finalizar" para la actividad "Refrigerio" -->
                            <button id="refrigerio-inicio" class="btn-toggle iniciar <?php echo $boton_refrigerio_iniciar_bloqueado; ?>" <?php echo $boton_refrigerio_iniciar_bloqueado; ?> onclick="marcarAsistencia('inicio_refrigerio')">Iniciar</button>
                            <button id="refrigerio-fin" class="btn-toggle finalizar <?php echo $boton_refrigerio_fin_bloqueado; ?>" <?php echo $boton_refrigerio_fin_bloqueado; ?> onclick="marcarAsistencia('fin_refrigerio')">Finalizar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>  
        <!-- Script para manejar el registro de asistencia con AJAX -->
        <?php
            // Lógica para manejar la solicitud POST (registro de asistencia)
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
                $accion = $_POST['accion']; // Obtener la acción (iniciar o finalizar) enviada por AJAX
                $hora_actual = date('H:i:s'); // Obtener la hora actual

                // Insertar o actualizar la entrada de asistencia en la base de datos
                if ($asistencia) {
                    // Actualizar la entrada existente si ya hay un registro de asistencia para el día actual
                    $sql_update = "UPDATE asistencia SET $accion = ? WHERE id_empleado = ? AND fecha = ?";
                    $stmt_update = $conn->prepare($sql_update);
                    $stmt_update->bind_param("sis", $hora_actual, $id_empleado, $fecha_actual);
                    $stmt_update->execute();
                    $stmt_update->close();
                } else {
                    // Insertar una nueva entrada si no hay un registro previo para el día actual
                    $sql_insert = "INSERT INTO asistencia (id_empleado, fecha, $accion) VALUES (?, ?, ?)";
                    $stmt_insert = $conn->prepare($sql_insert);
                    $stmt_insert->bind_param("iss", $id_empleado, $fecha_actual, $hora_actual);
                    $stmt_insert->execute();
                    $stmt_insert->close();
                }
                // Cerrar la conexión a la base de datos
                $conn->close();
                exit; // Terminar el script
                }
        ?>
        <!--================ AQUI SE INGRESA CODIGO DE LA PAGINA ================--> 
       

        <footer class="footer">
            <?php include 'apdo/footer.php'; ?>
        </footer>        
        <!-- Archivos JavaScript -->
        <script src="js/header.js"></script>
        <script src="js/asistencia.js"></script>
    </body>
</html>