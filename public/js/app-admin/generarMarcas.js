document.addEventListener('DOMContentLoaded', function(event){
    generarMarca();
    generarTablas();
});

function generarTablas(){
    const container = document.getElementById('container');
    container.className = 'w-full md:max-w-[60%]';
    container.innerHTML = '';

    fetch('/api/marcas')
    .then(response => response.json())  
    .then(data => {
        data.forEach(marca => {
            const categoriaDiv = document.createElement('div');
            categoriaDiv.className = 'w-full bg-zinc-800/50 p-4 mb-2 rounded-lg flex justify-between items-center';
        
            // Crear input en lugar de span
            const inputCategoria = document.createElement('input');
            inputCategoria.type = 'text';
            inputCategoria.value = marca.nombre;
            inputCategoria.className = 'bg-transparent text-gray-300 focus:outline-none w-full';
        
            // Contenedor para los botones
            const botonesContainer = document.createElement('div');
            botonesContainer.className = 'flex gap-2';
        
            // Botón de editar
            const editBtn = document.createElement('button');
            editBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
            `;
            editBtn.className = 'text-gray-400 hover:text-white p-1 transition-colors';
            editBtn.onclick = () => editarCategoria(marca.id, inputCategoria.value);
        
            // Botón de eliminar
            const deleteBtn = document.createElement('button');
            deleteBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            `;
            deleteBtn.className = 'text-gray-400 hover:text-white p-1 transition-colors';
            deleteBtn.onclick = () => eliminarCategoria(marca.id, container, categoriaDiv);
        
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
    // Validar la categoría antes de continuar

    const url = `marcas/${id}`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    const opciones = {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ marca: nuevoNombre })
    };

    try {
        const response = await fetch(url, opciones);

        if (!response.ok) {throw new Error('Error al actualizar la categoría')}

        const data = await response.json();
        alert('Marca actualizada correctamente')
        return data;
        
    } catch (error) {
        alert('Error al actualizar la categoría');
    }
}


function eliminarCategoria(id, container, div){
    if(confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
        fetch(`marcas/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if(!response.ok) {throw new Error('Error al actualizar la categoría')}
            container.removeChild(div);

        })
        .catch(error => console.error('Error:', error));
    }
}

function generarMarca() {
    let form = document.getElementById('formulario');
    let input = document.getElementById('generarInput');
    
    form.addEventListener('submit', function(event){
        event.preventDefault();
        let marca = input.value;

        fetch('marcas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ marca: marca })
        })
        .then(response => {
            if(!response.ok) {throw new Error('Error al actualizar la categoría')}
        })
        .then(data => {
            generarTablas();
        })
        .catch(error => console.error('Error:', error));
        
    });
}

