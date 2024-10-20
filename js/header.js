document.addEventListener('DOMContentLoaded', function() {
    // Script para mostrar y ocultar el menú lateral (sidebar)
    const menuBtn = document.getElementById('menu-btn');
    const sidebar = document.getElementById('sidebar');

    if (menuBtn && sidebar) {
        menuBtn.addEventListener('click', function() {
            sidebar.classList.toggle('hidden'); // Agrega o quita la clase 'active'
        });
    }
        // Script para mostrar y ocultar el menú desplegable del usuario
        const userMenuIcon = document.getElementById('user-menu-icon');
        const dropdownMenu = document.getElementById('dropdown-menu');
    
    if (userMenuIcon && dropdownMenu) {
        userMenuIcon.addEventListener('click', function(event) {
            dropdownMenu.classList.toggle('show');
            event.stopPropagation(); // Evitar que el clic se propague al documento
        });

        // Cerrar el menú desplegable al hacer clic fuera de él
        document.addEventListener('click', function(event) {
            if (!dropdownMenu.contains(event.target) && !userMenuIcon.contains(event.target)) {
                dropdownMenu.classList.remove('show'); // Ocultar el menú
            }
        });
    }
    const reportesToggle = document.getElementById('reportes-toggle');
    const submenuReportes = document.getElementById('submenu-reportes');

    if (reportesToggle && submenuReportes) {
        reportesToggle.addEventListener('click', function(event) {
            event.preventDefault();
            if (submenuReportes.style.display === "none") {
                submenuReportes.style.display = "block"; // Mostrar submenú
            } else {
                submenuReportes.style.display = "none"; // Ocultar submenú
            }
        });
    }

});