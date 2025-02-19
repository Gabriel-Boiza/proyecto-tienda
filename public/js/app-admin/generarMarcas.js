document.addEventListener('DOMContentLoaded', function(event){
    generarMarca();
    generarTablas();
});

function generarTablas(){
    const container = document.getElementById('container');
    container.className = 'w-full max-w-[60%]';
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
            editBtn.textContent = '✏️';
            editBtn.className = 'text-gray-400 hover:text-white p-1 transition-colors';
            editBtn.onclick = () => editarCategoria(marca.id, inputCategoria.value);
        
            // Botón de eliminar
            const deleteBtn = document.createElement('button');
            deleteBtn.textContent = '🗑️';
            deleteBtn.className = 'text-gray-400 hover:text-white p-1 transition-colors';
            deleteBtn.onclick = () => eliminarCategoria(marca.id);
        
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
        generarTablas(); // Refresca la tabla tras la actualización
        return data;
        
    } catch (error) {
        alert('Error al actualizar la categoría');
    }
}


function eliminarCategoria(id){
    if(confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
        fetch(`marcas/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if(!response.ok) {throw new Error('Error al actualizar la categoría')}
            generarTablas();

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

