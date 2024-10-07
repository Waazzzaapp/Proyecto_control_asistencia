$(document).ready(function() {
    // Hacer click en "Actualizar" para habilitar campos
    $("#btnActualizar").click(function() {
        $("#telefono").removeAttr("readonly");
        $("#email").removeAttr("readonly");
        $("#btnGuardar").removeAttr("disabled");
    });

    // Mostrar y ocultar modal
    $("#btnGuardar").click(function() {
        $("#confirmModal").show();
    });

    $("#btnCancelar").click(function() {
        $("#confirmModal").hide();
    });

    $("#btnAceptarGuardar").click(function() {
        // Crear un formulario y enviar los datos usando POST
        $("<form>", {
            "method": "POST",
            "html": `<input type="hidden" name="telefono" value="${$("#telefono").val()}">
                     <input type="hidden" name="email" value="${$("#email").val()}">
                     <input type="hidden" name="actualizar" value="1">`
        }).appendTo("body").submit();
    });
});
