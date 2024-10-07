document.addEventListener('DOMContentLoaded', function() {
$(document).ready(function() {
    // Guardar asistencia usando AJAX
    $('#guardarAsistenciaBtn').click(function() {
        $.ajax({
            url: 'masivo.php',
            type: 'POST',
            data: $('#asistenciaForm').serialize() + "&guardar_asistencia=1",
            success: function(response) {
                $('#resultado').html("<p style='color: green;'>Asistencia guardada exitosamente.</p>");               
                location.reload();
            },
            error: function() {
                $('#resultado').html("<p style='color: red;'>Hubo un error al guardar la asistencia.</p>");
                location.reload();
            }
        });
        
    });

    // Finalizar usando AJAX
    $('#finalizarBtn').click(function() {
        $.ajax({
            url: 'masivo.php',
            type: 'POST',
            data: $('#asistenciaForm').serialize() + "&finalizar=1",
            success: function(response) {
                $('#resultado').html("<p style='color: green;'>Salida registrada exitosamente.</p>");
                location.reload();
            },
            error: function() {
                $('#resultado').html("<p style='color: red;'>Hubo un error al registrar la salida.</p>");
                location.reload();
            }
        });
        
    });
});
});