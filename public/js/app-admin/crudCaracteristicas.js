document.addEventListener('DOMContentLoaded', function(event){
    console.log("dsfa");

    generarcaracteristica();
    generarTablas();
});

async function peticionFetch(url, metodo, body) { //funcion para generalizar consultas fetch
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const opciones = {
        method: metodo,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
        },
    };

    if (body) {
        opciones.body = JSON.stringify(body);
    }

    const response = await fetch(url, opciones);

    if (!response.ok) {throw new Error(`Error en la petición`)}

    const data = await response.json();

    return data;
}

// Función para crear un elemento de característica
function crearElementoCaracteristica(caracteristica) {
    const caracteristicaDiv = document.createElement('div');
    caracteristicaDiv.className = 'w-full bg-zinc-800/50 p-4 mb-2 rounded-lg flex justify-between items-center';
    caracteristicaDiv.id = `caracteristica-${caracteristica.id}`;

    const inputCaracteristica = document.createElement('input');
    inputCaracteristica.type = 'text';
    inputCaracteristica.value = caracteristica.nombre;
    inputCaracteristica.className = 'bg-transparent text-gray-300 focus:outline-none w-full';
    // Add aria-label for the input field
    inputCaracteristica.setAttribute('aria-label', `Nombre de la característica: ${caracteristica.nombre}`);

    const botonesContainer = document.createElement('div');
    botonesContainer.className = 'flex gap-2';

    const editBtn = document.createElement('button');
    editBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" aria-hidden="true"> {{-- Added aria-hidden --}}
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
        </svg>
    `;
    editBtn.className = 'text-gray-400 hover:text-white p-1 transition-colors';
    // Add aria-label for the edit/save button
    editBtn.setAttribute('aria-label', `Guardar cambios para la característica ${caracteristica.nombre}`);
    editBtn.onclick = () => editarcaracteristica(caracteristica.id, inputCaracteristica.value);

    const deleteBtn = document.createElement('button');
    deleteBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" aria-hidden="true"> {{-- Added aria-hidden --}}
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
        </svg>
    `;
    deleteBtn.className = 'text-gray-400 hover:text-white p-1 transition-colors';
    // Add aria-label for the delete button
    deleteBtn.setAttribute('aria-label', `Eliminar característica ${caracteristica.nombre}`);
    deleteBtn.onclick = () => eliminarcaracteristica(caracteristica.id);

    botonesContainer.appendChild(editBtn);
    botonesContainer.appendChild(deleteBtn);

    caracteristicaDiv.appendChild(inputCaracteristica);
    caracteristicaDiv.appendChild(botonesContainer);

    return caracteristicaDiv;
}

async function generarTablas(){
    const container = document.getElementById('container');
    container.className = 'w-full md:max-w-[60%]';
    container.innerHTML = '';

    try {
        const data = await peticionFetch('/api/caracteristica', 'GET');
        console.log(data);

        data.caracteristicas.forEach(caracteristica => {
            const caracteristicaDiv = crearElementoCaracteristica(caracteristica);
            container.appendChild(caracteristicaDiv);
        });
    } catch (error) {
        console.error('Error al cargar las caracteristicas:', error);
    }
}

async function editarcaracteristica(id, nuevoNombre) {


    try {
        const data = await peticionFetch(`caracteristicas/${id}`, 'PUT', { caracteristica: nuevoNombre });

        // En lugar de refrescar toda la tabla, actualizamos solo el elemento modificado
        const elementoCaracteristica = document.getElementById(`caracteristica-${id}`);
        if (elementoCaracteristica) {
            const inputCaracteristica = elementoCaracteristica.querySelector('input');
            inputCaracteristica.value = nuevoNombre;
            // Update aria-labels that depend on the name
            inputCaracteristica.setAttribute('aria-label', `Nombre de la característica: ${nuevoNombre}`);
            const editBtn = elementoCaracteristica.querySelector('button[aria-label^="Guardar"]');
            const deleteBtn = elementoCaracteristica.querySelector('button[aria-label^="Eliminar"]');
            if (editBtn) editBtn.setAttribute('aria-label', `Guardar cambios para la característica ${nuevoNombre}`);
            if (deleteBtn) deleteBtn.setAttribute('aria-label', `Eliminar característica ${nuevoNombre}`);
        }

        // Mostrar alerta de éxito
        alert('Característica actualizada con éxito');

        return data;
    } catch (error) {
        alert('Error al actualizar la caracteristica');
    }
}

async function eliminarcaracteristica(id){
    if(confirm('¿Estás seguro de que deseas eliminar esta caracteristica')) {
        try {
            await peticionFetch(`caracteristicas/${id}`, 'DELETE');

            const elementoCaracteristica = document.getElementById(`caracteristica-${id}`);
            if (elementoCaracteristica) {
                elementoCaracteristica.parentNode.removeChild(elementoCaracteristica);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
}

function generarcaracteristica() {
    let form = document.getElementById('formulario');
    let input = document.getElementById('generarInput');
    let container = document.getElementById('container');

    form.addEventListener('submit', async function(event){
        event.preventDefault();
        let caracteristica = input.value.trim();

        try {
            const data = await peticionFetch('caracteristicas', 'POST', { caracteristica: caracteristica });

            const nuevaCaracteristica = {
                id: data.id || data.caracteristica.id,
                nombre: caracteristica
            };

            const nuevoElemento = crearElementoCaracteristica(nuevaCaracteristica);
            container.appendChild(nuevoElemento);

            input.value = '';
        } catch (error) {
            console.error('Error:', error);
            alert("El nombre de la caracteristica no puede repetirse, contener carácteres especiales o estar vacío");
        }
    });
}