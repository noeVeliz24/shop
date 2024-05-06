document.addEventListener('DOMContentLoaded', function() {
    // Cargar datos al cargar la página
    cargarDatos();

    // Obtener referencia a la tabla
    var tabla = document.getElementById("tabla-articulos");

    // Función para eliminar un artículo
    function eliminarArticulo(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este artículo?")) {
            // Aquí puedes realizar una solicitud AJAX para eliminar el artículo con el ID especificado
            // Por ejemplo, podrías usar fetch() o XMLHttpRequest para enviar una solicitud DELETE al servidor
            console.log("Eliminar artículo con ID: " + id);
        }
    }

    // Agregar evento click a todos los botones de eliminar
    var botonesEliminar = tabla.querySelectorAll(".eliminar");
    botonesEliminar.forEach(function(boton) {
        boton.addEventListener("click", function() {
            var id = this.dataset.id;
            eliminarArticulo(id);
        });
    });

    // Función para mostrar el formulario de creación de un nuevo artículo
    function mostrarFormulario() {
        var formulario = document.getElementById("formulario");
        formulario.style.display = "block";
    }

    // Obtener referencia al botón de agregar artículo
    var btnAgregar = document.getElementById("btn-agregar");

    // Agregar evento click al botón de agregar artículo
    btnAgregar.addEventListener("click", function() {
        console.log("Botón de agregar clickeado");
        mostrarFormulario();
    });
    
});
