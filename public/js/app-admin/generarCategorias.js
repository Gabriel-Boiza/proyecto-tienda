document.addEventListener('DOMContentLoaded', function(event){
    const container = document.getElementById('container');
    generarCategoria(); // Sets up the form listener
    generarTablas(); // Initial load of categories
});

function generarTablas(){
    const container = document.getElementById('container');
    container.className = 'w-full md:max-w-[60%]';
    container.innerHTML = ''; // Clear previous content

    fetch('/api/categorias')
    .then(response => response.json())
    .then(data => {
        data.forEach(categoria => {
            const categoriaDiv = document.createElement('div');
            categoriaDiv.className = 'w-full bg-zinc-800/50 p-4 mb-2 rounded-lg flex justify-between items-center';

            // Crear input en lugar de span
            const inputCategoria = document.createElement('input');
            inputCategoria.type = 'text';
            inputCategoria.value = categoria.nombre_categoria;
            inputCategoria.className = 'bg-transparent text-gray-300 focus:outline-none w-full mr-2'; // Added margin-right
            // Add aria-label for the input field itself
            inputCategoria.setAttribute('aria-label', `Nombre de la categoría: ${categoria.nombre_categoria}`);

            // Contenedor para los botones
            const botonesContainer = document.createElement('div');
            botonesContainer.className = 'flex gap-2 flex-shrink-0'; // Prevent shrinking

            // Botón de editar
            const editBtn = document.createElement('button');
            editBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
            `;
            editBtn.className = 'text-gray-400 hover:text-white p-1 transition-colors';
            // Add aria-label for accessibility
            editBtn.setAttribute('aria-label', `Guardar cambios para la categoría ${categoria.nombre_categoria}`);
            editBtn.onclick = () => editarCategoria(categoria.id, inputCategoria.value); // Pass current value

            // Botón de eliminar
            const deleteBtn = document.createElement('button');
            deleteBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            `;
            deleteBtn.className = 'text-gray-400 hover:text-white p-1 transition-colors';
            // Add aria-label for accessibility
            deleteBtn.setAttribute('aria-label', `Eliminar categoría ${categoria.nombre_categoria}`);
            deleteBtn.onclick = () => eliminarCategoria(categoria.id, container, categoriaDiv);

            // Agregar botones al contenedor
            botonesContainer.appendChild(editBtn);
            botonesContainer.appendChild(deleteBtn);

            categoriaDiv.appendChild(inputCategoria);
            categoriaDiv.appendChild(botonesContainer);

            container.appendChild(categoriaDiv);
        });
    })
    .catch(error => console.error('Error al cargar las categorias:', error));
}

async function editarCategoria(id, nuevoNombre) {
    // Basic frontend validation (can be enhanced)
    if (!validarCategoria(nuevoNombre)) {
        alert("El nombre de la categoría no puede estar vacío ni contener caracteres especiales no permitidos.");
        return false; // Stop execution if validation fails
    }

    const url = `/categorias/${id}`; // Ensure leading slash for correct path
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    const opciones = {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json' // Good practice to specify accept header
        },
        body: JSON.stringify({ categoria: nuevoNombre })
    };

    try {
        const response = await fetch(url, opciones);
        const data = await response.json(); // Try to parse JSON regardless of status

        if (!response.ok) {
            // Handle specific errors from backend if available
            if (data && data.message) {
                throw new Error(data.message);
            } else if (data && data.errors) {
                 throw new Error(Object.values(data.errors).flat().join(' '));
            }
            throw new Error(`Error al actualizar la categoría (Status: ${response.status})`);
        }

        alert('Categoría editada correctamente');
        // Optionally, update the input field visually if needed, though a full refresh might be simpler
        // Example: Find the input associated with this ID and update its value if necessary
        return data;

    } catch (error) {
        console.error('Error en editarCategoria:', error);
        alert(`Error al actualizar la categoría: ${error.message}`);
        // Optionally revert the input field value if the update failed
        generarTablas(); // Refresh the list to show the original state
    }
}


function eliminarCategoria(id, container, div){
    if(confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
        fetch(`/categorias/${id}`, { // Ensure leading slash
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(async response => { // Use async to await json parsing
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({})); // Attempt to get error details
                const errorMessage = errorData.message || `Error ${response.status}`;
                throw new Error(`Error al eliminar la categoría: ${errorMessage}`);
            }
            // If response is ok, remove the element from the DOM
            container.removeChild(div);
            alert('Categoría eliminada correctamente.'); // Optional success message
        })
        .catch(error => {
            console.error('Error en eliminarCategoria:', error);
            alert(error.message); // Show specific error message to user
        });
    }
}

function generarCategoria() {
    let form = document.getElementById('formulario');
    // Consider adding aria-label="Nombre de la nueva categoría" to this input in your HTML
    let input = document.getElementById('generarInput');
    let container = document.getElementById('container'); // Not used directly here, but good to have reference

    if (!form || !input) {
        console.error("Formulario o input 'generarInput' no encontrado.");
        return;
    }

    form.addEventListener('submit', async function(event){
        event.preventDefault(); // Prevent default form submission
        let categoria = input.value.trim();

        // Use the validation function
        if (!validarCategoria(categoria)) {
            alert("El nombre de la categoría no puede estar vacío ni contener caracteres especiales no permitidos.");
            return;
        }

        // Check for duplicates visually before sending (optional but good UX)
        const categoriasExistentes = Array.from(document.querySelectorAll("#container input[type='text']")).map(inp => inp.value.trim().toLowerCase());
        if (categoriasExistentes.includes(categoria.toLowerCase())) {
             alert("Esta categoría ya existe.");
             return;
        }


        try {
            const response = await fetch('/categorias', { // Ensure leading slash
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ categoria: categoria })
            });

            const data = await response.json();

            if (!response.ok) {
                if (data && data.errors) {
                    // Display validation errors from the backend
                    alert(Object.values(data.errors).flat().join('\n'));
                } else if (data && data.message) {
                    alert(data.message); // Display general error message from backend
                }
                 else {
                    alert(`Error al crear la categoría (Status: ${response.status}).`);
                }
                return; // Stop if there was an error
            }

            // Success
            input.value = ''; // Clear the input field
            alert('Categoría creada correctamente.'); // Optional success message
            generarTablas(); // Refresh the list to include the new category

        } catch (error) {
            console.error('Error en generarCategoria fetch:', error);
            alert("Ocurrió un error inesperado al intentar crear la categoría.");
        }
    });

    // Consider adding aria-label="Crear nueva categoría" to the submit button in your HTML form
}

// Simple frontend validation function
function validarCategoria(categoria) {
    if (!categoria || categoria.trim().length === 0) {
        console.log("Validation failed: Categoria vacía");
        return false; // Cannot be empty or just whitespace
    }
    // Allows letters (including accented), numbers, spaces, hyphens, underscores
    // Adjust regex as needed for your specific requirements
    const regex = /^[a-zA-Z0-9áéíóúüÁÉÍÓÚÜñÑ\s\-_]+$/;
    const isValid = regex.test(categoria);
    if (!isValid) {
        console.log(`Validation failed for: "${categoria}"`);
    }
    return isValid;
}