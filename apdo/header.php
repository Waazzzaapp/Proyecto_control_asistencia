<?php
$id_empleado = $_SESSION['employee_id'];
// Verificar si hay un usuario logueado
if (isset($_SESSION['employee_id'])) {
    $id_empleado = $_SESSION['employee_id'];

    // Realizar la consulta para obtener el nombre del empleado
    $sql = "SELECT nombre FROM empleados WHERE id_empleado = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_empleado);
    $stmt->execute();
    $result = $stmt->get_result();

    // Obtener el nombre del empleado
    if ($row = $result->fetch_assoc()) {
        $nombre_usuario = $row['nombre'];
    } else {
        $nombre_usuario = "Usuario";
    }

    $stmt->close();
} else {
    $nombre_usuario = "Invitado";
}
?>

<!-- Header con el logo y el ícono del usuario -->
<div class="menu-logo">
    <img id="menu-btn" src="images/icono1.png" alt="Menú" class="menu-icon">
    <img src="images/logo2_1.png" alt="Logo GAP" class="logo">
</div>

<!-- Header con el saludo y menu usuario -->
<div class="menu-logo2">    
<div id="user-info">Hola, <?php echo htmlspecialchars($nombre_usuario); ?></div>
    <div class="dropdown">
        <img src="images/icono2.png" class="menu-icon2" id="user-menu-icon">
        <div id="dropdown-menu" class="dropdown-content">
            <a href="mi_info.php" id="mi-info-link">
                <img src="images/icono5.png" alt="Icono Mi info" class="dropdown-icon"> Mi info
            </a>
            <a href="apdo/logout.php">
                <img src="images/icono6.png" alt="Icono Cerrar sesión" class="dropdown-icon"> Cerrar sesión
            </a>
        </div>
    </div>
</div>
