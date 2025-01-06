
// Función para mostrar el formulario de edición
function mostrarFormulario(id) {
    const form = document.getElementById('edit-form');
    const idInput = document.getElementById('edit-id');
    const nombreInput = document.getElementById('edit-nombre');
    const currentName = document.getElementById(`name-${id}`).textContent;

    idInput.value = id;
    nombreInput.value = currentName;
    form.style.display = 'block';
}

// Función para ocultar el formulario
function ocultarFormulario() {
    document.getElementById('edit-form').style.display = 'none';
}

// Función para procesar la edición
function procesarEdicion(event) {
    event.preventDefault();

    const formData = new FormData(event.target);
    const mensaje = document.getElementById('edit-mensaje');
    const id = formData.get('id');
    const nuevoNombre = formData.get('nombre');

    fetch('editar_ting.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.includes("Exitoso")) {
            mensaje.textContent = "Nombre actualizado con éxito.";
            mensaje.style.color = "green";
            document.getElementById(`name-${id}`).textContent = nuevoNombre;
            setTimeout(() => ocultarFormulario(), 2000);
        } else {
            mensaje.textContent = "Error al actualizar: " + data;
            mensaje.style.color = "red";
        }
    })
    .catch(error => {
        console.error("Error:", error);
        mensaje.textContent = "Hubo un error al procesar la solicitud.";
        mensaje.style.color = "red";
    });
}

// Función para procesar el agregar (sin cambios)
function procesarFormulario(event) {
    event.preventDefault(); // Evitar el envío tradicional del formulario

    const form = event.target;
    const formData = new FormData(form);
    const mensaje = document.getElementById('mensaje');

    fetch('agregar_ting.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) // Leer la respuesta del servidor como texto
    .then(data => {
        mensaje.textContent = data; // Mostrar la respuesta en el mensaje
        if (data.includes("Registro guardado correctamente")) {
            mensaje.style.color = "green";

            // Recargar la página después de 2 segundos
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            mensaje.style.color = "red";
        }
    })
    .catch(error => {
        console.error("Error:", error);
        mensaje.textContent = "Hubo un error al procesar el formulario.";
        mensaje.style.color = "red";
    });

    return false; // Prevenir el envío normal del formulario
}
