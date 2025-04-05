document.addEventListener('DOMContentLoaded', function(event){
    generarMarca(); // Sets up the form listener
    generarTablas(); // Initial load of brands
});

function generarTablas(){
    const container = document.getElementById('container');
    container.className = 'w-full md:max-w-[60%]';
    container.innerHTML = ''; // Clear previous content

    fetch('/api/marcas') // Fetch brands
    .then(response => response.json())
    .then(data => {
        data.forEach(marca => {
            const marcaDiv = document.createElement('div');
            marcaDiv.className = 'w-full bg-zinc-800/50 p-4 mb-2 rounded-lg flex justify-between items-center';

            // Crear input en lugar de span
            const inputMarca = document.createElement('input');
            inputMarca.type = 'text';
            inputMarca.value = marca.nombre; // Use marca.nombre
            inputMarca.className = 'bg-transparent text-gray-300 focus:outline-none w-full mr-2'; // Added margin-right
            // Add aria-label for the input field itself
            inputMarca.setAttribute('aria-label', `Nombre de la marca: ${marca.nombre}`);

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
            editBtn.setAttribute('aria-label', `Guardar cambios para la marca ${marca.nombre}`);
            editBtn.onclick = () => editarMarca(marca.id, inputMarca.value); // Pass current value and call editarMarca

            // Botón de eliminar
            const deleteBtn = document.createElement('button');
            deleteBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            `;
            deleteBtn.className = 'text-gray-400 hover:text-white p-1 transition-colors';
            // Add aria-label for accessibility
            deleteBtn.setAttribute('aria-label', `Eliminar marca ${marca.nombre}`);
            deleteBtn.onclick = () => eliminarMarca(marca.id, container, marcaDiv); // Call eliminarMarca

            // Agregar botones al contenedor
            botonesContainer.appendChild(editBtn);
            botonesContainer.appendChild(deleteBtn);

            marcaDiv.appendChild(inputMarca);
            marcaDiv.appendChild(botonesContainer);

            container.appendChild(marcaDiv);
        });
    })
    .catch(error => console.error('Error al cargar las marcas:', error)); // Updated error message
}

async function editarMarca(id, nuevoNombre) { // Renamed function
    // Basic frontend validation
    if (!validarMarca(nuevoNombre)) { // Use validation function
        alert("El nombre de la marca no puede estar vacío ni contener caracteres especiales no permitidos.");
        return false;
    }

    const url = `/marcas/${id}`; // Use /marcas endpoint
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    const opciones = {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ nombre_marca: nuevoNombre }) // Use 'nombre_marca' key
    };

    try {
        const response = await fetch(url, opciones);
        const data = await response.json();

        if (!response.ok) {
            if (data && data.message) {
                throw new Error(data.message);
            } else if (data && data.errors) {
                 throw new Error(Object.values(data.errors).flat().join(' '));
            }
            throw new Error(`Error al actualizar la marca (Status: ${response.status})`); // Updated error message
        }

        alert('Marca editada correctamente'); // Updated success message
        // Optionally update input visually or rely on refresh
        return data;

    } catch (error) {
        console.error('Error en editarMarca:', error); // Updated function name in log
        alert(`Error al actualizar la marca: ${error.message}`); // Updated error message
        generarTablas(); // Refresh the list on error
    }
}


function eliminarMarca(id, container, div){ // Renamed function
    if(confirm('¿Estás seguro de que deseas eliminar esta marca?')) { // Updated confirmation message
        fetch(`/marcas/${id}`, { // Use /marcas endpoint
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                const errorMessage = errorData.message || `Error ${response.status}`;
                throw new Error(`Error al eliminar la marca: ${errorMessage}`); // Updated error message
            }
            container.removeChild(div);
            alert('Marca eliminada correctamente.'); // Updated success message
        })
        .catch(error => {
            console.error('Error en eliminarMarca:', error); // Updated function name in log
            alert(error.message);
        });
    }
}

function generarMarca() { // Renamed function
    let form = document.getElementById('formulario');
    // Consider adding aria-label="Nombre de la nueva marca" to this input in your HTML
    let input = document.getElementById('generarInput');

    if (!form || !input) {
        console.error("Formulario o input 'generarInput' no encontrado.");
        return;
    }

    form.addEventListener('submit', async function(event){
        event.preventDefault();
        let marcaNombre = input.value.trim(); // Use a distinct variable name

        // Use the validation function
        if (!validarMarca(marcaNombre)) {
            alert("El nombre de la marca no puede estar vacío ni contener caracteres especiales no permitidos.");
            return;
        }

        // Check for duplicates visually
        const marcasExistentes = Array.from(document.querySelectorAll("#container input[type='text']")).map(inp => inp.value.trim().toLowerCase());
        if (marcasExistentes.includes(marcaNombre.toLowerCase())) {
             alert("Esta marca ya existe.");
             return;
        }

        try {
            const response = await fetch('/marcas', { // Use /marcas endpoint
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ nombre_marca: marcaNombre }) // Use 'nombre_marca' key
            });

            const data = await response.json();

            if (!response.ok) {
                if (data && data.errors) {
                    alert(Object.values(data.errors).flat().join('\n'));
                } else if (data && data.message) {
                    alert(data.message);
                } else {
                    alert(`Error al crear la marca (Status: ${response.status}).`); // Updated error message
                }
                return;
            }

            // Success
            input.value = '';
            alert('Marca creada correctamente.'); // Updated success message
            generarTablas(); // Refresh the list

        } catch (error) {
            console.error('Error en generarMarca fetch:', error); // Updated function name in log
            alert("Ocurrió un error inesperado al intentar crear la marca."); // Updated error message
        }
    });
    // Consider adding aria-label="Crear nueva marca" to the submit button in your HTML form
}

// Simple frontend validation function for brands
function validarMarca(nombreMarca) { // Renamed function
    if (!nombreMarca || nombreMarca.trim().length === 0) {
        console.log("Validation failed: Nombre de marca vacío");
        return false;
    }
    // Allows letters (including accented), numbers, spaces, hyphens, underscores, periods, ampersands
    // Adjust regex as needed
    const regex = /^[a-zA-Z0-9áéíóúüÁÉÍÓÚÜñÑ\s\-_.&]+$/;
    const isValid = regex.test(nombreMarca);
    if (!isValid) {
        console.log(`Validation failed for brand name: "${nombreMarca}"`);
    }
    return isValid;
}
