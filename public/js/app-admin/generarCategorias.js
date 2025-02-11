document.addEventListener('DOMContentLoaded', function(event){
    generarCategoria();
    generarTablas();
});

function generarTablas(){
    const container = document.getElementById('container');
    // Añadimos clases para mantener el mismo ancho que el formulario
    container.className = 'w-full max-w-[60%]';
    container.innerHTML = '';

    fetch('/api/categorias')
    .then(response => response.json())  
    .then(data => {
        data.forEach(categoria => {
            const categoriaDiv = document.createElement('div');
            // Añadimos w-full para que ocupe todo el ancho del contenedor
            categoriaDiv.className = 'w-full bg-[#1e2632] p-4 mb-2 rounded-lg flex justify-between items-center';

            const nombreCategoria = document.createElement('span');
            nombreCategoria.textContent = categoria.nombre_categoria;
            nombreCategoria.className = 'text-white';

            const deleteBtn = document.createElement('button');
            deleteBtn.textContent = '🗑️';
            deleteBtn.className = 'text-gray-500 hover:text-gray-400 p-1 transition-colors';

            deleteBtn.onclick = () => eliminarCategoria(categoria.id);

            categoriaDiv.appendChild(nombreCategoria);
            categoriaDiv.appendChild(deleteBtn);

            container.appendChild(categoriaDiv);
        });
    })
    .catch(error => console.error('Error al cargar las categorias:', error));
}


function eliminarCategoria(id){
    if(confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {

        fetch(`categorias/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if(response.ok) {
                generarTablas();
            } else {
                console.error('Error al eliminar la categoría');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function generarCategoria() {
    let form = document.getElementById('formulario');
    let input = document.getElementById('generarInput');
    form.addEventListener('submit', function(event){
        event.preventDefault();
        let categoria = input.value; // Declarar la variable categoria
        if(validarCategoria(categoria)){
            fetch('categorias', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', // Especificamos que el cuerpo es JSON
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // Token CSRF
                },
                body: JSON.stringify({ categoria: categoria }) // Enviar los datos en el cuerpo
            })
            .then(response => {
                if(response.ok) {
                    return response.json(); // Si la respuesta es exitosa, convertirla en JSON
                } else {
                    console.error('Error al crear la categoría');
                }
            })
            .then(data => {
                // Si la categoría fue creada correctamente, generar las tablas o hacer alguna acción
                generarTablas();
            })
            .catch(error => console.error('Error:', error));
        }
    });
}


function validarCategoria(categoria){
    return true
}