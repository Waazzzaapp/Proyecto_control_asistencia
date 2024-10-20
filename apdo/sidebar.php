<div class="sidebar">
    <!-- Menú lateral (sidebar) -->
    <div class="container-sidebar" id="sidebar">
        <ul>
            <li>
                <a href="asistencia.php" id="asistencia-link">
                    <img src="images/icono3.png" alt="Icono Asistencia" class="sidebar-icon"> Asistencia
                </a>
            </li>
            <li>
                <a href="masivo.php" id="despacho-link">
                    <img src="images/icono4.png" alt="Icono Despacho" class="sidebar-icon"> Tomar asistencia 
                </a>
            </li>
            <?php if ($rol === 'ADMIN'): ?>
                <li>
                <a href="" id="reportes-toggle">
                <img src="images/icono8.png" alt="Icono Despacho" class="sidebar-icon">
                Reportes
                <img src="images/icono11.png" alt="Icono Despacho" class="sidebar-icon3">
                </a>
                <ul id="submenu-reportes" style="display: none;">
                <li><a href="reportes.php"><img src="images/icono9.png" alt="Icono Despacho" class="sidebar-icon2">Reporte Unificado</a></li>
                <li><a href="reporte_masivo.php"><img src="images/icono10.png" alt="Icono Despacho" class="sidebar-icon2">Reporte Masivo</a></li>
            </ul>
        </li>     
            <?php endif; ?>          
        </ul>
        <!-- Opción de "Cambiar contraseña" al final del sidebar -->
        <ul class="bottom-options">
            <li>
                <a href="cambio_pass.php" id="cambiar-pass-link">
                    <img src="images/icono7.png" alt="Icono Cambiar contraseña" class="sidebar-icon"> Cambiar contraseña
                </a>
            </li>
        </ul>
    </div>
</div>