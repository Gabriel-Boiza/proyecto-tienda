document.addEventListener('DOMContentLoaded', function(event){
    generarCategoria();
    generarTablas();
});

function generarTablas(){
    const container = document.getElementById('container');
    container.className = 'w-full max-w-[60%]';
    container.innerHTML = '';

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
            editBtn.onclick = () => editarCategoria(categoria.id, inputCategoria.value);
        
            // Botón de eliminar
            const deleteBtn = document.createElement('button');
            deleteBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            `;
            deleteBtn.className = 'text-gray-400 hover:text-white p-1 transition-colors';
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
    // Validar la categoría antes de continuar
    if (!validarCategoria) return false;

    const url = `categorias/${id}`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    const opciones = {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ categoria: nuevoNombre })
    };

    try {
        const response = await fetch(url, opciones);

        if (!response.ok) {throw new Error('Error al actualizar la categoría')}

        const data = await response.json();
        alert('Categoria editada correctamente')
        return data;
        
    } catch (error) {
        alert('Error al actualizar la categoría');
    }
}


function eliminarCategoria(id, container, div){
    if(confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
        fetch(`categorias/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if(!response.ok) {throw new Error('Error al actualizar la categoría')}
            container.removeChild(div)

        })
        .catch(error => console.error('Error:', error));
    }
}

function generarCategoria() {
    let form = document.getElementById('formulario');
    let input = document.getElementById('generarInput');
    let container = document.getElementById('container');

    form.addEventListener('submit', async function(event){
        event.preventDefault();
        let categoria = input.value.trim();
        
        if (!validarCategoria(categoria)) {
            alert("El nombre de la categoria no puede repetirse, contener carácteres especiales o estar vacío");
            return;
        }

        try {
            const response = await fetch('categorias', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ categoria: categoria })
            });

            const data = await response.json();

            if (!response.ok) {
                if (data.errors) {
                    alert(Object.values(data.errors).flat().join(' '));
                } else {
                    alert("Error al crear la categoría.");
                }
                return;
            }

            input.value = ''; // Limpiar input si todo sale bien
            generarTablas(); // Refrescar lista de categorías

        } catch (error) {
            console.error('Error:', error);
            alert("El nombre de la categoria no puede repetirse, contener carácteres especiales o estar vacío");
        }
    });
}

// Validación en frontend
function validarCategoria(categoria) {
    if (!categoria) {
        return false;
    }
    const regex = /^[a-zA-Z0-9\s]+$/; 
    return regex.test(categoria);
}


document.getElementById("formulario").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el envío inmediato

    const input = document.getElementById("generarInput");
    const nombreCategoria = input.value;

    // Lista de categorías actuales (esto debería ser dinámico, lo menciono solo como ejemplo)
    const categoriasExistentes = Array.from(document.querySelectorAll("#container div")).map(div => div.textContent.trim().toLowerCase());

    const resultado = validarCategoria(nombreCategoria, categoriasExistentes);

    if (!resultado.valido) {
        alert(resultado.mensaje);
        return; // No envía el formulario si hay errores
    }

    // Si no hay errores, continuar con el envío del formulario
    this.submit();
});
