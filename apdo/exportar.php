<?php
include 'config.php'; // Incluir configuración general
include 'auth.php'; // Incluir verificación de autenticación

// Limpiar el buffer de salida antes de enviar el archivo CSV
if (ob_get_contents()) {
    ob_clean();
}

// Obtener los valores del formulario
$id_empleado = $_POST['empleado'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

// Definir nombre de archivo y cabeceras
$filename = "asistencia_export_" . date('Ymd') . ".csv";
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// Abrir el archivo de salida en memoria
$output = fopen("php://output", "w");

// Escribir encabezados de las columnas
fputcsv($output, array('Fecha', 'Inicio Jornada', 'Fin Jornada', 'Inicio Refrigerio', 'Fin Refrigerio', 'Inicio Topico', 'Fin Topico'));

// Consulta para obtener las asistencias del empleado en el rango de fechas
$sql = "SELECT fecha, inicio_jornada, fin_jornada, inicio_refrigerio, fin_refrigerio, inicio_topico, fin_topico 
        FROM asistencia 
        WHERE id_empleado = ? AND fecha BETWEEN ? AND ?";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $id_empleado, $fecha_inicio, $fecha_fin);
$stmt->execute();
$result = $stmt->get_result();

// Escribir cada fila de datos en el archivo CSV
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>