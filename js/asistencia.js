// Función para manejar el registro de asistencia mediante AJAX
function marcarAsistencia(accion) {
    const xhttp = new XMLHttpRequest(); // Crear un objeto XMLHttpRequest para enviar la solicitud AJAX
    xhttp.onreadystatechange = function() {
        // Cuando la solicitud esté completa (readyState = 4) y haya tenido éxito (status = 200)
        if (this.readyState == 4 && this.status == 200) {
            location.reload(); // Recargar la página para actualizar la hora y el estado de los botones
        }
    };
    // Configurar la solicitud para enviarla al mismo archivo (prueba.php) con el método POST
    xhttp.open("POST", "asistencia.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("accion=" + accion); // Enviar la acción a realizar (iniciar o finalizar una actividad)
}